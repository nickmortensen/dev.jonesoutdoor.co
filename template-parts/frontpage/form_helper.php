<?php
// phpcs:disable Generic.PHP.DisallowShortOpenTag.EchoFound, WordPress.Security.EscapeOutput.OutputNotEscaped, Generic.PHP.DisallowShortOpenTag.EchoFound
// phpcs:disable WordPress.Security.NonceVerification.Missing
/**
 * Helper Function and variables for the contact form.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$suspect     = false;
$pattern     = '/Content-type: |Bcc: |Cc: /i';
$missing     = [];
$form_errors = [];
$fields      = wp_rig()->return_form_fields();
$expected    = wp_rig()->get_expected_fields();
$required    = wp_rig()->get_required_fields();
// 'submit is the name attribute of the send button for this form.
/**
 * Determine whether there is a suspect by inspecting the $_POST array.
 *
 * @param string $value The email address that the user passes.
 * @param string $pattern The perl compatible regular expression to check against.
 * @param bool   $suspect The item.
 */
function is_this_suspect( $value, $pattern, &$suspect ) {
	if ( is_array( $value ) ) {
		foreach ( $value as $item ) {
			is_this_suspect( $item, $pattern, $suspect );
		}
	} else {
		if ( preg_match( $pattern, $value ) ) {
			$suspect = true;
		}
	}
}

// Call the function right away using the $_POST Array.
is_this_suspect( $_POST, $pattern, $suspect );

// If there aren't any fields with entries to be suspicious of, then we can run the foreach loop.
if ( ! $suspect ) {
	foreach ( $_POST as $key => $value ) {
		$value = is_array( $value ) ? $value : trim( $value ); // remove leading and trailing spaces.
		if ( empty( $value ) && in_array( $key, $required, true ) ) {
			$missing[] = $key; // Assign the name of the form field to the missing array.
			$$key      = ''; // Using a variable variable, we will create a variable of the fieldname and set it to empty.
		} elseif ( in_array( $key, $expected, true ) ) {
			$$key = $value; // Create same field based on fieldname with the value.
		} // end if/elseif.
	} // end foreach.

	// Validate user's email.
	if ( ! $missing && ! empty( $email ) ) {
		// @link https://www.php.net/manual/en/function.filter-input.php
		$valid_email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );

		if ( $valid_email ) {
			$headers[] = "Reply-to: $valid_email";
		} else {
			$form_errors['email'] = true;
		} //end if/else.

		// If no $form_errors -> create headers and message body.
		if ( ! $form_errors && ! $missing ) {
			$headers = implode( "\r\n", $headers );
		} else {
			return;
		} // end if / else.
	}//end if.
}
// End if.


$outgoing_server = 'jonesoutdoor.co';
$ports           = [
	'address'         => [
		'incoming_testmail_one@jonesoutdoor.co',
		'incoming_testmail_two@jonesoutdoor.co',
	],
	'pass'            => TESTMAIL_PASSWORD,
	'jonesoutdoor.co' => [
		'incoming' => [
			'imap' => 993,
			'pop3' => 995,
		],
		'outgoing' => [
			'smtp' => 465,
		],
	],
	'non-ssl'         => [
		'incoming' => [
			'server' => [ 'mail.jonesoutdoor.co' ],
			'imap'   => 143,
			'pop3'   => 110,
		],
		'outgoing' => [
			'server' => 'mail.jonesoutdoor.co',
			'smtp'   => 26,
		],
	],

];


/**
 * Get a single field from the form.
 *
 * @param array $field Array of attributes for this field.
 */

/*
Commented out
function get_the_single_field( $field, $missing, $form_errors ) {
$value = '';
if ( $_POST && isset( $_POST[ $field['name'] ] ) ) {
$value = $_POST[ $field['name'] ];
}

echo "<h2> $value </h2>";
$mode        = $field['mode'];
$class       = $field['class'];
$error       = $field['error'];
$label_class = $field['label_class'];
$fieldname   = $field['name'];
$required    = $field['req'];
$label_text  = $field['label_text'];
$type        = $field['type'];
if ( true === (bool) $required ) :
$required = ' required';
endif;
$output  = '';
$output .= '<!-- ' . strtoupper( $fieldname ) . ' -->' . "\r";
$output .= '<div class="mb-4 input_holders">';
$output .= "\r\t";
$output .= '<label';
$output .= "\r\t";
$output .= array_key_exists( 'label_id', $field ) ? ' id="' . $field['label_id'] . '"' : '';
$output .= ' class="' . esc_attr( $label_class ) . ' ' . "\r\t" . ' for="' . esc_attr( $fieldname ) . '"';
$output .= '>';
$output .= esc_html( $label_text )if ( true === (bool) $field['req'] && ( $form_errors || $missing ) ) {
	$output .= wp_rig()->issue_warning( $error );
}
$output .= "</label>\r\t <!-- end label for $fieldname input -->";
$output .= "\n\t";
$output .= '<input';
$output .= "\n\t";
$output .= ' id="' . esc_attr( $fieldname ) . '"';
$output .= "\n\t";
$output .= ' class="' . esc_attr( $class ) . '"';
$output .= "\n\t";
$output .= ' name="' . esc_attr( $fieldname ) . '"';
$output .= "\n\t";
$output .= ' type="' . esc_attr( $type ) . '"';
$output .= "\n\t";
$output .= ' inputmode="' . esc_attr( $mode ) . '"';
$output .= "\n\t";
if ( $form_errors || $missing ) :
	$output .= wp_rig()->retain_value( $value );
endif;
$output .= '>';
$output .= "\n";
$output .= '</div>';
$output .= "\n";
return $output;

*/
