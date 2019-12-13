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


}
?>