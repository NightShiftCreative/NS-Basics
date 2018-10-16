<?php
/**
* Plugin Name: NightShift Basics
* Plugin URI: http://nightshiftcreative.co/
* Description: The framework essential for all themes and plugins built by NightShift Creative.
* Version: 1.0.0
* Author: NightShift Creative
* Author URI: http://nightshiftcreative.co/
* Text Domain: ns-basics
**/

/*-----------------------------------------------------------------------------------*/
/*  Load Text Domain
/*-----------------------------------------------------------------------------------*/
load_plugin_textdomain( 'ns-basics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

/*-----------------------------------------------------------------------------------*/
/*  Automatic Update Checker (checks for new releases on github)
/*-----------------------------------------------------------------------------------*/
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/NightShiftCreative/NS-Basics',
    __FILE__,
    'ns-basics'
);

/*-----------------------------------------------------------------------------------*/
/*  Include Admin Scripts and Stylesheets
/*-----------------------------------------------------------------------------------*/
function ns_basics_load_stylesheets() {
    if (is_admin()) {

        //include scripts
        wp_enqueue_script('ns-basics-admin-js', plugins_url('/js/ns-basics-admin.js', __FILE__), array('jquery','media-upload','thickbox', 'wp-color-picker'), '', true);
        wp_enqueue_script('featherlight', plugins_url('/assets/featherlight/featherlight.js', __FILE__), array('jquery'), '', true);

        //include styles
        wp_enqueue_style('featherlight',  plugins_url('/assets/featherlight/featherlight.css',  __FILE__), array(), '1.0', 'all');
        wp_enqueue_style('ns-basics-admin-css',  plugins_url('/css/ns-basics-admin.css',  __FILE__), array(), '1.0', 'all');
        wp_enqueue_style('font-awesome',  plugins_url('/css/font-awesome/css/font-awesome.min.css', __FILE__), array(), '', 'all');

        //wordpress pre-loaded scripts
        if(function_exists( 'wp_enqueue_media' )) { wp_enqueue_media(); } else { wp_enqueue_script('media-upload'); }
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_script( 'jquery-form', array( 'jquery' ) );
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style( 'wp-color-picker' );

        /* localize scripts */
        $translation_array = array(
            'admin_url' => esc_url(get_admin_url()),
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
            'off' => __( 'Off', 'ns-basics' ),
            'on' => __( 'On', 'ns-basics' ),
        );
        wp_localize_script( 'ns-basics-admin-js', 'ns_basics_local_script', $translation_array );

    }
}
add_action('admin_enqueue_scripts', 'ns_basics_load_stylesheets');

/*-----------------------------------------------------------------------------------*/
/*  Include Front-End Scripts and Styles
/*-----------------------------------------------------------------------------------*/
function ns_basics_front_end_scripts() {
    if (!is_admin()) {
        wp_enqueue_style('font-awesome',  plugins_url('/css/font-awesome/css/font-awesome.min.css', __FILE__), array(), '', 'all');
        wp_enqueue_script('ns-basics', plugins_url('/js/ns-basics.js', __FILE__), array('jquery', 'jquery-ui-core'), '', true);

        //wordpress pre-loaded scripts
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-tabs');
    }
}
add_action('wp_enqueue_scripts', 'ns_basics_front_end_scripts');

