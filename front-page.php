<?php
/**
 * Render your site front page, whether the front page displays the blog posts index or a static page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$masthead = 'template-parts/frontpage/masthead';
$form     = 'template-parts/frontpage/contact-form';
get_header( 'frontpage' );

get_template_part( $masthead );

?>





<section
id="contact-form"
class="w-screen bg-blue-600 py-16 relative"
style="background: url('/wp-content/uploads/2019/09/sample_bb_type-720x480.jpg') #5741d9; background-blend-mode: multiply;background-size: cover;"
>


<?php
get_template_part( $form );
?>
</section>
<?php

echo wp_rig()->output_the_map_element();

get_footer();
?>


<script type="text/javascript">


</script>
