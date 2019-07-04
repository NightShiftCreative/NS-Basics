<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Members class
 *
 *  Adds member methods
 */
class NS_Basics_Members {

	/**
	 *	Constructor
	 */
	public function __construct() {
		$this->register_dashboard_sidebar();
	}

	/**
	 *	Register dashboard sidebar
	 */
	public function register_dashboard_sidebar() {
		register_sidebar( array(
		    'name' => esc_html__( 'Dashboard Sidebar', 'ns-basics' ),
		    'id' => 'dashboard_sidebar',
		    'before_widget' => '<div class="widget widget-sidebar %2$s">',
		    'after_widget' => '</div>',
		    'before_title' => '<h4>',
		    'after_title' => '</h4>',
		));
	}

}

?>