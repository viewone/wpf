<?php

namespace WPF\Walker;

/**
 * Add class level-n for submenus.
 *
 * @package WPF
 * @since 1.0
 * @uses Walker_Nav_Menu
 */

class Nav extends \Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
        
        $classes = array('sub-menu');
        $classes[] = 'level-' . ($depth + 1);
		$output .= "\n$indent<ul class=\"" . implode(' ', $classes) . "\">\n";
	}
}