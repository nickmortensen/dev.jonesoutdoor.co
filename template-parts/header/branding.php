<?php
/**
 * Template part for displaying the header branding - logo and site name/home link.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$pattern  = '/\s{1}of\s{1}Wisconsin/i';
$replace  = '';
$sitename = preg_replace( $pattern, $replace, get_bloginfo( 'name' ) );
?>

<div class="w-screen lg:w-1/3 xl:w-1/4 pl-1 flex flex-row justify-center pl-1 lg:justify-start items-end content-between ">
<a id="logo-home-link" class="h-16 w-64" href="#"><img src="<?= get_theme_file_uri( '/jones_outdoor_logo.php?fill=fc6' ); ?>" title="<?= get_bloginfo(); ?>" /></a>
	<?php if ( is_front_page() && is_home() ) : ?>

		<a title="link to jones outdoor homepage" href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">

		</a>
	<?php else : ?>
		<span class="pl-1">
			<a title="link to jones outdoor homepage" href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?= get_theme_file_uri( '/jones_outdoor_logo.php?fill=fff' ); ?>" title="<?= get_bloginfo(); ?>" />
			</a>
		</span>
	<?php endif; ?>

	<?php
	$wp_rig_description = get_bloginfo( 'description', 'display' );
	if ( $wp_rig_description || is_customize_preview() ) {
		?>
		<p class="site-description hidden">
			<?= esc_html( $wp_rig_description ); ?>
		</p>
		<?php
	}
	?>
</div>
