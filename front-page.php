<?php
/**
 * Render your site front page, whether the front page displays the blog posts index or a static page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

$form = 'template-parts/frontpage/contact-form';

?>
<section id="cformheader" class="w-screen bg-red-200 h-16">
	<h2 class=" p-4 mx-auto text-2xl">


	</h2>
</section>

<section
id="contact-form-holder"
class="w-screen bg-blue-600 py-16 relative"
style="background: url('/wp-content/uploads/2019/09/sample_bb_type-720x480.jpg') #0273b9; background-blend-mode: multiply;background-size: cover;"
>


<?php
get_template_part( $form );
?>
</section>
<?php
echo wp_rig()->output_the_map_element();

get_footer();
