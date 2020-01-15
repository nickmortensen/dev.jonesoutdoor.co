/* eslint-env es6 */
'use strict';

/**
 * External dependencies
 */
import { src, dest } from 'gulp';
import tailwindcss from 'tailwindcss';
import postcssPresetEnv from 'postcss-preset-env';
import AtImport from 'postcss-import';
import pump from 'pump';
import cssnano from 'cssnano';
import stylelint from 'stylelint';
import reporter from 'postcss-reporter';
import calc from 'postcss-calc';
import { pipeline } from 'mississippi';

/**
 * Internal dependencies
 */
import { rootPath, paths, gulpPlugins, isProd } from './constants';
import {
	getThemeConfig,
	getStringReplacementTasks,
	logError,
	configValueDefined,
	appendBaseToFilePathArray,
} from './utils';
import { server } from './browserSync';

export function stylesBeforeReplacementStream() {
	// Return a single stream containing all the
	// before replacement functionality
	return pipeline.obj( [
		logError( 'CSS' ),
		gulpPlugins.newer( {
			dest : paths.styles.dest,
			extra: [ paths.config.themeConfig ],
		} ),
		gulpPlugins.phpcs( {
			// bin            : `${ rootPath }/vendor/bin/phpcs`,
			bin            : '/Users/nickmortensen/.composer/vendor/bin/phpcs',
			// standard       : 'WordPress',
			standard       : 'mortensen',
			warningSeverity: 0,
		} ),
		// Log all problems that were found.
		gulpPlugins.phpcs.reporter( 'log' ),
	] );
}

const stylelintrules = {
	extends: "/usr/local/lib/node_modules/stylelint-config-wordpress",
	ignoreFiles: [
		`${rootPath}/assets/css/src/tailwind/tailwind.css`,
		`${rootPath}/assets/css/src/tailwind/source/_tailwind.css`
	],
	rules: {
		"at-rule-no-unknown": [
			true,
			{
				ignoreAtRules: [
				"custom-media",
				"/^custom/"
			]
			}
		],
		"no-descending-specificity": null,
		"no-duplicate-selectors"   : null,
		"comment-empty-line-before": [
			"always",
			{
				ignore: ["after-comment", "stylelint-commands"]
			}
		],
		"at-rule-empty-line-before": [ "always", {
				"except": [ "first-nested" ]
			 }
		],
		"rule-empty-line-before": [
			"always",
			{
				"ignore": ["after-comment","first-nested", "inside-block"]
			}
		],
		"value-list-comma-newline-after": "always-multi-line",
		"block-opening-brace-newline-after": [
			"always"
		],
		"block-closing-brace-newline-before": [
			"always"
		]
    }
};

export function stylesAfterReplacementStream() {
	const config = getThemeConfig();

	const postcssPlugins = [
		stylelint( stylelintrules ),
		postcssPresetEnv( {
			importFrom: (
				configValueDefined( 'config.dev.styles.importFrom' ) ?
					appendBaseToFilePathArray( config.dev.styles.importFrom, paths.styles.srcDir ):
					[]
			),
			stage: (
				configValueDefined( 'config.dev.styles.stage' ) ?
					config.dev.styles.stage:
					3
			),
			autoprefixer: (
				configValueDefined( 'config.dev.styles.autoprefixer' ) ?
					config.dev.styles.autoprefixer:
					{}
			),
			features: (
				configValueDefined( 'config.dev.styles.features' ) ?
					config.dev.styles.features:
					{
						'custom-media-queries': {
							preserve: false,
						},
						'custom-properties': {
							preserve: true,
						},
						'nesting-rules': true,
					}
			),
		} ),
		calc( {
			preserve: false,
		} ),
		tailwindcss(`${rootPath}/gulp/tailwind.js`),
		cssnano(),
	];

	// Skip minifying files if we aren't building for
	// production and debug is enabled
	if ( config.dev.debug.styles && ! isProd ) {
		postcssPlugins.pop();
	}

	// Report messages from other postcss plugins
	postcssPlugins.push(
		reporter( { clearReportedMessages: true } )
	);

	// Return a single stream containing all the
	// after replacement functionality
	return pipeline.obj( [
		gulpPlugins.postcss( [
			AtImport( {
				path   : [ paths.styles.srcDir ],
				plugins: [
					stylelint(),
				],
			} ),
		] ),
		gulpPlugins.postcss( postcssPlugins ),
		gulpPlugins.if(
			config.dev.debug.styles,
			gulpPlugins.tabify( 2, true )
		),
		gulpPlugins.rename( {
			suffix: '.min',
		} ),
		server.stream( { match: '**/*.css' } ),
	] );
}

/**
* CSS via PostCSS + CSSNext (includes Autoprefixer by default).
* @param {function} done function to call when async processes finish
* @return {Stream} single stream
*/
export default function styles( done ) {
	return pump( [
		src( paths.styles.src, { sourcemaps: ! isProd } ),
		stylesBeforeReplacementStream(),
		// Only do string replacements when building for production
		gulpPlugins.if(
			isProd,
			getStringReplacementTasks()
		),
		stylesAfterReplacementStream(),
		dest( paths.styles.dest, { sourcemaps: ! isProd } ),
	], done );
}
