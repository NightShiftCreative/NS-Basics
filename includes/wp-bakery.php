<?php
/*****************************************************************/
/* Set default WPBakery post types */
/*****************************************************************/
add_action('vc_before_init', 'ns_basics_add_post_type_wpbakery');
function ns_basics_add_post_type_wpbakery() {
	$vc_post_types = array(
		'page',
		'ns-global-blocks',
	);
	$vc_post_types = apply_filters( 'ns_basics_vc_post_types', $vc_post_types);
	vc_set_default_editor_post_types($vc_post_types);
}


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
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-basic-widgets.svg',
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

	/** SLIDER **/
	vc_map( array(
		"name" => __("Slider", "ns-basics"),
		"base" => "ns_slider",
		'description' => esc_html__( 'Display a content slider', 'ns-basics' ),
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-slides.svg',
		'category' => 'NS Basics',
		"as_parent" => array('only' => 'ns_slide'),
		"content_element" => true,
		"show_settings_on_create" => true,
		"is_container" => true,
		"params" => array(
			array(
		  		"type" => "textfield",
		  		"heading" => __("Class", "ns-basics"),
		  		"param_name" => "class",
		  		"description" => __("Add a CSS class for styling.", "ns-basics")
			),
			array(
		  		"type" => "dropdown",
		  		"heading" => __("Slides to Show", "ns-basics"),
		  		"param_name" => "slides_to_show",
		  		"description" => __("Number of slides to show.", "ns-basics"),
		  		'value' => array(
		  			__( '1',  "ns-basics" ) => '1',
    				__( '2',  "ns-basics" ) => '2',
    				__( '3',  "ns-basics" ) => '3',
    				__( '4',  "ns-basics" ) => '4',
    				__( '5',  "ns-basics" ) => '5',
    				__( '6',  "ns-basics" ) => '6',
		  		),
			),
			array(
		  		"type" => "dropdown",
		  		"heading" => __("Slides to Scroll", "ns-basics"),
		  		"param_name" => "slides_to_scroll",
		  		"description" => __("Number of slides to scroll.", "ns-basics"),
		  		'value' => array(
		  			__( '1',  "ns-basics" ) => '1',
    				__( '2',  "ns-basics" ) => '2',
    				__( '3',  "ns-basics" ) => '3',
    				__( '4',  "ns-basics" ) => '4',
    				__( '5',  "ns-basics" ) => '5',
    				__( '6',  "ns-basics" ) => '6',
		  		),
			),
			array(
		  		"type" => "dropdown",
		  		"heading" => __("Transition", "ns-basics"),
		  		"param_name" => "transition",
		  		"description" => __("The transition between slides.", "ns-basics"),
		  		'value' => array(
		  			__( 'Slide',  "ns-basics" ) => 'slide',
    				__( 'Fade',  "ns-basics" ) => 'fade',
		  		),
			),
			array(
		  		"type" => "dropdown",
		  		"heading" => __("Autoplay", "ns-basics"),
		  		"param_name" => "autoplay",
		  		"description" => __("If enabled, the slider will start scrolling automatically.", "ns-basics"),
		  		'value' => array(
		  			__( 'No',  "ns-basics" ) => 'false',
    				__( 'Yes',  "ns-basics" ) => 'true',
		  		),
			),
			array(
		  		"type" => "textfield",
		  		"heading" => __("Autoplay Speed (MS)", "ns-basics"),
		  		"param_name" => "autoplay_speed",
		  		"description" => __("Enter the slider speed in MS.", "ns-basics"),
		  		'value' => 5000,
			),
			array(
		  		"type" => "dropdown",
		  		"heading" => __("Display Dots", "ns-basics"),
		  		"param_name" => "dots",
		  		"description" => __("If enabled, dots will be displayed for navigation.", "ns-basics"),
		  		'value' => array(
		  			__( 'No',  "ns-basics" ) => 'false',
		  			__( 'Yes',  "ns-basics" ) => 'true',
		  		),
			),
		),
		"js_view" => 'VcColumnView'
	));

	vc_map( array(
		"name" => __("Slide", "ns-basics"),
		"base" => "ns_slide",
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-slides.svg',
		'category' => 'NS Basics',
		"content_element" => true,
		"as_child" => array('only' => 'ns_slider'),
		"params" => array(
			array(
		  		"type" => "textfield",
		  		"heading" => __("Title", "ns-basics"),
		  		'description' => __("The title isn't displayed on the site.", "ns-basics"),
		  		"param_name" => "title",
			),
			array(
		  		"type" => "textfield",
		  		"heading" => __("Class", "ns-basics"),
		  		"param_name" => "class",
			),
			array(
		  		"type" => "textarea_html",
		  		"heading" => __("Slide Content", "ns-basics"),
		  		"param_name" => "content",
			),
		),
		'js_view' => 'VcCustomElementView',
		'custom_markup' => '<div class="vc_custom-element-container vc-custom-slide"><strong style="display:block;">{{ params.title }}</strong><br/> {{ params.content }}</div>',
	));

	if (class_exists('WPBakeryShortCodesContainer')) {
	  	class WPBakeryShortCode_ns_slider extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_ns_slide extends WPBakeryShortCode {}
	}

	/** TESTIMONIALS **/
	vc_map( array(
		"name" => __("Testimonials", "ns-basics"),
		"base" => "ns_testimonials",
		'description' => esc_html__( 'Display a testimonials slider', 'ns-basics' ),
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-slides.svg',
		'category' => 'NS Basics',
		"as_parent" => array('only' => 'ns_testimonial'),
		"content_element" => true,
		"show_settings_on_create" => true,
		"is_container" => true,
		/*"params" => array(
			array(
		  		"type" => "textfield",
		  		"heading" => __("Class", "ns-basics"),
		  		"param_name" => "class",
		  		"description" => __("Add a CSS class for styling.", "ns-basics")
			),
		),*/
		"js_view" => 'VcColumnView'
	));

	vc_map( array(
		"name" => __("Testimonial", "ns-basics"),
		"base" => "ns_testimonial",
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-slides.svg',
		'category' => 'NS Basics',
		"content_element" => true,
		"as_child" => array('ns_testimonials'),
		"params" => array(
			array(
		  		"type" => "attach_image",
		  		"heading" => __("Image", "ns-basics"),
		  		'description' => __("The headshot or logo of the testimonial.", "ns-basics"),
		  		"param_name" => "img",
			),
			array(
		  		"type" => "textfield",
		  		"heading" => __("Name", "ns-basics"),
		  		'description' => __("The full name of the testimonial.", "ns-basics"),
		  		"param_name" => "name",
			),
			array(
		  		"type" => "textfield",
		  		"heading" => __("Professional Title", "ns-basics"),
		  		'description' => __("The professional title of the individual.", "ns-basics"),
		  		"param_name" => "title",
			),
			array(
		  		"type" => "textarea_html",
		  		"heading" => __("Slide Content", "ns-basics"),
		  		"param_name" => "content",
			),
		),
		'js_view' => 'VcCustomElementView',
		'custom_markup' => '<div class="vc_custom-element-container vc-custom-slide"><strong style="display:block;">{{ params.name }}</strong><br/> {{ params.content }}</div>',
	));

	if (class_exists('WPBakeryShortCodesContainer')) {
	  	class WPBakeryShortCode_ns_testimonials extends WPBakeryShortCodesContainer {}
	}

	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_ns_testimonial extends WPBakeryShortCode {}
	}


	/** LIST POSTS **/
	vc_map(array(
		'name' => esc_html__( 'List Posts', 'ns-basics' ),
		'base' => 'ns_list_posts',
		'description' => esc_html__( 'Display a list a posts', 'ns-basics' ),
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-basic-widgets.svg',
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
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-basic-widgets.svg',
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
		'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-basic-widgets.svg',
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

	/** GLOBAL BLOCK **/
	$modules = new NS_Basics_Modules();
	if($modules->is_module_active('ns_basics_global_blocks')) { 
		vc_map(array(
			'name' => esc_html__( 'Global Block', 'ns-basics' ),
			'base' => 'ns_block',
			'description' => esc_html__( 'Display a global content block', 'ns-basics' ),
			'icon' => NS_BASICS_PLUGIN_DIR.'/images/icon-basic-widgets.svg',
			'class' => '',
			'category' => 'NS Basics',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Select a Block', 'ns-basics' ),
					'param_name' => 'id',
					'value' => NS_Basics_Global_Blocks::get_blocks(true),
				),
			),
		));
	}

}
?>