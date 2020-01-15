<?php
/**
 * Template part for displaying the left side of the header.
 * Will have company name and tagline on left.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="flex items-start flex-col flex-shrink-0 text-white mr-6 border-r-2 border-white">

	<?php the_custom_logo(); ?>

	<?php
	/**
	 * Company Name (eventually logo) is a link back to the homepage.
	 */
	if ( is_front_page() && is_home() ) {
	?>
		<a target="_blank" href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" class="font-semibold text-xl tracking-tight text-white no-underline"><?php bloginfo( 'name' ); ?></a><br>
		<?php
	} else {
		?>
		<div class="site-title">
			<a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
	<?php
	}
	?>

	<?php
	/** Company Tagline "Keep Looking Up" */
	$wp_rig_description = get_bloginfo( 'description', 'display' );
	if ( $wp_rig_description || is_customize_preview() ) {
	?>
	<div class="site-description">
		<?= esc_html( $wp_rig_description ); ?>
	</div>
	<?php
	}
	?>

</div>
