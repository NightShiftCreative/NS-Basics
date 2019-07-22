<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Page_Settings class
 *
 */
class NS_Basics_Page_Settings {

	/************************************************************************/
	// Initialize
	/************************************************************************/

	/**
	 *	Constructor
	 */
	public function __construct() {
		// Load admin object
		$this->admin_obj = new NS_Basics_Admin();
	}

	/**
	 *	Init
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'register_page_settings_meta_box' ));
		add_action( 'save_post', array( $this, 'save_page_settings_meta_box' ));
	}

	/************************************************************************/
	// Page Settings
	/************************************************************************/

	/**
	 * Load global settings
	 */
	public function load_global_settings() {
		$global_banner_settings = array();

		if(function_exists('ns_core_load_theme_options')) {
			$theme_options = ns_core_load_theme_options();
			$global_banner_settings['bg'] = $theme_options['ns_core_page_banner_bg'];
			$global_banner_settings['bg_display'] = $theme_options['ns_core_page_banner_bg_display'];
			$global_banner_settings['title_align'] = $theme_options['ns_core_page_banner_title_align'];
			$global_banner_settings['padding_top'] = $theme_options['ns_core_page_banner_padding_top'];
	        $global_banner_settings['padding_bottom'] = $theme_options['ns_core_page_banner_padding_bottom'];
	        $global_banner_settings['overlay'] = $theme_options['ns_core_page_banner_overlay_display'];
	        $global_banner_settings['overlay_opacity'] = $theme_options['ns_core_page_banner_overlay_opacity'];
	        $global_banner_settings['overlay_color'] = $theme_options['ns_core_page_banner_overlay_color'];
	        $global_banner_settings['display_breadcrumb'] = $theme_options['ns_core_page_banner_display_breadcrumb'];
	        $global_banner_settings['display_search'] = $theme_options['ns_core_page_banner_display_search'];
		} else {
			$global_banner_settings['bg'] = esc_attr(get_option('ns_core_page_banner_bg'));
	        $global_banner_settings['bg_display'] = esc_attr(get_option('ns_core_page_banner_bg_display'));
	        $global_banner_settings['title_align'] = esc_attr(get_option('ns_core_page_banner_title_align'));
	        $global_banner_settings['padding_top'] = esc_attr(get_option('ns_core_page_banner_padding_top'));
	        $global_banner_settings['padding_bottom'] = esc_attr(get_option('ns_core_page_banner_padding_bottom'));
	        $global_banner_settings['overlay'] = esc_attr(get_option('ns_core_page_banner_overlay_display'));
	        $global_banner_settings['overlay_opacity'] = esc_attr(get_option('ns_core_page_banner_overlay_opacity', '0.25'));
	        $global_banner_settings['overlay_color'] = esc_attr(get_option('ns_core_page_banner_overlay_color', '#000000'));
	        $global_banner_settings['display_breadcrumb'] = esc_attr(get_option('ns_core_page_banner_display_breadcrumb'));
	        $global_banner_settings['display_search'] = esc_attr(get_option('ns_core_page_banner_display_search'));
		}

		return $global_banner_settings;
	}

	/**
	 * Load page settings
	 *
	 * @param int $post_id
	 * @param boolean $return_defaults
	 */
	public function load_page_settings($post_id, $return_defaults = false) {

		$global_banner_settings = $this->load_global_settings();

		// Set sidebar options
		$sidebar_options = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
			$sidebar_options[$sidebar['name']] = $sidebar['id'];
		}

		// Get slider categories
		$slide_cats_array = array();
		$slide_cats_array[__( 'All Categories', 'ns-basics' )] = '';
		$slide_cats = get_terms('slide_category', array( 'hide_empty' => false, 'parent' => 0 )); 
		if (!empty( $slide_cats ) && !is_wp_error($slide_cats)) {
			foreach($slide_cats as $slide_cat) {
				$slide_cats_array[esc_attr($slide_cat->name)] = esc_attr($slide_cat->slug);
			}
		}

