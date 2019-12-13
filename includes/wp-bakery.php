<?php
/*****************************************************************/
/** This file maps shortcodes to WPBakery Elements
/** Shortcodes are located in /includes/classes/class-ns-basics-shortcodes.php
/*****************************************************************/ 

add_action('vc_before_init', 'ns_basics_vc_map');
function ns_basics_vc_map() {

	/** MODULE HEADER **/
	vc_map(array(
		'name' => esc_html__( 'Module Header', 'ns-basics' ),
		'base' => 'ns_module_header',
		'description' => esc_html__( 'Display a module header', 'ns-basics' ),
		'icon' => PROPERTYSHIFT_DIR.'/images/icon-real-estate.svg',
		'class' => '',
		'category' => 'NS Basics',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'ns-basics' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Text', 'ns-basics' ),
				'param_name' => 'text',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Position', 'ns-basics' ),
				'param_name' => 'position',
				'value' => array('Left' => 'left', 'Right' => 'right', 'Center' => 'center'),
				'std' => 'center',
			),
		),
	));

	/** LIST POSTS **/
	vc_map(array(
		'name' => esc_html__( 'List Posts', 'ns-basics' ),
		'base' => 'ns_list_posts',
		'description' => esc_html__( 'Display a list a posts', 'ns-basics' ),
		'icon' => PROPERTYSHIFT_DIR.'/images/icon-real-estate.svg',
		'class' => '',
		'category' => 'NS Basics',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Number of Posts', 'ns-basics' ),
				'param_name' => 'num',
				'std' => 3,
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Excerpt Length', 'ns-basics' ),
				'param_name' => 'excerpt',
				'std' => 20,
				'description' => esc_html__( 'Enter the number of characters to trim the excerpt to.', 'ns-basics' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Pagination', 'ns-basics' ),
				'param_name' => 'show_pagination',
				'value' => array('False' => 'false', 'True' => 'true'),
				'std' => 'false',
			),
		),
	));

	/** LOGIN FORM **/
	vc_map(array(
		'name' => esc_html__( 'Login Form', 'ns-basics' ),
		'base' => 'ns_login_form',
		'description' => esc_html__( 'Display a user login form', 'ns-basics' ),
		'icon' => PROPERTYSHIFT_DIR.'/images/icon-real-estate.svg',
		'class' => '',
		'category' => 'NS Basics',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Redirect URL', 'ns-basics' ),
				'param_name' => 'redirect',
				'description' => esc_html__( 'After successful login, users will be redirected to this URL.', 'ns-basics' ),
			),
		),
	));

	/** REGISTER FORM **/
	vc_map(array(
		'name' => esc_html__( 'Register Form', 'ns-basics' ),
		'base' => 'ns_register_form',
		'description' => esc_html__( 'Display a user register form', 'ns-basics' ),
		'icon' => PROPERTYSHIFT_DIR.'/images/icon-real-estate.svg',
		'class' => '',
		'category' => 'NS Basics',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Default Role', 'ns-basics' ),
				'param_name' => 'default_role',
				'description' => esc_html__( 'Enter the user role assigned on registration. Defaults to Subscriber.', 'ns-basics' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Roles Dropdown', 'ns-basics' ),
				'param_name' => 'roles',
				'description' => esc_html__( 'Allow users to choose role on registration. Enter a comma-separated list of user roles.', 'ns-basics' ),
			),
		),
	));

}
?>