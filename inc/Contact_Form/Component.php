<?php
/**
 * WP_Rig\WP_Rig\Contact_Form\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Contact_Form;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function wp_enqueue_script;

/**
 * Class for adding in a contact form.
 *
 * Exposes template tags:
 * * `wp_rig()->return_contact_form_open_tag()`
 * * `wp_rig()->return_contact_form_closing_tag()`
 * * `wp_rig()->get_form_classes()`
 * * `wp_rig()->return_form_fields()`
 * * `wp_rig()->has_my_cpt_been_activated()`
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'contact_form';
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
			'return_contact_form_open_tag'      => [ $this, 'return_contact_form_open_tag' ],
			'return_contact_form_closing_tag'   => [ $this, 'return_contact_form_closing_tag' ],
			'get_form_classes'                  => [ $this, 'get_form_classes' ],
			'return_form_fields'                => [ $this, 'return_form_fields' ],
			'has_my_cpt_been_activated'         => [ $this, 'has_my_cpt_been_activated' ],
			'return_contact_form_submit_button' => [ $this, 'return_contact_form_submit_button' ],
			'get_expected_fields'               => [ $this, 'get_expected_fields' ],
			'get_required_fields'               => [ $this, 'get_required_fields' ],
			'get_textarea_field_attributes'     => [ $this, 'get_textarea_field_attributes' ],
			'issue_warning'                     => [ $this, 'issue_warning' ],
			'retain_value'                      => [ $this, 'retain_value' ],
		];
	}

	/**
	 * Sanitize an inputs value so it can be reshown.
	 *
	 * @param string $value What the user has entered into the field.
	 */
	public function retain_value( $value ) {
		$value = stripslashes( esc_attr( $value ) );
		return ' value="' . $value . '"';
	}

	/**
	 * Output a warning span
	 *
	 * @param string $input Text of the 'Hint' or 'Error'.
	 */
	public function issue_warning( $input ) : string {
		return '<span class="warning">' . esc_html( $input ) . '</span>';
	}

	/**
	 * Post Type for the form.
	 *
	 * @var string Type of post that incoming forms should be considered.\
	 */
	public $post_type = 'inquiry';

	/**
	 * Form Classes
	 *
	 * @return string The css class for the form using tailwindcss.
	 */
	public function get_form_classes() : string {
		return 'sm:w-screen md:w-3/4 lg:w-2/3 xl:w-1/2 shadow mx-auto p-8 mx-auto bg-blur';
	}

	/**
	 * Get the class for the labels
	 *
	 * @return string the css classes for the label.
	 */
	public function get_label_class() : string {
		return 'block text-gray-700 text-xs md:text-sm font-bold mb-2';
	}

	/**
	 * Input Class
	 *
	 * @var string The css class for the form input fields.
	 */
	public $inputclass = 'tailwind-input';

	/**
	 * Input Class
	 *
	 * @var string form action
	 */
	protected function get_form_action() {
		return $_SERVER['PHP_SELF'];
	}

	/**
	 * ID of the form.
	 *
	 * @var string The id of the form.
	 */
	public $form_id = 'inquiryForm';

	/**
	 * Return all classes as a string
	 *
	 * @param array $classes Classes for the element.
	 * @return string the css classes
	 */
	private function get_classes_as_string( array $classes ) : string {
		return implode( ' ', $classes );
	}

	/**
	 * Determines whether the 'inquiries' post type is active and if it is, returns true.
	 *
	 * @return boolean
	 */
	public function has_my_cpt_been_activated() {
		if ( post_type_exists( $this->post_type ) ) {
			$output = site_url() . '<h3> Inquiry post Type exists</h3>';
		} else {
			$output = '<h3>Inquiry post type does not exist</h3>';
		}
		return $output;
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 * add_action( 'after_setup_theme', [ $this, 'create_contact_form' ] );
	 * add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_secondary_contact_form_javascript' ] );
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', [ $this, 'get_contact_form_frontpage_script' ] );
	}

	/**
	 * Enqueue javascript for the frontpage contact form.
	 */
	public function get_contact_form_frontpage_script() {
		$handle       = 'frontpage-contact-form-tailwind';
		$src          = get_theme_file_uri( '/assets/js/src/frontpage_contact_form.js' );
		$version      = 'development' === ENVIRONMENT ? wp_rig()->seconds_from_epoch() : '20200102'; // check to see whether this is the development or production version by seeing how the ENVIRONMENT constant on wp-config.php is set.
		$dependencies = array();
		$in_footer    = true;
		// Only get this javascript if it is the frontpage -- can and maybe should alter this to beging is_home() as well.
		if ( is_front_page() ) {
			wp_enqueue_script( $handle, $src, $dependencies, $version, $in_footer );
		}
	}

	/**
	 * Get the html attributes for the html '<input>' button.
	 */
	public function get_input_button_attributes() : array {
		$attributes = [
			'form'  => 'testform',
			'class' => 'button_hide btn',
			'type'  => 'submit',
			'name'  => 'submit',
			'id'    => 'testformButton',
			'value' => 'Submit',
		];
		return $attributes;
	}


	/**
	 * Return contact form button with attributes.
	 *
	 * @param array $attributes The attributes that go insude the '<input>' tag.
	 */
	public function return_contact_form_submit_button( $attributes = [] ) : string {
		$output     = '<input';
		$attributes = $this->get_input_button_attributes();
		foreach ( $attributes as $attribute => $value ) {
			$output .= ' ' . $attribute . '="' . $value . '"';
			$output .= "\r";
		}
		$output .= '>';
		$output .= '</input> ';
		return $output;
	}


	/**
	 * Return opening html tag for the <form action="
	 *
	 * @return string opening html tag for form.
	 */
	public function return_contact_form_open_tag() : string {
		$output = '<form id="testform" class="' . $this->get_form_classes() . '" name="testform" action="' . $this->get_form_action() . '" method="POST" >';
		return $output;
	}

	/**
	 * Return closing html tag for the form
	 *
	 * @return string closing html tag for form.
	 */
	public function return_contact_form_closing_tag() : string {
		return '</form>';
	}

	/**
	 * Returns the form fields and attributes as an array.
	 *
	 * @return array $form_fields The form fields and attributes.
	 */
	public function return_form_fields() : array {
		$field_names = [
			'fullname' => [
				'class'       => $this->inputclass,
				'error'       => 'Enter First &amp; Last Name',
				'hint'        => 'Enter Your Full Name Here',
				'id'          => '',
				'label_class' => $this->get_label_class(),
				'label_text'  => 'What is Your Full Name?',
				'mode'        => 'text',
				'name'        => 'fullname',
				'req'         => true,
				'type'        => 'text',
				'value'       => '',
			],
			'company'  => [
				'class'       => $this->inputclass,
				'error'       => 'Enter Your Company Name',
				'hint'        => 'Enter Your Company Name',
				'id'          => '',
				'label_class' => $this->get_label_class(),
				'label_text'  => 'What Company are You With?',
				'mode'        => 'text',
				'name'        => 'company',
				'req'         => true,
				'type'        => 'text',
				'value'       => '',

			],
			'jobtitle' => [
				'class'       => $this->inputclass,
				'error'       => '',
				'hint'        => 'Enter Job Title Here',
				'id'          => '',
				'label_text'  => 'What is Your Job Title?',
				'label_class' => $this->get_label_class(),
				'mode'        => 'text',
				'name'        => 'jobtitle',
				'req'         => false,
				'type'        => 'text',
				'value'       => '',
			],
			'email'    => [
				'class'       => $this->inputclass,
				'error'       => 'Enter Your Email Address',
				'hint'        => 'Enter Your Email Address',
				'id'          => '',
				'label_text'  => 'What is Your email?',
				'label_class' => $this->get_label_class(),
				'mode'        => 'email',
				'name'        => 'email',
				'req'         => true,
				'type'        => 'email',
				'value'       => '',
			],
			'message'  => [
				'class'       => $this->inputclass,
				'error'       => 'Please add your Message',
				'hint'        => 'Add Your Message Here',
				'id'          => '',
				'label_class' => $this->get_label_class(),
				'label_text'  => 'What is Your Message?',
				'mode'        => 'text',
				'name'        => 'message',
				'req'         => true,
				'type'        => 'textarea',
				'value'       => '',
			],
			'addthese' => [
				'class'       => $this->inputclass,
				'error'       => 'Add these two numbers so we know you aren not a spambot',
				'hint'        => '',
				'id'          => 'addthese',
				'label_class' => '',
				'label_id'    => 'addTheseLabel',
				'label_text'  => '',
				'mode'        => 'text',
				'name'        => 'addthese',
				'req'         => true,
				'type'        => 'text',
				'value'       => '',
			],
		];
		return $field_names;
	}

	/**
	 * Get the attributes for the 'message' textarea field.
	 */
	public function get_textarea_field_attributes() {
		return [
			'class'       => $this->inputclass,
			'error'       => 'Please add your Message',
			'hint'        => 'Add Your Message Here',
			'id'          => '',
			'label_class' => $this->get_label_class(),
			'label_text'  => 'What is Your Message?',
			'mode'        => 'text',
			'name'        => 'message',
			'req'         => true,
			'type'        => 'textarea',
			'value'       => '',
		];
	}

	/**
	 * Get expected fields from the contact form.
	 */
	public function get_expected_fields() : array {
		$output = [];
		$fields = $this->return_form_fields();
		foreach ( $fields as $field => $attribute ) {
			$output[] = $attribute['name'];
		}
		return $output;
	}

	/**
	 * Get required fields from the contact form.
	 */
	public function get_required_fields() : array {
		$output = [];
		$fields = $this->return_form_fields();
		foreach ( $fields as $field => $attribute ) {
			if ( true === $attribute['req'] ) {
				$output[] = $attribute['name'];
			}
		}
		return $output;
	}

}
