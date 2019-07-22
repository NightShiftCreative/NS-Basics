<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Slides_Likes class
 *
 *  Adds the slides custom post type
 */
class NS_Basics_Slides {

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
		add_action( 'init', array( $this, 'create_post_type' ));
		add_action( 'init', array( $this, 'create_category' ));
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ));
		add_action( 'save_post', array( $this, 'save_meta_box' ));
	}

	/************************************************************************/
	// Slides Custom Post Type
	/************************************************************************/

	/**
	 * Create Slides custom post type
	 */
	public function create_post_type() {
		register_post_type( 'slides',
            array(
                'labels' => array(
                    'name' => __( 'Slides', 'ns-basics' ),
                    'singular_name' => __( 'Slide', 'ns-basics' ),
                    'add_new_item' => __( 'Add New Slide', 'ns-basics' ),
                    'search_items' => __( 'Search Slides', 'ns-basics' ),
                    'edit_item' => __( 'Edit Slide', 'ns-basics' ),
                ),
            'public' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-format-gallery',
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page_attributes')
            )
        );
	}

	/**
	 * Load slide settings
	 *
	 * @param int $post_id
	 * @param boolean $return_defaults
	 */
	public function load_slide_settings($post_id, $return_defaults = false) {
		
		$slide_settings_init = array(
			'text_align' => array(
				'title' => esc_html__('Text Align', 'ns-basics'),
				'name' => 'ns_basics_slide_text_align',
				'type' => 'select',
				'options' => array('Left' => 'left', 'Center' => 'center', 'Right' => 'right'),
				'order' => 1,
			),
			'button_link' => array(
				'title' => esc_html__('Button Link', 'ns-basics'),
				'name' => 'ns_basics_slide_button_link',
				'description' => esc_html__('Provide a url for the slide button', 'ns-basics'),
				'type' => 'text',
				'order' => 2,
			),
			'button_text' => array(
				'title' => esc_html__('Button Text', 'ns-basics'),
				'name' => 'ns_basics_slide_button_text',
				'description'=> esc_html__('Provide the text for the slide button (If empty, button will be hidden)', 'ns-basics'),
				'type' => 'text',
				'order' => 3,
			),
			'overlay' => array(
				'title' => esc_html__('Overlay', 'ns-basics'),
				'name' => 'ns_basics_slide_overlay',
				'description'=> esc_html__('If checked, an overlay will display over the slide background image.', 'ns-basics'),
				'type' => 'checkbox',
				'order' => 4,
			),
			'overlay_opacity' => array(
				'title' => esc_html__('Overlay Opacity', 'ns-basics'),
				'name' => 'ns_basics_slide_overlay_opacity',
				'description'=> esc_html__('Choose an opacity ranging from 0 to 1 (0 is fully transparent).', 'ns-basics'),
				'type' => 'number',
				'value' => 0.50,
				'step' => 0.01,
				'min' => 0,
				'max' => 1,
				'order' => 5,
			),
			'overlay_color' => array(
				'title' => esc_html__('Overlay Color', 'ns-basics'),
				'name' => 'ns_basics_slide_overlay_color',
				'description'=> esc_html__('Choose the color of the overlay.', 'ns-basics'),
				'type' => 'color',
				'value' => '#000000',
				'order' => 6,
			),
		);

		$slide_settings_init = apply_filters( 'ns_basics_slide_settings_init_filter', $slide_settings_init);
		usort($slide_settings_init, 'ns_basics_sort_by_order');

		// Return default slide settings
		if($return_defaults == true) {
			
			return $slide_settings_init;
		
		// Return saved slide settings
		} else {
			$slide_settings = $this->admin_obj->get_meta_box_values($post_id, $slide_settings_init);
			$slide_settings = apply_filters( 'ns_basics_slide_settings_filter', $slide_settings);
			return $slide_settings;
		}
	}

	/**
	 * Register meta box
	 */
	public function add_meta_box() {
		add_meta_box( 'slide-meta-box', 'Slide Details', array( $this, 'output_meta_box' ), 'slides', 'normal', 'high' );
	}

	/**
	 * Output Meta Box
	 */
	public function output_meta_box($post) {

		$slide_settings = $this->load_slide_settings($post->ID);

		wp_nonce_field( 'ns_basics_slide_meta_box_nonce', 'ns_basics_slide_meta_box_nonce' );
		
		do_action( 'ns_basics_before_slide_settings', $slide_settings);
        foreach($slide_settings as $setting) { $this->admin_obj->build_admin_field($setting); } 
        do_action( 'ns_basics_after_slide_settings', $slide_settings);
	}

	/**
	 * Save Meta Box
	 */
	public function save_meta_box($post_id) {
		
		// Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['ns_basics_slide_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ns_basics_slide_meta_box_nonce'], 'ns_basics_slide_meta_box_nonce' ) ) return;

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
        $slide_settings = $this->load_slide_settings($post_id);
        $this->admin_obj->save_meta_box($post_id, $slide_settings, $allowed);
	}

	/**
	 * Create slide category
	 */
	public function create_category() {
		$labels = array(
		    'name'                          => __( 'Slide Category', 'ns-basics' ),
		    'singular_name'                 => __( 'Slide Category', 'ns-basics' ),
		    'search_items'                  => __( 'Search Slide Categories', 'ns-basics' ),
		    'popular_items'                 => __( 'Popular Slide Categories', 'ns-basics' ),
		    'all_items'                     => __( 'All Slide Categories', 'ns-basics' ),
		    'parent_item'                   => __( 'Parent Slide Category', 'ns-basics' ),
		    'edit_item'                     => __( 'Edit Slide Category', 'ns-basics' ),
		    'update_item'                   => __( 'Update Slide Category', 'ns-basics' ),
		    'add_new_item'                  => __( 'Add New Slide Category', 'ns-basics' ),
		    'new_item_name'                 => __( 'New Slide Category', 'ns-basics' ),
		    'separate_items_with_commas'    => __( 'Separate categories with commas', 'ns-basics' ),
		    'add_or_remove_items'           => __( 'Add or remove categories', 'ns-basics' ),
		    'choose_from_most_used'         => __( 'Choose from most used categories', 'ns-basics' )
	    );
	    
	    register_taxonomy(
	        'slide_category',
	        'slides',
	        array(
	            'label'         => __( 'Slide Category', 'ns-basics' ),
	            'labels'        => $labels,
	            'hierarchical'  => true,
	            'rewrite' => array( 'slug' => 'slide-category' )
	        )
	    );
	}
}

?>