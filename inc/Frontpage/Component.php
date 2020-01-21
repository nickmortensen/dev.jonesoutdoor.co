<?php
/**
 * WP_Rig\WP_Rig\Contact_Form\Frontpage class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Frontpage;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function wp_enqueue_script;
use function add_theme_support;
use function apply_filters;
use function wp_parse_args;
use function the_permalink;
use function do_shortcode;
use function wp_script_add_data;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_localize_script;


/**
 * @var $reasons_why_post_ids
 * get_slug
 * initialize
 * template_tags
 * display_contact_form
 * create_contact_form
 * wrap_all_fields_opening_div_tag
 * wrap_all_fields_closing_div_tag
 */
/**
 * Class for adding a contact form.
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Reasons why Outdoor Post IDS
	 *
	 * @var array $reasons_why_post_ids Post IDs for the reasons why outdoor is good.
	 */
	private $reasons_why_post_ids = [ 104, 105, 106 ];

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'frontpage';
	}

	/**
	 * Returns a list of gradient options.
	 *
	 * @return array Gradient options.
	 */
	public function get_gradients() : array {
		$gradients = [ 'rainbow', 'horizon', 'rosewater', 'bloodymary', 'aubergine', 'aquamarine', 'sunrise', 'purple', 'seaweed', 'steelgray', 'mirage', 'reef', 'stellar' ];
		return $gradients;
	}

	/**
	 * Return a random gradient from the list of gradients.
	 *
	 * @return string Component slug.
	 */
	public function chosen_gradient() : string {
		$gradients = $this->get_gradients();
		$count     = count( $this->get_gradients() );
		$i         = wp_rand( 0, $count - 1 );
		return $gradients[ $i ] . '-gradient';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', [ $this, 'create_why_outdoor_section' ] );
		add_action( 'after_setup_theme', [ $this, 'create_reasons_why_section' ] );
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
			'display_why_outdoor_section' => [ $this, 'display_why_outdoor_section' ],
			'display_reasons_why_section' => [ $this, 'display_reasons_why_section' ],
			'chosen_gradient'             => [ $this, 'chosen_gradient' ],
		];
	}

	/**
	 * Display the create_why_outdoor_section;
	 */
	public function display_why_outdoor_section() {
		echo wp_kses( $this->create_why_outdoor_section(), 'post' );
	}

	/**
	 * Display the Reasons Why Section;
	 */
	public function display_reasons_why_section() {
		echo wp_kses( $this->create_reasons_why_section(), 'post' );
	}

	/**
	 * Create a why outdoor section.
	 *
	 * @return string All the HTML for the Why Outdoor? section of the frontpage.
	 */
	public function create_why_outdoor_section() {
		$why_outdoor_html = <<<WHY
		<!-- WHY -->
		<div id="why-outdoor" class="text-center w-full pb-16">
			<h3 class="text-4xl md:text-2xl text-gray-600">Why Outdoor?</h3>
			<p class="text-3xl font-light text-gray-700 pt-4 w-10/12 xl:w-2/3 mx-auto">
			No matter what their media consumption habits are, <span class="text-blue-600 font-bold">Outdoor reaches customers</span>.
			</p>
		</div>
WHY;
		return $why_outdoor_html;
	}

	/**
	 * Create the columns that go inside the reasons-why-outdoor section.
	 *
	 * @return string $post_html The 3 reasons displayed as html.
	 */
	private function create_reasons_why_columns() {
		$posts   = $this->reasons_why_post_ids;
		$reasons = [];
		foreach ( $posts as $post ) {
			$content    = get_post_field( 'post_content', $post );
			$identifier = $post;
			$post_title = get_the_title( $identifier );
			$icon       = get_post_meta( $identifier, 'material_icon', true );
			$post_html  = <<<REASON
			<!-- REASON -->
			<div class="w-screen flex flex-col pt-4 px-16 lg:px-1 lg:pt-2 justify-center align-center lg:justify-start">
				<div class="flex flex-col justify-center align-center items-center pb-4 mx-auto">
					<i class="material-icons text-3xl">$icon </i>
					<h4 class="font-normal text-2xl text-black items-center">$post_title</h4>
				</div>
				$content
			</div>
REASON;
			$reasons[]  = $post_html;
		} // End foreach.
		return implode( '', $reasons );
	} // End function definition.

	/**
	 * Return the whole 'Reasons Why Outdoor' section.
	 * Note that it is 3 columns on larger screens and just one column on smaller screens.
	 *
	 * @return string $output The HTML output.
	 */
	public function create_reasons_why_section() {
		$output  = '<section id="reasons" class="w-screen flex flex-col xl:flex-row justify-start align-top justify-center mx-auto pb-8">';
		$output .= $this->create_reasons_why_columns();
		$output .= '</section><!-- end section#reasons -->';
		return $output;
	}

	/**
	 * Display a sample bit of content
	 */
	public function display_workcation_section() {
		$logo       = get_template_directory_uri() . '/assets/images/workcation_logo.svg';
		$beach      = get_template_directory_uri() . '/assets/images/beach-work.jpg';
		$workcation = <<<CONTENT
		<!-- workcation is tutorial on tailwind -->
		<div id="workcation" class="bg-gray-300 px-8">
			<div class="flex bg-gray-100">

				<div class="px-8 py-16 max-w-md sm:max-w-xl mx-auto lg:max-w-full lg:w-1/2 lg:py-24 lg:px-12 lg:text-3xl">
					<div class="xl:max-w-5xl xl:ml-auto">
						<img class="h-10" src="$logo" alt="logo" />
						<img class="mt-6 rounded-lg shadow-xl sm:mt-8 sm:h-64 sm:w-full sm:object-center sm:object-cover lg:hidden" src="$beach" alt="beach-work">
						<h1 class="mt-6 text-2xl font-semibold text-gray-900 leading-tight sm:text-4xl sm:mt-8"> You can work from anywhere. <br class="hidden lg:inline">
							<span class="text-indigo-500">Take advantage of it.</span>
						</h1>
						<p class="mt-2 text-gray-600 text-xl sm:mt-4">
							workcation helps you find work-friendly rentals in beautiful locations so you can enjoy the nice weather even when you are not on vacation
						</p>
						<div class="mt-4 sm:mt-6">
							<a id="bunny" type="text" href="#" class="btn sm:text-base shadow-lg">
						book your escape
							</a>
						</div>
					</div>
				</div>

				<div class="hidden lg:block lg:w-1/2 lg:relative">
					<img class="absolute inset-0 h-full w-full object-cover object-center" src="$beach" alt="beach-work.jpg" />
				</div>

			</div>
		</div><!-- end div#workcation -->
CONTENT;
	echo wp_kses( $workcation, 'post' );
	} // END def  function display_workcation_section().

} // end component class definition.
