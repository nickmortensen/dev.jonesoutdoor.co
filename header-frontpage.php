<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php
	if ( ! wp_rig()->is_amp() ) {
		?>
		<script>document.documentElement.classList.remove( 'no-js' );</script>
		<?php
	}
	?>

	<?php
	wp_head();
	// Use grid layout if blog index is displayed.
		wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-front-page' );
	?>
</head>




<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'wp-rig' ); ?>
	</a>
<?php
$gradient = wp_rig()->chosen_gradient();
$src      = wp_get_attachment_image_src( 103, 'large', false );
$svg      = get_template_directory_uri() . '/assets/images/header_bg_mask.svg';
?>
		<section id="frontpage-header" class="w-screen flex flex-col <?= $gradient; ?>">

			<!-- contains site logo and menu at top of homepage -->
			<header id="masthead" class="p-2 w-screen flex flex-col justify-center lg:flex-row lg:justify-around xl:flex-row xl:justify-around">
				<?php get_template_part( 'template-parts/header/branding' ); ?>
				<?php get_template_part( 'template-parts/header/navigation' ); ?>
			</header>

			<div id="frontpage-main" class="w-screen flex flex-col justify-center items-center lg:flex-row xl:flex-row">
				<div class="w-screen lg:w-1/2 xl:w-1/2">
					<img src="<?= esc_url( $src[0] ); ?>" />
				</div>

				<div class="w-screen lg:w-1/2 xl:w-1/2 text-white flex flex-col justify-between items-start font-hairline p-4">
					<span class="text-3xl">Jones Outdoor</span>
					<span class="text-xl mb-2">Digital and Static Billboards in Wisconsin.</span>
					<span class="text-base">A short paragraph of content here. An elevator pitch or a call-to-action would be perfect.</span>
				</div>
			</div>
			<!-- /#frontpage-main -->


	</section><!-- end section#frontpage-header -->
