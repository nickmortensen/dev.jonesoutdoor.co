<?php
/**
 * Jones Walker Class
 *
 * @package wp_rig
 */

// namespace Jones_Walker;

// use Walker_Nav_Menu;
// use function add_action;
// use function add_filter;
// use function register_nav_menus;
// use function esc_html__;
// use function has_nav_menu;
// use function wp_nav_menu;

/**
 * Class for managing navigation menus.
 */
class Jones_Walker extends \Walker_Nav_Menu {

	const CUSTOM_MENU_SLUG = 'custom';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_menu';
	}

	/**
	 * Displays start of an element. E.g '<li> Item Name'.
	 *
	 * @see Walker::start_el()
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$object      = $item->object; // what does it point to - could be a post type;
		$type        = $item->type;
		$title       = $item->title;
		$description = $item->description;
		$permalink   = $item->url ?? '#';
		$class       = 1 >= count( $item->classes ) ? implode( ' ', $item->classes ) : 'custom-nav-list-item';

		$output .= '<li class="' . $class . '" >';
		$output .= '<a data-objectid="' . $item->object_id . '" title="' . $description . '" data-object="' . $object . '" data-type="' . $type . '" data-id="' . $item->ID . '" href="' . $permalink . '">';
		$output .= $item->title;
		// if ( '' !== $description && 0 === $depth ) {
		// 	$output .= '<br><small class="description">' . $description . '</small>';
		// }
		$output .= '</a>';

	}

}
