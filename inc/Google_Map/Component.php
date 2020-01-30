<?php
/**
 * WP_Rig\WP_Rig\Google_Maps\Component class
 *
 * @package wp_rig
 */

// phpcs:disable WordPress.WP.EnqueuedResourceParameters.MissingVersion
namespace WP_Rig\WP_Rig\Google_Map;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function add_filter;
use function wp_register_script;
use function wp_enqueue_script;
use function wp_enqueue_scripts;
use function get_theme_file_uri;
use function wp_localize_script;
use function is_front_page;

/**
 * Class for displaying a Google Map.
 *
 * Exposes template tags:

 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface {


	/**
	 * The Google maps api Key.
	 * NOTE: In the interest of not having the key all over github, I've saved it as a constant in the wp-config.php file.
	 *
	 * @return string Google API Key for MAPS and FORMS.
	 */
	private function get_google_apikey() : string {
		return GOOGLE_MAPS_API;
	}

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'google_map';
	}

	/**
	 * Get the url of the javascript file to call that will instantiate the map
	 */
	private function get_url_call() : string {
		$api_key = $this->get_google_apikey();
		return "https://maps.googleapis.com/maps/api/js?key={$api_key}&callback=initMap";
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_google_map_javascript' ] );
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
			'output_the_map_element' => [ $this, 'output_the_map_element' ],
		];
	}

	/**
	 * Enqueue script that outputs a google map with all the billboard locations.
	 */
	public function enqueue_google_map_javascript() {
		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		if ( is_front_page() ) {

			$dependency_array = [ 'google-map-style', 'google-map-locations', 'google-map-core' ];
			foreach ( $dependency_array as $handle ) {
				$uri = get_theme_file_uri( '/assets/js/' . preg_replace( '/-/i', '_', $handle ) . '.min.js' );
				$ver = 'developement' === ENVIRONMENT ? wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/' . preg_replace( '/-/i', '_', $handle ) . '.js' ) ) : '20200119';
				wp_register_script( $handle, $uri, array(), $ver, false );
			}

			wp_enqueue_script( 'google-map-api-call', $this->get_url_call(), $dependency_array, null, true );

			// Supply array of data to a js file. File was enqueued earlier in the function using the mapData object.
			$data_to_pass = [
				'apiKey'           => $this->get_google_apikey(),
				'center'           => [
					'lat' => 44.529364,
					'lng' => -88.117770,
				],
				'jonesCoordinates' => [
					'lat' => 44.429640,
					'lng' => -88.117770,
				],
				'iconSize'         => '64',
				'iconDir'          => get_theme_file_uri( '/assets/images/markers/' ),
				'zoomLevel'        => '8',
				'streetViewSize'   => 460,
			];
			wp_localize_script( 'google-map-core', 'mapData', $data_to_pass );
		}
	}
	/**
	 * Displays the google map.
	 *
	 * Internally this method calls GOOGLE_MAPS_API. This is the api key that is set up with google and must remain hidden from the public.
	 * It must not be added manually for that reason. The method will also take care of generating the
	 * necessary markup for the map.
	 */
	public function output_the_map_element() {
		$map_section = '
		<h2 class="mt-2 mb-2 mx-auto text-5 xl"> Our locations </h2>
		<section id="map-container" class="bg-indigo-500" style="min-height: 80px;>
			<div id="map"></div><!-- end div#map -->
		</section><!-- end section#map-container -->';
		return wp_kses( $map_section, 'post' );
	}

}
