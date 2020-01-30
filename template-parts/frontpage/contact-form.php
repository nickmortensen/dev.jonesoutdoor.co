<?php
// phpcs:disable Squiz.PHP.CommentedOutCode.Found, Generic.PHP.DisallowShortOpenTag.EchoFound, WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.Security.NonceVerification.Missing, Generic.PHP.DisallowShortOpenTag.EchoFound
/**
 * Template part for displaying Jones Outdoor Contact Form -- this is the one with the blurred background.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

// Setting these within the file as false/empty array helps avoid errors.
// They will be reset when including the ./for_helper.php file.
$headers     = [];
$missing     = [];
$form_errors = [];
$suspect     = false;

$textarea_atts = wp_rig()->get_textarea_field_attributes();
$fields        = wp_rig()->return_form_fields(); // can delete as it is established in the form_helper.php file as well.
if ( isset( $_POST['submit'] ) ) {
	// Checks to see if any required fields are empty and then outputs the proper message on the proper field.
	require_once __DIR__ . '/form_helper.php';
	$full_name    = filter_input( INPUT_POST, 'fullname', FILTER_SANITIZE_STRING );
	$company_name = filter_input( INPUT_POST, 'company', FILTER_SANITIZE_STRING );
	$position     = filter_input( INPUT_POST, 'jobtitle', FILTER_SANITIZE_STRING );
	$from_email   = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING | FILTER_SANITIZE_EMAIL );
	$user_message = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING );
	$to           = 'Outdoor FormRecipient <incoming_testmail_one@jonesoutdoor.co>';
	$subject      = 'Inquiry from the NEW JonesOutdoor Website';
	// $from_email   = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
	// Checks for Valid email format and nothing else.
	// if ( $form_email ) {
	// $headers    = [];
	// $headers[]  = "From: wordpress@jonesoutdoor.co\r\nReply-to: $from_email";
	// $headers[]  = 'Cc: incoming_testmail_two@jonesoutdoor.co';
	// $headers[]  = 'Content-type: text/plain; charset = utf-8';
	// $authorized = null;
	// }

?>

<style>
.full_name { grid-area: header; }
.from_email { grid-area: main;}
.user_message { grid-area: sidebar; }
.company_name { grid-area: footer; }
.position { grid-area: }

#info-container {
	display: grid;
	grid-template-columns: 250px 1fr 3fr 1fr ;
	grid-template-rows: auto;
	grid-template-areas:
	"header header header header"
	"main main . sidebar"
	"footer footer footer footer";
}
</style>

<section id="info-container" class="text-white w-3/4 h-64 bg-indigo-600 mx-auto border-b-8 border-blue-800">
	<span class="p-2 full_name bg-orange-600 text-white"><?= $full_name; ?></span>
	<span class="p-2 from_email bg-blue-900"><?= $from_email; ?></span>
	<span class="p-2 company_name bg-teal-700"><?= $company_name; ?></span>
	<span class="p-2 position bg-red-500"><?= filter_input( INPUT_POST, 'jobtitle', FILTER_SANITIZE_STRING ); ?></span>
	<span class="p-2 user_message bg-yellow-600"><?= $user_message; ?></span>
</section>


<?php
}
?>
	<?= wp_rig()->return_contact_form_open_tag(); ?><!-- FORM OPENING TAG -->


<?php
		if ( $_POST && $suspect ) {
			echo '<div style="margin-top: -2em;" class="mb-4"><span class="warning text-sm mb-4"><i class="material-icons align-text-bottom mr-1 text-sm">warning</i> Your Mail Could not be sent.</span></div>';
		} elseif ( $form_errors || $missing ) {
			echo '<div class="w-full pb-6"><span class="warning"> Please fill out the indicated field(s)</span></div>';
}
	?>
	<!-- FORM FIELDS -->

<!-- FULLNAME -->
<div class="mb-4 input_holders">
	<label  class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="fullname">
		What is Your Full Name?
		<?php
			if ( $missing && in_array( 'fullname', $missing, true ) ) {
				echo wp_rig()->issue_warning( $fields['fullname']['error'] );
			}
		?>
	</label><!-- end label for fullname input -->
	<input
	id="fullname"
	class="tailwind-input"
	name="fullname"
	type="text"
	inputmode="text"
	<?php
	if ( $form_errors || $missing ) {
		echo wp_rig()->retain_value( $fullname );
	}
	?>
	>
</div>

<!-- COMPANY -->
<div class="mb-4 input_holders">
	<label  class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="company">
		What Company are You With?
		<?php
		if ( $missing && in_array( 'company', $missing, true ) ) {
			echo wp_rig()->issue_warning( $fields['company']['error'] );
		}
		?>
	</label><!-- end label for company input -->
	<input
	id="company"
	class="tailwind-input"
	name="company"
	type="text"
	inputmode="text"
	<?php
	if ( $form_errors || $missing ) {
		echo wp_rig()->retain_value( $company );
	}
	?>
	>
</div>

<!-- JOBTITLE -->
<div class="mb-4 input_holders">
	<label  class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="jobtitle">
		What is Your Job Title?
	</label><!-- end label for jobtitle input -->
	<input
	id="jobtitle"
	class="tailwind-input"
	name="jobtitle"
	type="text"
	inputmode="text"
	<?php
		if ( $form_errors || $missing ) {
			echo wp_rig()->retain_value( $jobtitle );
		}
		?>
	>
</div>

<!-- EMAIL -->
<div class="mb-4 input_holders">
	<label  class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="email">
		What is Your email?
		<?php
		if ( $missing && in_array( 'email', $missing, true ) ) {
			echo wp_rig()->issue_warning( $fields['email']['error'] );
		}
		?>
	</label><!-- end label for email input -->
	<input
	class="tailwind-input"
	name="email"
	type="email"
	inputmode="email"
	<?php
	if ( $form_errors || $missing ) {
		echo wp_rig()->retain_value( $email );
	}
	//phpcs:disable
	?>
	>
</div>

<!-- MESSAGE -->
<div class="mb-4 input_holders">
	<label  class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="message">
		What is Your Message?
		<?php
		if ( $missing && in_array( 'message', $missing, true ) ) {
			echo wp_rig()->issue_warning( $fields['message']['error'] );
		}
		?>
	</label><!-- end label for message input -->
	<textarea
class="tailwind-input"
name="message"
type="textarea"
inputmode="text"
	><?php
	if ( $form_errors || $missing ) {
		echo stripslashes( esc_textarea( $message ) );
	}
	//phpcs:enable
	?>
</textarea>
</div>

<!-- ADDTHESE -->
<div class="mb-4 input_holders">
	<label  id="addTheseLabel" class="" for="addthese"></label><!-- end label for addthese input -->
	<input
	id="addthese"
	class="tailwind-input"
	name="addthese"
	type="text"
	inputmode="text"
	>
</div>


	<!-- END FORM FIELDS -->
	<?= wp_rig()->return_contact_form_submit_button(); ?><!-- SUBMIT BUTTON -->
	<?= wp_rig()->return_contact_form_closing_tag(); ?>	<!-- CLOSING FORM TAG -->

<section class="w-screen">

</section>




<script>

let form = document.getElementById('testform');

</script>

