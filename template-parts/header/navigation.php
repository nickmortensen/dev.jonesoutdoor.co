<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

if ( ! wp_rig()->is_primary_nav_menu_active() ) {
	return;
}

?>




<nav
id="site-navigation"
class="main-navigation nav--toggle-sub nav--toggle-small w-screen lg:w-2/3 xl:w-7/12"
aria-label="<?php esc_attr_e( 'Main menu', 'wp-rig' ); ?>"
	<?php if ( wp_rig()->is_amp() ) : ?>
		[class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' "
	<?php endif; ?>
>
		<?php if ( wp_rig()->is_amp() ) : ?>
		<amp-state id="siteNavigationMenu">
			<script type="application/json">
				{
					"expanded": false
				}
			</script>
		</amp-state>
		<?php endif; ?>

	<!-- <button
	id="menu-toggler"
	class="menu-toggle"
	aria-label="<?php esc_attr_e( 'Open menu', 'wp-rig' ); ?>"
	aria-controls="primary-menu"
	aria-expanded="false"
		<?php if ( wp_rig()->is_amp() ) : ?>
			on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
			[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
		<?php endif; ?>
	>

	</button> -->


	<a
	tabindex="1"
	id="menu-toggler"
	class="material-icons"
	aria-label="<?php esc_attr_e( 'Open menu', 'wp-rig' ); ?>"
	aria-controls="primary-menu"
	aria-expanded="false"
	<?php if ( wp_rig()->is_amp() ) : ?>
			on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
			[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
	<?php endif; ?>
	>menu</a>

	<div class="primary-menu-container">
		<?php
		$args = [
			'menu_id' => 'primary-menu',
		];
		wp_rig()->display_primary_nav_menu( $args );
		?>
	</div>

</nav><!-- #site-navigation -->


