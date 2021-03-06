<?php
/**
* Plugin Name: Nightshift Basics
* Plugin URI: http://nightshiftcreative.co/
* Description: The framework essential for all themes and plugins built by Nightshift Creative.
* Version: 1.0.8
* Author: Nightshift Creative
* Author URI: http://nightshiftcreative.co/
* Text Domain: ns-basics
**/

// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

class NS_Basics {

	/**
	 * Constructor - intialize the plugin
	 */
	public function __construct() {
		
		//Add actions & filters
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_filter( 'script_loader_tag', array( $this, 'async' ), 10, 3 );
		add_filter('style_loader_tag', array( $this, 'web_font_preload' ), 10, 2);

		//Functions
		$this->load_plugin_textdomain();
		$this->define_constants();
		$this->update_checker();
		$this->includes();
	}

	/**
	 * Load the textdomain for translation
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'ns-basics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Define constants
	 */
	public function define_constants() {
		if(!defined('NS_BASICS_VERSION')) { define('NS_BASICS_VERSION', '1.0.8'); }
		if(!defined('NS_BASICS_URL')) { define('NS_BASICS_URL', 'https://nightshiftcreative.co/'); }
		if(!defined('NS_BASICS_SHOP_URL')) { define('NS_BASICS_SHOP_URL', 'https://products.nightshiftcreative.co/'); }
		if(!defined('NS_BASICS_GITHUB_REPO')) { define('NS_BASICS_GITHUB_REPO', '/NightShiftCreative/NS-Basics/'); }
		if(!defined('NS_BASICS_GITHUB')) { define('NS_BASICS_GITHUB', '/NightShiftCreative/NS-Basics/archive/1.0.7.zip'); }
		if(!defined('NS_BASICS_PLUGIN_DIR')) { define('NS_BASICS_PLUGIN_DIR', plugins_url('', __FILE__)); } 
	}