		// Set all fields
		$page_settings_init = array(
			'banner_header_style' => array(
				'group' => 'banner',
				'title' => esc_html__('Header Style', 'ns-basics'),
				'name' => 'ns_basics_banner_header_style',
				'value' => '',
				'description' => esc_html__('Override the global header style set in the theme options.', 'ns-basics'),
				'type' => 'select',
				'options' => array('User Global Header Style' => '', 'Classic' => 'classic', 'Transparent' => 'transparent', 'Menu Bar' => 'default'),
				'order' => 1,
			),
			'banner_display' => array(
				'group' => 'banner',
				'title' => esc_html__('Display Banner', 'ns-basics'),
				'name' => 'ns_basics_banner_display',
				'value' => 'true',
				'type' => 'checkbox',
				'order' => 2,
			),
			'banner_source' => array(
				'group' => 'banner',
				'title' => esc_html__('Banner Source', 'ns-basics'),
				'name' => 'ns_basics_banner_source',
				'value' => 'image_banner',
				'description' => esc_html__('Select the banner source.', 'ns-basics'),
				'type' => 'radio_image',
				'options' => array(
					esc_html__('Default Banner', 'ns-basics') => array(
						'value' => 'image_banner', 
						'icon' => NS_BASICS_PLUGIN_DIR.'/images/default-banner-icon.png',
					), 
					esc_html__('Custom Slider', 'ns-basics') => array(
						'value' => 'slides', 
						'icon' => NS_BASICS_PLUGIN_DIR.'/images/slider-icon.png',
					),
					esc_html__('Shortcode', 'ns-basics') => array(
						'value' => 'shortcode', 
						'icon' => NS_BASICS_PLUGIN_DIR.'/images/slider-revolution-icon.png',
					),
				),
				'order' => 3,
				'children' => array(
					'banner_title' => array(
						'title' => esc_html__('Banner Title', 'ns-basics'),
						'name' => 'ns_basics_banner_title',
						'type' => 'text',
						'order' => 4,
						'parent_val' => 'image_banner',
					),
					'banner_text' => array(
						'title' => esc_html__('Banner Text', 'ns-basics'),
						'name' => 'ns_basics_banner_text',
						'type' => 'text',
						'order' => 5,
						'parent_val' => 'image_banner',
					),
					'banner_class' => array(
						'title' => esc_html__('Banner Class', 'ns-basics'),
						'name' => 'ns_basics_banner_class',
						'type' => 'text',
						'order' => 6,
						'parent_val' => 'image_banner',
					),
					'banner_custom_settings' => array(
						'title' => esc_html__('Use Custom Banner Settings', 'ns-basics'),
						'name' => 'ns_basics_banner_custom_settings',
						'description' => esc_html__('The banner global settings are configured in the theme options (Appearance > Theme Options)', 'ns-basics'),
						'type' => 'switch',
						'order' => 7,
						'parent_val' => 'image_banner',
						'children' => array(
							'banner_bg_img' => array(
								'title' => esc_html__('Banner Background Image', 'ns-basics'),
								'name' => 'ns_basics_banner_bg_img',
								'type' => 'image_upload',
								'order' => 8,
								'value' => $global_banner_settings['bg'],
							),
							'banner_bg_display' => array(
								'title' => esc_html__('Banner Background Display', 'ns-basics'),
								'name' => 'ns_basics_banner_bg_display',
								'type' => 'select',
								'order' => 9,
								'value' => $global_banner_settings['bg_display'],
								'options' => array('Cover' => 'cover', 'Fixed' => 'fixed', 'Tiled' => 'repeat'),
							),
							'banner_text_align' => array(
								'title' => esc_html__('Text Alignment', 'ns-basics'),
								'name' => 'ns_basics_banner_text_align',
								'type' => 'select',
								'order' => 10,
								'value' => $global_banner_settings['title_align'],
								'options' => array('Left' => 'left', 'Center' => 'center', 'Right' => 'right'),
							),
							'banner_padding_top' => array(
								'title' => esc_html__('Banner Padding Top', 'ns-basics'),
								'name' => 'ns_basics_banner_padding_top',
								'type' => 'number',
								'order' => 11,
								'value' => $global_banner_settings['padding_top'],
								'postfix' => 'Pixels',
							),
							'banner_padding_bottom' => array(
								'title' => esc_html__('Banner Padding Bottom', 'ns-basics'),
								'name' => 'ns_basics_banner_padding_bottom',
								'type' => 'number',
								'order' => 12,
								'value' => $global_banner_settings['padding_bottom'],
								'postfix' => 'Pixels',
							),
							'banner_overlay' => array(
								'title' => esc_html__('Display Banner Overlay', 'ns-basics'),
								'name' => 'ns_basics_banner_overlay',
								'type' => 'switch',
								'order' => 13,
								'value' => $global_banner_settings['overlay'],
							),
							'banner_overlay_opacity' => array(
								'title' => esc_html__('Banner Overlay Opacity', 'ns-basics'),
								'name' => 'ns_basics_banner_overlay_opacity',
								'description' => esc_html__('Choose an opacity ranging from 0 to 1 (0 is fully transparent).', 'ns-basics'),
								'type' => 'number',
								'order' => 14,
								'value' => $global_banner_settings['overlay_opacity'],
							),
							'banner_overlay_color' => array(
								'title' => esc_html__('Banner Overlay Color', 'ns-basics'),
								'name' => 'ns_basics_banner_overlay_color',
								'type' => 'color',
								'order' => 15,
								'value' => $global_banner_settings['overlay_color'],
							),
							'banner_display_breadcrumbs' => array(
								'title' => esc_html__('Display Breadcrumbs', 'ns-basics'),
								'name' => 'ns_basics_banner_breadcrumbs',
								'type' => 'switch',
								'order' => 16,
								'value' => $global_banner_settings['display_breadcrumb'],
							),
							'banner_display_search' => array(
								'title' => esc_html__('Display Search Form', 'ns-basics'),
								'name' => 'ns_basics_banner_search',
								'type' => 'switch',
								'order' => 17,
								'value' => $global_banner_settings['display_search'],
							),
						),
					),
					'banner_slider_layout' => array(
						'title' => esc_html__('Slider Layout', 'ns-basics'),
						'name' => 'ns_basics_banner_slider_layout',
						'type' => 'select',
						'options' => array('Minimal' => 'minimal', 'Detailed' => 'detailed'),
						'order' => 10,
						'parent_val' => 'slides',
					),
					'banner_slider_cat' => array(
						'title' => esc_html__('Display Slides from Category', 'ns-basics'),
						'name' => 'ns_basics_banner_slider_cat',
						'type' => 'select',
						'options' => $slide_cats_array,
						'order' => 11,
						'parent_val' => 'slides',
					),
					'banner_slider_num' => array(
						'title' => esc_html__('Number of Slides', 'ns-basics'),
						'name' => 'ns_basics_banner_slider_num',
						'type' => 'number',
						'order' => 12,
						'value' => 3,
						'parent_val' => 'slides',
					),
					'banner_shortcode' => array(
						'title' => esc_html__('Shortcode', 'ns-basics'),
						'name' => 'ns_basics_banner_shortcode',
						'description' => esc_html__('Copy and paste your shortcode to display content from other sources, such as a slider revolution.', 'ns-basics'),
						'type' => 'text',
						'order' => 13,
						'parent_val' => 'shortcode',
					),
				),
			),
			'page_layout' => array(
				'group' => 'page_layout',
				'title' => esc_html__('Page Layout', 'ns-basics'),
				'name' => 'ns_basics_page_layout',
				'value' => 'full',
				'description' => esc_html__('Select the layout of the page.', 'ns-basics'),
				'type' => 'radio_image',
				'options' => array(
					'Full Width' => array('value' => 'full', 'icon' => NS_BASICS_PLUGIN_DIR.'/images/full-width-icon.png'),
					'Right Sidebar' => array('value' => 'right sidebar', 'icon' => NS_BASICS_PLUGIN_DIR.'/images/right-sidebar-icon.png'),
					'Left Sidebar' => array('value' => 'left sidebar', 'icon' => NS_BASICS_PLUGIN_DIR.'/images/left-sidebar-icon.png'),
				),
				'order' => 10,
			),
			'page_layout_container' => array(
				'group' => 'page_layout',
				'title' => esc_html__('Use Page Container', 'ns-basics'),
				'name' => 'ns_basics_page_layout_container',
				'value' => 'true',
				'description' => esc_html__('If checked, the page content will be wrapped in a container.', 'ns-basics'),
				'type' => 'checkbox',
				'order' => 11,
			),
			'page_layout_widget_area' => array(
				'group' => 'page_layout',
				'title' => esc_html__('Sidebar Widget Area', 'ns-basics'),
				'name' => 'ns_basics_page_layout_widget_area',
				'value' => 'Page_sidebar',
				'type' => 'select',
				'options' => $sidebar_options,
				'order' => 6,
			),
			'cta_display' => array(
				'group' => 'cta',
				'title' => esc_html__('Display Call to Action', 'ns-basics'),
				'name' => 'ns_basics_cta_display',
				'value' => 'false',
				'description' => 'If checked, a call to action box will display at the bottom of the page.',
				'type' => 'checkbox',
				'order' => 7,
			),
			'cta_title' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Title', 'ns-basics'),
				'name' => 'ns_basics_cta_title',
				'type' => 'text',
				'order' => 8,
			),
			'cta_text' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Text', 'ns-basics'),
				'name' => 'ns_basics_cta_text',
				'type' => 'textarea',
				'order' => 9,
			),
			'cta_button_text' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Button Text', 'ns-basics'),
				'name' => 'ns_basics_cta_button_text',
				'type' => 'text',
				'order' => 10,
			),
			'cta_button_url' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Button URL', 'ns-basics'),
				'name' => 'ns_basics_cta_button_url',
				'type' => 'text',
				'order' => 11,
			),
			'cta_bg_img' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Background Image', 'ns-basics'),
				'name' => 'ns_basics_cta_bg_img',
				'type' => 'image_upload',
				'order' => 12,
			),
			'cta_bg_display' => array(
				'group' => 'cta',
				'title' => esc_html__('Call to Action Background Display', 'ns-basics'),
				'name' => 'ns_basics_cta_bg_display',
				'type' => 'select',
				'options' => array('Cover' => 'cover', 'Fixed' => 'fixed', 'Tile' => 'repeat'),
				'order' => 13,
			),
		);

		$page_settings_init = apply_filters( 'ns_basics_page_settings_init_filter', $page_settings_init);
		//usort($page_settings_init, 'ns_basics_sort_by_order');

		// Return default page settings
		if($return_defaults == true) {

			return $page_settings_init;

		// Return saved page settings
		} else {
			$page_settings = $this->admin_obj->get_meta_box_values($post_id, $page_settings_init);
			$page_settings = apply_filters( 'ns_basics_page_settings_filter', $page_settings);
			return $page_settings;
		}
		
	}

	/**
	 * Register Meta Box
	 */
	public function register_page_settings_meta_box() {
		$post_types = array('page');
        $post_types = apply_filters('ns_basics_page_settings_post_types', $post_types);
        add_meta_box( 'page-layout-meta-box', 'Page Settings', array( $this, 'output_page_settings_meta_box' ), $post_types, 'normal', 'low' );
	}

	/**
	 * Output Meta Box
	 */
	public function output_page_settings_meta_box($post) {

		$page_settings = $this->load_page_settings($post->ID);

		wp_nonce_field( 'ns_basics_page_layout_meta_box_nonce', 'ns_basics_page_layout_meta_box_nonce' );

		do_action( 'ns_basics_before_page_settings', $page_settings); ?>

		<div class="ns-accordion">
            <div class="ns-accordion-header"><i class="fa fa-chevron-right"></i> <?php echo esc_html_e('Banner', 'ns-basics'); ?></div>
            <div class="ns-accordion-content">
            	<?php
            	do_action( 'ns_basics_before_banner_settings', $page_settings);

            	foreach($page_settings as $setting) {
            		if($setting['group'] == 'banner') {
            			$this->admin_obj->build_admin_field($setting);
            		}
            	} 

            	do_action( 'ns_basics_after_banner_settings', $page_settings); ?>	             
            </div>
        </div><!-- end banner accordion -->

        <div class="ns-accordion">    
            <div class="ns-accordion-header"><i class="fa fa-chevron-right icon"></i> <?php echo esc_html_e('Page Layout', 'ns-basics'); ?></div>
            <div class="ns-accordion-content">
            	<?php
            	do_action( 'ns_basics_before_page_layout_settings', $page_settings);

            	foreach($page_settings as $setting) {
            		if($setting['group'] == 'page_layout') {
            			$this->admin_obj->build_admin_field($setting);
            		}
            	} 

            	do_action( 'ns_basics_after_page_layout_settings', $page_settings); ?>
            </div>
        </div><!-- end page layout accordion -->

        <div class="ns-accordion">    
            <div class="ns-accordion-header"><i class="fa fa-chevron-right icon"></i> <?php echo esc_html_e('Call to Action', 'ns-basics'); ?></div>
            <div class="ns-accordion-content">
            	<?php
            	do_action( 'ns_basics_before_page_cta_settings', $page_settings);

            	foreach($page_settings as $setting) {
            		if($setting['group'] == 'cta') {
            			$this->admin_obj->build_admin_field($setting);
            		}
            	} 

            	do_action( 'ns_basics_after_page_cta_settings', $page_settings); ?>
            </div>
        </div><!-- end cta accordion -->

        <?php do_action( 'ns_basics_after_page_settings', $page_settings);
	}


	/**
	 * Save Meta Box
	 */
	public function save_page_settings_meta_box($post_id) {
		
		// Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['ns_basics_page_layout_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ns_basics_page_layout_meta_box_nonce'], 'ns_basics_page_layout_meta_box_nonce' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post', $post_id ) ) return;

        // allow certain attributes
        $allowed = array(
            'a' => array('href' => array()),
            'b' => array(),
            'strong' => array(),
            'i' => array()
        );

        // Load page settings and save
        $page_settings = $this->load_page_settings($post_id);
        $this->admin_obj->save_meta_box($post_id, $page_settings, $allowed);
	}

}

?>