<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Modules class
 *
 */
class NS_Basics_Modules {

	/**
	 *	Constructor
	 */
	public function __construct() {
		
	}

	/**
	 *	Load default modules
	 */
	public function load_default_modules() {
		
		$default_modules = array(
	        1 => array(
	            'name' => 'Post Sharing',
	            'slug' => 'ns_basics_post_share',
	            'icon' => plugins_url('/ns-basics/images/icon-post-sharing.svg'),
	            'note' => esc_html__('Allow your users to share your posts on popular social media sites.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/post-sharing/',
	            'active' => 'true',
	        ),
	        2 => array(
	            'name' => 'Post Likes',
	            'slug' => 'ns_basics_post_likes',
	            'icon' => plugins_url('/ns-basics/images/icon-post-likes.svg'),
	            'note' => esc_html__('Allow your users to like your posts and save them for later viewing.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/post-likes/',
	            'active' => 'true',
	        ),
	        3 => array(
	            'name' => 'Page Settings',
	            'slug' => 'ns_basics_page_settings',
	            'icon' => plugins_url('/ns-basics/images/icon-page-settings.svg'),
	            'note' => esc_html__('Add advanced options to pages & posts, allowing further control over banners, page layout and more.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/page-settings/',
	            'active' => 'true',
	        ),
	        4 => array(
	            'name' => 'Slides',
	            'slug' => 'ns_basics_slides',
	            'icon' => plugins_url('/ns-basics/images/icon-slides.svg'),
	            'note' => esc_html__('Add slides custom post type', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/slides/',
	            'active' => 'true',
	        ),
	        5 => array(
	            'name' => 'Basic Shortcodes',
	            'slug' => 'ns_basics_shortcodes',
	            'icon' => plugins_url('/ns-basics/images/icon-basic-shortcodes.svg'),
	            'note' => esc_html__('Add helpful shortcodes, including buttons, videos, testimonials, accordions, and more.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/shortcodes/',
	            'active' => 'true',
	        ),
	        6 => array(
	            'name' => 'Basic Widgets',
	            'slug' => 'ns_basics_widgets',
	            'icon' => plugins_url('/ns-basics/images/icon-basic-widgets.svg'),
	            'note' => esc_html__('Add helpful widgets, including social sharing, testimonials, contact info, and more.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/widgets/',
	            'active' => 'true',
	        ),
	        7 => array(
	            'name' => 'Global Blocks',
	            'slug' => 'ns_basics_global_blocks',
	            'icon' => plugins_url('/ns-basics/images/icon-basic-widgets.svg'),
	            'note' => esc_html__('Add global content blocks that can be displayed through out your site.', 'ns-basics'),
	            'group' => 'basic',
	            'required_theme_support' => '',
	            //'link' => constant('NS_BASICS_SHOP_URL').'docs/ns-basics/widgets/',
	            'active' => 'false',
	        ),
	    );

	    //update active add-ons
	    $active_modules = get_option('ns_basics_active_add_ons');
	    if(!empty($active_modules)) {
	        foreach($default_modules as $key => $value) {
	            if (in_array($default_modules[$key]['slug'], $active_modules)) {
	                $default_modules[$key]['active'] = 'true';
	            } else {
	                $default_modules[$key]['active'] = 'false';
	            }
	        }
	    }

	    return $default_modules;

	}

	/**
	 *	Output modules
	 *
	 * @param string $group
	 */
	public function output_modules($group = null) {

		$modules = $this->load_default_modules();
		$current_theme = wp_get_theme();
		ob_start(); ?>

		<div class="ns-module-group ns-module-group-basic">
	        <?php $count = 1;
	        foreach($modules as $module) { 
	            if(!empty($group) && $module['group'] == $group) { 
	                if(isset($module['active']) && $module['active'] == 'true') { $active = 'true'; } else { $active = 'false'; } ?>
	                <div class="admin-module <?php if($active == 'true') { echo 'active-add-on'; } ?>">
	                    
	                    <div class="ns-module-header">
	                        <?php if(!empty($module['icon'])) { ?><div class="ns-module-icon"><img src="<?php echo $module['icon']; ?>" alt="" /></div><?php } ?>
	                        <?php if(!empty($module['name'])) { ?><h4><?php echo $module['name']; ?></h4><?php } ?>
	                        
	                        <?php if(!empty($module['required_theme_support']) && !current_theme_supports($module['required_theme_support'])) { ?>    
	                            <div class="admin-alert-box admin-info theme-message">
	                                <?php esc_html_e('Incompatible theme.', 'ns-basics'); ?>
	                                <a href="<?php echo NS_BASICS_SHOP_URL; ?>" target="_blank"><?php esc_html_e('Get a Compatible Theme', 'ns-basics'); ?></a>
	                            </div>
	                        <?php } else { ?>
	                            <div class="toggle-switch" title="<?php if($active == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
	                                <input type="checkbox" id="<?php echo $module['slug']; ?>" name="ns_basics_active_add_ons[]" value="<?php echo $module['slug']; ?>" class="toggle-switch-checkbox" <?php checked('true', $active, true) ?> />
	                                <label class="toggle-switch-label" for="<?php echo $module['slug']; ?>"><?php if($active == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
	                            </div>
	                        <?php } ?>
	                    </div>    

	                    <div class="ns-module-content">
	                        <?php if(!empty($module['note'])) { ?><span class="admin-module-note"><?php echo $module['note']; ?></span><?php } ?>
	                        <?php if(!empty($module['link'])) { ?><a href="<?php echo $module['link']; ?>" target="_blank" class="view-details ns-meta-item"><i class="fa fa-arrow-right icon"></i> <?php esc_html_e('View Docs', 'ns-basics'); ?> </a><?php } ?>
	                    </div>
	                </div>
	                <?php $count++; 
	            }
	        } ?>
	        <div class="clear"></div>
	    </div>

		<?php $modules = ob_get_clean();
		return $modules;
	}

	/**
	 *	Check if module is active
	 *
	 * @param string $module_slug - The module slug
	 */
	public function is_module_active($module_slug) {
		$modules = $this->load_default_modules();
	    $is_active = false;

	    foreach($modules as $module) {
	        if($module_slug == $module['slug'] && (isset($module['active']) && $module['active'] == 'true')) { 
	            $is_active = true; 
	        }
	    }
	    return $is_active;
	}

}

?>