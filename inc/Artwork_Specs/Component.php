<?php
/**
 * WP_Rig\WP_Rig\Artwork_Specs\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Artwork_Specs;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use WP_Post;
use function add_action;
use function add_filter;
use function get_theme_file_uri;
use function get_theme_file_path;
use function get_the_category;
use function wp_enqueue_script;
use function wp_localize_script;




/**
 * Class for all things related to Artwork Spcifications.
 *
 * Exposes template tags:
 * * `wp_rig()->the_comments( array $args = [] )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'artwork_specs';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		// add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_related_posts_script' ] );
		// add_action( 'after_setup_theme', [ $this, 'action_add_image_sizes' ] );
	}

	/**
	 * Output Acceptabe Graphic Formats
	 */
	private function get_acceptable_filetypes() : array {
		return [
			'ai'   => 'Adobe Illustrator',
			'eps'  => 'Encapsulated Postscript',
			'cdr'  => 'Corel Draw',
			'jpeg' => 'Joint Photographic Experts Group',
			'tiff' => 'Tagged Image File Format',
			'psd'  => 'Photoshop Document',
			'svg'  => 'Scalable Vector Graphic',
			'png'  => 'Portable Network Graphic',
		];
	}

	/**
	 * Get the URI of the path to the filetype icons.
	 */
	public function get_filetype_icons_dir() : string {
		return trailingslashit( get_theme_file_uri( '/assets/images/filetype_icons' ) );
	}


	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return [
			'get_filetype_icons_dir' => [ $this, 'get_filetype_icons_dir' ],
			'get_filetype_html'      => [ $this, 'get_filetype_html' ],
			'get_filetypes_section'  => [ $this, 'get_filetypes_section' ],
			'get_specs_for_digital'  => [ $this, 'get_specs_for_digital' ],
			'get_specs_for_static'   => [ $this, 'get_specs_for_static' ],
		];
	}

	/**
	 * Outputs the html instructions regarding digital billboard specifications.
	 */
	public function get_specs_for_digital() : string {
	$output = <<<DIGISPECS
	Create file to the following size: 1400 pixels wide by 400 pixels high.
	<abbr title="Red Green Blue Color Format">RGB</abbr>Color Format, at least 72 <abbr title="Dots Per Inch">DPI</abbr> in resolution. Saved as a maximum resolution <abbr title="Joint Photographic Experts Group">JPG</abbr> file.
DIGISPECS;
	}

	/**
	 * Outputs the html instructions regarding static billboard specifications.
	 */
	public function get_specs_for_static() : string {
		$sizing     = [
			'headline'      => 'Scale Artwork at a rate of 1/4" to 1\'',
			'bullet_points' => [
				'14\' x 48\' billboard at 1/4" scale = 3.5" x 12" graphic',
				'10\' x 30\' billboard at 1/4" scale = 2.5" x 7.5" graphic',
			]
		];
		$resolution = [
			'headline'      => 'Resolution: 300 <abbr title="Dots Per Inch">DPI</abbr> or higher',
			'bullet_points' => [],
		];
		$color      = [
			'headline'      => '<abbr title="CMYK refers to the 4 ink plates used in color printing - Cyan, Magenta, Yellow, & key">CMYK</abbr> Color Format',
			'bullet_points' => [
				'To ensure color accuracy, please provide <abbr title="Pantone Matching System">PMS</abbr> numbers for each color.',
			],
		];
		$sending    = [
			'headline'      => 'Sending Files',
			'bullet_points' => [
				'Files less than 10mb can be emailed directly to crutchik@jonessign.com. Files in excess of 10mb have a tendency to corrupt our servers, so please use a free delivery FTP site such as <a href="https://www.hightail.com/" title="link to the Hightail Home Page"> Hightail</a> or <a href="http://www.dropbox.com" title="link to the Dropbox Home Page">DropBox</a> to upload your art and use crutchik@jonessign.com as your receiver.',
			],
		];
		$notes      = [
			'headline'      => 'Additional Important Notes',
			'bullet_points' => [
				'Web graphics are most often 72dpi (this is changing with the retina displays) and lack enough resolution to make a niceₒ looking large-scale graphic. Certain web sites offer higher resolution images for download. If the file size is 300dpi or higher, then Jones Outdoor will be able to accept them',
				'<li>To ensure no typographical incompatibilities, Please take the step of <a href="http://www.graphic-design-employment.com/adobe-illustrator-how-to-convert.html">converting all type into paths</a> within your final artwork</li>',
				'An allowance for the bleed is unnecessary. Viewing size is the same as the actual billboard size',
			],
		];
		}

	/**
	 * Outputs the filetype icon in an 'img' tag
	 */
	public function get_filetype_html( $key, $value ) : string {
		$path = $this->get_filetype_icons_dir();
		return "<a href=\"#\" class=\"acceptable_filetypes\" title=\"$value\"><img class=\"h-16\" src=\"$path$key.png\" alt=\"$value\" /></a>";
	}

	/**
	 * Outputs the Acceptable Filetsypes section.
	 *
	 */
	public function get_filetypes_section() : string {
		$filetypes = $this->get_acceptable_filetypes();
		$output    = '<section class="w-full flex flex-row flex-wrap bg-indigo-600 justify-center items-center content-around">';
		foreach ( $filetypes as $key => $value ) {
			$output .= $this->get_filetype_html( $key, $value );
		}

		$output .= '</section>';

		return $output;
	}
}