	/**
	 * Update Checker
	 *
	 * Checks for new releases on github
	 */
	public function update_checker() {
		require 'assets/plugin-update-checker/plugin-update-checker.php';
		$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		    'https://github.com'.constant('NS_BASICS_GITHUB_REPO'),
		    __FILE__,
		    'ns-basics'
		);
	}

	/**
	 * Load front end scripts and styles
	 */
	public function frontend_scripts() {
		if (!is_admin()) {
	        wp_enqueue_style('ns-font-awesome',  plugins_url('/css/font-awesome/css/all.min.css', __FILE__), array(), '', 'all');
	        wp_enqueue_style('ns-basics-css',  plugins_url('/css/ns-basics.css', __FILE__), array(), '', 'all');
	        wp_enqueue_script('ns-basics', plugins_url('/js/ns-basics.js', __FILE__), array('jquery', 'jquery-ui-core'), '', true);

	        //pre-load web fonts
	        wp_enqueue_style('ns-font-awesome-brands-400', plugins_url('/css/font-awesome/webfonts/fa-brands-400.woff2', __FILE__), array(), null);
	        wp_enqueue_style('ns-font-awesome-solid-900', plugins_url('/css/font-awesome/webfonts/fa-solid-900.woff2', __FILE__), array(), null);

	        //wordpress pre-loaded scripts
	        wp_enqueue_script('jquery-ui-core');
	        wp_enqueue_script('jquery-ui-accordion');
	        wp_enqueue_script('jquery-ui-tabs');

	        wp_localize_script('ns-basics', 'ns_basics_local_script', array(
			    'ajaxurl' => admin_url('admin-ajax.php')
			));
	    }
	}

	/**
	 * Load admin scripts and styles
	 */
	public function admin_scripts() {
		if (is_admin()) {

			//include scripts
        	wp_enqueue_script('ns-basics-admin-js', plugins_url('/js/ns-basics-admin.js', __FILE__), array('jquery','media-upload','thickbox', 'wp-color-picker'), '', true);
        	wp_enqueue_script('featherlight', plugins_url('/assets/featherlight/featherlight.js', __FILE__), array('jquery'), '', true);
        	wp_enqueue_script('chosen', plugins_url('/assets/chosen_v1.8.7/chosen.jquery.min.js', __FILE__), array('jquery'), '', true);

        	//include styles
	        wp_enqueue_style('featherlight',  plugins_url('/assets/featherlight/featherlight.css',  __FILE__), array(), '1.0', 'all');
	        wp_enqueue_style('chosen',  plugins_url('/assets/chosen_v1.8.7/chosen.min.css', __FILE__), array(), '', 'all');
	        wp_enqueue_style('ns-basics-admin-css',  plugins_url('/css/ns-basics-admin.css',  __FILE__), array(), '1.0', 'all');
	        wp_enqueue_style('ns-font-awesome',  plugins_url('/css/font-awesome/css/all.min.css', __FILE__), array(), '', 'all');

        	//wordpress pre-loaded scripts
	        if(function_exists( 'wp_enqueue_media' )) { wp_enqueue_media(); } else { wp_enqueue_script('media-upload'); }
	        wp_enqueue_script('thickbox');
	        wp_enqueue_style('thickbox');
	        wp_enqueue_script( 'jquery-form', array( 'jquery' ) );
	        wp_enqueue_script('jquery-ui-core');
	        wp_enqueue_script( 'jquery-ui-datepicker' );
	        wp_enqueue_style( 'wp-color-picker' );

	        /* localize scripts */
	        $translation_array = array(
	            'admin_url' => esc_url(get_admin_url()),
	            'plugins_url' => plugins_url('',  __FILE__),
	            'delete_text' => __( 'Delete', 'ns-basics' ),
	            'remove_text' => __( 'Remove', 'ns-basics' ),
	            'save_text' => __( 'Save', 'ns-basics' ),
	            'edit_text' => __( 'Edit', 'ns-basics' ),
	            'upload_img' => __( 'Upload Image', 'ns-basics' ),
	            'new_testimonial' => __( 'New Testimonial', 'ns-basics' ),
	            'testimonial' => __( 'Testimonial', 'ns-basics' ),
	            'position' => __( 'Position', 'ns-basics' ),
	            'image_url' => __( 'Image URL', 'ns-basics' ),
	            'name_text' => __( 'Name', 'ns-basics' ),
	        );
	        wp_localize_script( 'ns-basics-admin-js', 'ns_basics_local_script', $translation_array );

		}
	}

	/**
	 * Web font pre-loader
	 */
	public function web_font_preload($html, $handle) {
		if ($handle === 'ns-font-awesome-brands-400' || $handle === 'ns-font-awesome-solid-900') {
	        return str_replace("rel='stylesheet'",
	            "rel='preload' as='font' type='font/woff2' crossorigin='anonymous'", $html);
	    }
	    return $html;
	}

	/**
	 * Async 
	 *
	 * Adds async/defer attributes to non-critical scripts/styles
	 */
	public function async($tag, $handle, $src) {
		if (!is_admin()) {
	        $script_array = array('ns-basics-post-likes-js');
	        if (in_array($handle, $script_array)) {
	            $tag = '<script async type="text/javascript" src="' . esc_url( $src ) . '"></script>';
	        }
	    }
		return $tag;
	}

	/**
	 * Load includes
	 */
	public function includes() {

		/************************************************************************/
		// Include functions
		/************************************************************************/
		include( plugin_dir_path( __FILE__ ) . 'includes/global-functions.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/templates/templates.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/wp-bakery.php');

		/************************************************************************/
		// Include classes
		/************************************************************************/
		
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-admin.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-modules.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-members.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-page-settings.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-post-sharing.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-post-likes.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-slides.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-shortcodes.php');
		include( plugin_dir_path( __FILE__ ) . 'includes/classes/class-ns-basics-global-blocks.php');

		// Setup the admin
		if(is_admin()) { 
			$this->admin = new NS_Basics_Admin();
			$this->admin->init();
		}
		
		// Load modules class
		$this->modules = new NS_Basics_Modules();
		
		// Load members class
		$this->members = new NS_Basics_Members();
		$this->members->init();
		
		// Load page settings class
		if($this->modules->is_module_active('ns_basics_page_settings')) { 
			$this->page_settings = new NS_Basics_Page_Settings();
			$this->page_settings->init(); 
		}

		// Load post share class
		if($this->modules->is_module_active('ns_basics_post_share')) { 
			$this->post_sharing = new NS_Basics_Post_Sharing(); 
			$this->post_sharing->init();
		}

		// Load post likes class
		if($this->modules->is_module_active('ns_basics_post_likes')) { 
			$this->post_likes = new NS_Basics_Post_Likes();
			$this->post_likes->init(); 
		}

		// Load slides class
		if($this->modules->is_module_active('ns_basics_slides')) { 
			$this->slides = new NS_Basics_Slides(); 
			$this->slides->init();
		}

		// Load shortcodes class
		if($this->modules->is_module_active('ns_basics_shortcodes')) { 
			$this->shortcodes = new NS_Basics_Shortcodes(); 
		}

		// Load widget classes
		if($this->modules->is_module_active('ns_basics_widgets')) { 
			include( plugin_dir_path( __FILE__ ) . 'includes/classes/widgets/contact_info_widget.php');
			include( plugin_dir_path( __FILE__ ) . 'includes/classes/widgets/list_posts_widget.php');
			include( plugin_dir_path( __FILE__ ) . 'includes/classes/widgets/social_links_widget.php');
			include( plugin_dir_path( __FILE__ ) . 'includes/classes/widgets/testimonials_widget.php');
		}

		// Load global blocks class
		if($this->modules->is_module_active('ns_basics_global_blocks')) { 
			$this->global_blocks = new NS_Basics_Global_Blocks(); 
			$this->global_blocks->init();
		}
	}

}

/**
 *  Load the main class
 */
function ns_basics() {
	global $ns_basics;
	if(!isset($ns_basics)) { $ns_basics = new NS_Basics(); }
	return $ns_basics;
}
ns_basics();

?>