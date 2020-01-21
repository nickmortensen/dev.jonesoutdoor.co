<?php
/**
 * WP_Rig\WP_Rig\Custom_Menus\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Custom_Menus;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use WP_Post;
use function add_action;
use function add_filter;
use function register_nav_menus;
use function esc_html__;
use function has_nav_menu;
use function wp_nav_menu;

/**
 * Class for managing navigation menus.
 *
 * Exposes template tags:
 * * `wp_rig()->is_custom_menu_active()`
 * * `wp_rig()->display_custom_menu( array $args = [] )`
 */
class Component implements Component_Interface, Templating_Component_Interface {

	const CUSTOM_MENU_SLUG = 'custom';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_menus';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', [ $this, 'action_register_custom_menus' ] );
		add_filter( 'walker_nav_menu_start_el', [ $this, 'filter_custom_menu_dropdown_symbol' ], 10, 4 );
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
			'is_custom_menu_active' => [ $this, 'is_custom_menu_active' ],
			'display_custom_menu'   => [ $this, 'display_custom_menu' ],
		];
	}

	/**
	 * Registers the custom menus.
	 */
	public function action_register_custom_menus() {
		register_nav_menus(
			[
				static::CUSTOM_MENU_SLUG => esc_html__( 'Custom', 'wp-rig' ),
			]
		);
	}

	/**
	 * Adds a dropdown symbol to custom menu items with children.
	 *
	 * Adds the dropdown markup after the menu link element,
	 * before the submenu.
	 *
	 * Javascript converts the symbol to a toggle button.
	 *
	 * @TODO:
	 * - This doesn't work for the page menu because it
	 *   doesn't have a similar filter. So the dropdown symbol
	 *   is only being added for page menus if JS is enabled.
	 *   Create a ticket to add to core?
	 *
	 * @param string  $item_output The menu item's starting HTML output.
	 * @param WP_Post $item        Menu item data object.
	 * @param int     $depth       Depth of menu item. Used for padding.
	 * @param object  $args        An object of wp_nav_menu() arguments.
	 * @return string Modified nav menu HTML.
	 */
	public function filter_custom_menu_dropdown_symbol( string $item_output, WP_Post $item, int $depth, $args ) : string {

		// Only for our primary menu location.
		if ( empty( $args->theme_location ) || static::CUSTOM_MENU_SLUG !== $args->theme_location ) {
			return $item_output;
		}

		// Add the dropdown for items that have children.
		if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			return $item_output . '<span class="dropdown"><i class="dropdown-symbol"></i></span>';
		}

		return $item_output;
	}

	/**
	 * Checks whether the custom navigation menu is active.
	 *
	 * @return bool True if the custom menu is active, false otherwise.
	 */
	public function is_custom_menu_active() : bool {
		return (bool) has_nav_menu( static::CUSTOM_MENU_SLUG );
	}

	/**
	 * Displays the custom menu.
	 *
	 * @param array $args Optional. Array of arguments. See `wp_nav_menu()` documentation for a list of supported
	 *                    arguments.
	 */
	public function display_custom_menu( array $args = [] ) {
		if ( ! isset( $args['container'] ) ) {
			$args['container'] = 'ul';
		}

		$args['theme_location'] = static::CUSTOM_MENU_SLUG;

		wp_nav_menu( $args );
	}

	/**
	 * Create own menu nav walker.
	 *
	 * @param array  $output Output is passed by reference.
	 * @param object $item Representing an item within the menu.
	 * @param int    $depth What level the menu item is on.
	 * @param array  $args All the info we will padd to the wp_nav_menu() function.
	 * @param int    $id Identity number of the menu.
	 *
	 * @return string string of something.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$object      = $item->object;
		$type        = $item->type;
		$title       = $item->title;
		$description = $item->description;
		$permalink   = $item->url;
		$output      = '';
		$output     .= "<li class='" . esc_attr( implode( ' ', $item->classes ) ) . "'>";

		// Add SPAN if no Permalink.
		if ( $permalink && '#' !== $permalink ) {
			$output .= '<a href="' . $permalink . '">';
		} else {
			$output .= '<span>';
		}

		$output .= $title;

		return 'unifinished';
	}
}