/*-----------------------------------------------------------------------------------*/
/*  GLOBAL FUNCTIONS
/*-----------------------------------------------------------------------------------*/
/* set add-ons data */
function ns_basics_get_add_ons() {

    $add_ons = array(
        1 => array(
            'name' => 'Post Sharing',
            'slug' => 'ns_basics_post_share',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Add ability to share blog posts on social media', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
        2 => array(
            'name' => 'Post Likes',
            'slug' => 'ns_basics_post_likes',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Allow users to "like" posts', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
        3 => array(
            'name' => 'Page Settings',
            'slug' => 'ns_basics_page_settings',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Add flexible options to pages & posts', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
        4 => array(
            'name' => 'Slides',
            'slug' => 'ns_basics_slides',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Add slides custom post type', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
        5 => array(
            'name' => 'Basic Shortcodes',
            'slug' => 'ns_basics_shortcodes',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Add some helpful shortcodes', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
        6 => array(
            'name' => 'Basic Widgets',
            'slug' => 'ns_basics_widgets',
            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
            'note' => esc_html__('Add some helpful widgets', 'ns-basics'),
            'group' => 'basic',
            'required_theme_support' => '',
            'link' => 'http://nightshiftcreative.co/',
            'active' => 'true',
        ),
    );

    //update active add-ons
    $active_add_ons = get_option('ns_basics_active_add_ons');
    if(!empty($active_add_ons)) {
        foreach($add_ons as $key => $value) {
            if (in_array($add_ons[$key]['slug'], $active_add_ons)) {
                $add_ons[$key]['active'] = 'true';
            } else {
                $add_ons[$key]['active'] = 'false';
            }
        }
    }
 
    return $add_ons;
}

/** loop through add-ons **/
function ns_basics_display_add_ons($group = null) {
    $add_ons = ns_basics_get_add_ons();
    $current_theme = wp_get_theme();
    $output = '';

    ob_start(); ?>

    <div class="ns-module-group ns-module-group-basic">
        <?php $count = 1;
        foreach($add_ons as $add_on) { 
            if(!empty($group) && $add_on['group'] == $group) { 
                if(isset($add_on['active']) && $add_on['active'] == 'true') { $active = 'true'; } else { $active = 'false'; } ?>
                <div class="admin-module <?php if($active == 'true') { echo 'active-add-on'; } ?>">
                    
                    <div class="ns-module-header">
                        <?php if(!empty($add_on['icon'])) { ?><div class="ns-module-icon"><img src="<?php echo $add_on['icon']; ?>" alt="" /></div><?php } ?>
                        <?php if(!empty($add_on['name'])) { ?><h4><?php echo $add_on['name']; ?></h4><?php } ?>
                        
                        <?php if(!empty($add_on['required_theme_support']) && !current_theme_supports($add_on['required_theme_support'])) { ?>    
                            <div class="admin-alert-box admin-info theme-message">
                                <?php esc_html_e('Incompatible theme.', 'ns-basics'); ?>
                                <a href="http://nightshiftcreative.co/project-types/themes/" target="_blank"><?php esc_html_e('Get a Compatible Theme', 'ns-basics'); ?></a>
                            </div>
                        <?php } else { ?>
                            <div class="toggle-switch" title="<?php if($active == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                                <input type="checkbox" id="<?php echo $add_on['slug']; ?>" name="ns_basics_active_add_ons[]" value="<?php echo $add_on['slug']; ?>" class="toggle-switch-checkbox" <?php checked('true', $active, true) ?> />
                                <label class="toggle-switch-label" for="<?php echo $add_on['slug']; ?>"><?php if($active == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                            </div>
                        <?php } ?>
                    </div>    

                    <div class="ns-module-content">
                        <?php if(!empty($add_on['note'])) { ?><span class="admin-module-note"><?php echo $add_on['note']; ?></span><?php } ?>
                        <?php if(!empty($add_on['paid'])) { ?><a href="<?php echo $add_on['paid']['link']; ?>" target="_blank" class="ns-meta-item"><?php esc_html_e('Premium', 'ns-basics'); ?> </a><?php } ?>
                        <?php if(!empty($add_on['link'])) { ?><a href="<?php echo $add_on['link']; ?>" target="_blank" class="view-details ns-meta-item"><?php esc_html_e('View Details', 'ns-basics'); ?> </a><?php } ?>
                    </div>
                </div>
                <?php $count++; 
            }
        } ?>
        <div class="clear"></div>
    </div>

    <?php $output = ob_get_clean();
    return $output;
}

/* check if add-on is active */
function ns_basics_is_active($add_on_slug) {
    $add_ons = ns_basics_get_add_ons();
    $is_active = false;

    foreach($add_ons as $add_on) {
        if($add_on_slug == $add_on['slug'] && (isset($add_on['active']) && $add_on['active'] == 'true')) { 
            $is_active = true; 
        }
    }
    return $is_active;
}

/*-----------------------------------------------------------------------------------*/
/*  ADD ADMIN MENU ITEMS
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'ns_basics_plugin_menu');
function ns_basics_plugin_menu() {
    add_menu_page('NS Basics', 'NS Basics', 'administrator', 'ns-basics-settings', 'ns_basics_settings_page', 'dashicons-admin-generic');
    add_submenu_page('ns-basics-settings', 'Settings', 'Settings', 'administrator', 'ns-basics-settings');
    add_submenu_page('ns-basics-settings', 'Help', 'Help', 'administrator', 'ns-basics-help', 'ns_basics_help_page');
    add_action( 'admin_init', 'ns_basics_register_options' );
}

/*-----------------------------------------------------------------------------------*/
/*  REGISTER SETTINGS
/*-----------------------------------------------------------------------------------*/
function ns_basics_register_options() {
    register_setting( 'ns-basics-settings-group', 'ns_basics_active_add_ons');
}

/*-----------------------------------------------------------------------------------*/
/*  BUILD ADMIN PAGE TEMPLATE
/*  Note: this template is used for all plugins that require NS Basics
/*-----------------------------------------------------------------------------------*/
function ns_basics_admin_page($page_name = null, $settings_group = null, $pages = null, $display_actions = null, $content = null, $content_class = null, $content_nav = null, $alerts = null, $ajax = true) { ?>
    <div class="wrap">
        <?php if(!empty($page_name)) { ?><h1><?php echo $page_name; ?></h1><?php } ?>

        <form method="post" action="options.php" class="ns-settings <?php if($ajax == true) { echo 'ns-settings-ajax'; } ?>">
            <?php if(!empty($settings_group)) { 
                settings_errors();
                settings_fields($settings_group);
                do_settings_sections($settings_group); 
            } ?>

            <div class="ns-settings-menu-bar ns-settings-header">
                <?php if(!empty($pages)) { ?>
                <div class="ns-settings-nav">
                    <ul>
                        <?php $current_page = $_GET['page']; ?>
                        <?php foreach($pages as $page) { ?>
                        <li <?php if($page['slug'] == $current_page) { echo 'class="active"'; } ?>><a href="<?php echo admin_url('admin.php?page='.$page['slug']); ?>"><?php echo $page['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <?php if($display_actions != 'false') { ?>
                    <div class="ns-settings-actions">
                        <div class="loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /></div> 
                        <?php submit_button(esc_html__('Save Changes', 'ns-basics'), 'admin-button', 'submit', false); ?>
                    </div>
                <?php } ?>
                <div class="clear"></div>
            </div>

            <div class="ns-settings-content <?php if(!empty($content_class)) { echo $content_class; } ?>">

                <?php echo ns_basics_admin_alert('success', esc_html__('Settings Saved Successfully', 'ns-basics'), null, null, true, 'settings-saved'); ?>

                <?php if(!empty($alerts)) {
                    foreach($alerts as $alert) { echo $alert; }
                } ?>

                <div id="tabs" class="ui-tabs">
                    <?php if(!empty($content_nav)) { ?>
                    <div class="ns-settings-content-nav">
                        <div class="ns-settings-content-nav-filler"></div>
                        <ul class="ui-tabs-nav">
                            <?php foreach($content_nav as $nav_item) { ?>
                                <li><a href="<?php echo $nav_item['link']; ?>"><?php if(!empty($nav_item['icon'])) { echo '<i class="fa '.$nav_item['icon'].'"></i>'; } ?><?php echo $nav_item['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>

                    <div class="content-wrap <?php if(!empty($content_nav)) { echo 'content-has-nav'; } ?>">
                        <?php if(!empty($content_nav)) { ?><div class="tab-loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /> <?php esc_html_e('Loading...', 'ns-basics'); ?></div><?php } ?>
                        <?php if(!empty($content)) { echo $content; } ?>
                    </div>
                </div>

                <div class="clear"></div>
                <?php echo ns_basics_admin_alert('success', esc_html__('Settings Saved Successfully', 'ns-basics'), null, null, true, 'settings-saved'); ?>
            </div>

            <div class="ns-settings-menu-bar ns-settings-footer">
                <?php
                $plugin_data = get_plugin_data( __FILE__ );
                $plugin_version = $plugin_data['Version']; 
                ?>
                <div class="ns-settings-version left"><?php esc_html_e('Version', 'ns-basics'); ?> <?php echo $plugin_version; ?> | <?php esc_html_e('Made by', 'ns-basics'); ?> <a href="http://nightshiftcreative.co/" target="_blank">NightShift Creative</a> | <a href="http://nightshiftcreative.co/contact/#theme-support" target="_blank"><?php esc_html_e('Get Support', 'ns-basics'); ?></a></div>
                <?php if($display_actions != 'false') { ?>
                    <div class="ns-settings-actions">
                        <div class="loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /></div> 
                        <?php submit_button(esc_html__('Save Changes', 'ns-basics'), 'admin-button', 'submit', false); ?>      
                    </div>
                <?php } ?>
                <div class="clear"></div>
            </div>

        </form>
    </div>
<?php }

/*-----------------------------------------------------------------------------------*/
/*  OUTPUT SETTINGS PAGE
/*-----------------------------------------------------------------------------------*/
function ns_basics_settings_page() { 
    $page_name = 'NightShift Basics';
    $settings_group = 'ns-basics-settings-group';
    $pages = array();
    $pages[] = array('slug' => 'ns-basics-settings', 'name' => 'Settings');
    $pages[] = array('slug' => 'ns-basics-help', 'name' => 'Help');
    $display_actions = 'true';
    $content = ns_basics_settings_page_content();
    $content_class = 'ns-modules';
    $content_nav = null;
    $alerts = array();
    if(!current_theme_supports('ns-basics')) {
        $current_theme = wp_get_theme();
        $incompatible_theme_alert = ns_basics_admin_alert('info', esc_html__('The active theme ('.$current_theme->name.') does not support NightShift Basics.', 'ns-basics'), $action = '#', $action_text = esc_html__('Get a compatible theme', 'ns-basics'), true); 
        $alerts[] = $incompatible_theme_alert; 
    }

    echo ns_basics_admin_page($page_name, $settings_group, $pages, $display_actions, $content, $content_class, $content_nav, $alerts);
}

function ns_basics_settings_page_content() {
    ob_start(); 
    echo ns_basics_display_add_ons('basic');
    $output = ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  OUTPUT HELP PAGE
/*-----------------------------------------------------------------------------------*/
function ns_basics_help_page() { 
    $page_name = 'NightShift Basics';
    $settings_group = null;
    $pages = array();
    $pages[] = array('slug' => 'ns-basics-settings', 'name' => 'Settings');
    $pages[] = array('slug' => 'ns-basics-help', 'name' => 'Help');
    $display_actions = 'false';
    $content = ns_basics_help_page_content();
    $content_class = null;
    echo ns_basics_admin_page($page_name, $settings_group, $pages, $display_actions, $content, $content_class);
}

function ns_basics_help_page_content() {
    ob_start(); 
    //content goes here
    $output = ob_get_clean();
    return $output;
}


/*-----------------------------------------------------------------------------------*/
/*  INCLUDE ADD-ONS
/*-----------------------------------------------------------------------------------*/
/*--------------------------------------------*/
/*  Global Functions */
/*--------------------------------------------*/
include( plugin_dir_path( __FILE__ ) . 'includes/global-functions.php');

/*--------------------------------------------*/
/*  License Keys */
/*--------------------------------------------*/
include( plugin_dir_path( __FILE__ ) . 'includes/license-keys.php');

/*--------------------------------------------*/
/*  Post Sharing */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_post_share')) { include( plugin_dir_path( __FILE__ ) . 'includes/post-sharing/post-sharing.php'); }

/*--------------------------------------------*/
/*  Post Likes */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_post_likes')) { include( plugin_dir_path( __FILE__ ) . 'includes/post-likes/post-likes.php'); }

/*--------------------------------------------*/
/* Page Settings */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_page_settings')) { include( plugin_dir_path( __FILE__ ) . 'includes/page-settings/page-settings.php'); }

/*--------------------------------------------*/
/*  Slides */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_slides')) { include( plugin_dir_path( __FILE__ ) . 'includes/slides/slides.php'); }

/*--------------------------------------------*/
/*  Basic Shortcodes */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_shortcodes')) { include( plugin_dir_path( __FILE__ ) . 'includes/basic-shortcodes/shortcodes.php'); }

/*--------------------------------------------*/
/*  Basic Widgets */
/*--------------------------------------------*/
if(ns_basics_is_active('ns_basics_widgets')) {
    include('includes/basic-widgets/contact_info_widget.php');
    include('includes//basic-widgets/social_links_widget.php');
    include('includes/basic-widgets/list_posts_widget.php');
    include('includes/basic-widgets/testimonials_widget.php');
}

/*--------------------------------------------*/
/*  Members */
/*--------------------------------------------*/
include( plugin_dir_path( __FILE__ ) . 'includes/members/members.php');

/*--------------------------------------------*/
/*  Templates */
/*--------------------------------------------*/
include( plugin_dir_path( __FILE__ ) . 'includes/templates/templates.php');