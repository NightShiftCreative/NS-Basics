<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Admin class
 *
 *  Outputs admin pages and provides the core methods for building admin interfaces.
 */
class NS_Basics_Admin {

	/**
	 *	Constructor
	 */
	public function __construct() {
		//Add actions & filters
		add_action('admin_menu', array( $this, 'admin_menu' ));
		add_action( 'admin_init', array( $this, 'register_settings' ));
	}

	/**
	 *	Add admin menu
	 */
	public function admin_menu() {
		add_menu_page('NS Basics', 'NS Basics', 'administrator', 'ns-basics-settings', array( $this, 'settings_page' ), NS_BASICS_PLUGIN_DIR.'/images/icon.png');
    	add_submenu_page('ns-basics-settings', 'Settings', 'Settings', 'administrator', 'ns-basics-settings');
    	add_submenu_page('ns-basics-settings', 'Resources', 'Resources', 'administrator', 'ns-basics-resources', array( $this, 'resources_page' ));
	}

	/**
	 *	Register settings
	 */
	public function register_settings() {
		register_setting( 'ns-basics-settings-group', 'ns_basics_active_add_ons');
	}

	/**
	 *	Build admin page
	 *
	 *  Generates an admin page template. Used across all plugins that require NS Basics
	 *
	 *  @param array $args
	 *		
	 */
	public function build_admin_page($args = null) {
		
		if($args == null) {
			$args = array (
				'page_name' => 'Hello World',
				'settings_group' => null,
				'pages' => null,
				'display_actions' => null,
				'content' => '',
				'content_class' => null,
				'content_nav'=> null,
				'alerts' => null,
				'ajax' => true,
				'icon' => null,
			);
		}
		?>
		<div class="wrap">
			<?php if(!empty($args['page_name'])) { ?><h1><?php echo $args['page_name']; ?></h1><?php } ?>
			<form method="post" action="options.php" class="ns-settings <?php if($args['ajax'] == true) { echo 'ns-settings-ajax'; } ?>">

				<?php if(!empty($args['settings_group'])) { 
	                settings_errors();
	                settings_fields($args['settings_group']);
	                do_settings_sections($args['settings_group']); 
	            } ?>

	            <div class="ns-settings-menu-bar ns-settings-header">
	                <?php if(!empty($args['icon'])) { ?><img class="ns-settings-icon" src="<?php echo $args['icon']; ?>" alt="" /><?php } ?>
	                <?php if(!empty($args['pages'])) { ?>
	                <div class="ns-settings-nav">
	                    <ul>
	                        <?php $current_page = $_GET['page']; ?>
	                        <?php foreach($args['pages'] as $page) { ?>
	                        <li <?php if($page['slug'] == $current_page) { echo 'class="active"'; } ?>><a href="<?php echo admin_url('admin.php?page='.$page['slug']); ?>"><?php echo $page['name']; ?></a></li>
	                        <?php } ?>
	                    </ul>
	                </div>
	                <?php } ?>
	                <?php if($args['display_actions'] != 'false') { ?>
	                    <div class="ns-settings-actions">
	                        <div class="loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /></div> 
	                        <?php submit_button(esc_html__('Save Changes', 'ns-basics'), 'admin-button', 'submit', false); ?>
	                    </div>
	                <?php } ?>
	                <div class="clear"></div>
	            </div>

	            <div class="ns-settings-content <?php if(!empty($args['content_class'])) { echo $args['content_class']; } ?>">

	                <?php echo $this->admin_alert('success', esc_html__('Settings Saved Successfully', 'ns-basics'), null, null, true, 'settings-saved'); ?>

	                <?php if(!empty($args['alerts'])) {
	                    foreach($args['alerts'] as $alert) { echo $alert; }
	                } ?>

	                <div class="ns-tabs">
	                    <?php if(!empty($args['content_nav'])) { ?>
	                    <div class="ns-settings-content-nav">
	                        <div class="ns-settings-content-nav-filler"></div>
	                        <ul class="ns-tabs-nav">
	                            <?php foreach($args['content_nav'] as $nav_item) { ?>
	                                <li><a href="<?php echo $nav_item['link']; ?>"><?php if(!empty($nav_item['icon'])) { echo '<i class="fa '.$nav_item['icon'].'"></i>'; } ?><?php echo $nav_item['name']; ?></a></li>
	                            <?php } ?>
	                        </ul>
	                    </div>
	                    <?php } ?>

	                    <div class="ns-tabs-content content-wrap <?php if(!empty($args['content_nav'])) { echo 'content-has-nav'; } ?>">
	                        <?php if(!empty($args['content_nav'])) { ?><div class="tab-loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /> <?php esc_html_e('Loading...', 'ns-basics'); ?></div><?php } ?>
	                        <?php if(!empty($args['content'])) { echo $args['content']; } ?>
	                    </div>
	                </div>

	                <div class="clear"></div>
	                <?php echo $this->admin_alert('success', esc_html__('Settings Saved Successfully', 'ns-basics'), null, null, true, 'settings-saved'); ?>
	            </div>

	            <div class="ns-settings-menu-bar ns-settings-footer">
	                <div class="ns-settings-version left"><?php esc_html_e('Version', 'ns-basics'); ?> <?php echo NS_BASICS_VERSION; ?> | <?php esc_html_e('Made by', 'ns-basics'); ?> <a href="<?php echo constant('NS_SHOP_URL'); ?>" target="_blank">Nightshift Studio</a> | <a href="<?php echo constant('NS_SHOP_URL').'support-package/'; ?>" target="_blank"><?php esc_html_e('Get Support', 'ns-basics'); ?></a></div>
	                <?php if($args['display_actions'] != 'false') { ?>
	                    <div class="ns-settings-actions">
	                        <div class="loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /></div> 
	                        <?php submit_button(esc_html__('Save Changes', 'ns-basics'), 'admin-button', 'submit', false); ?>      
	                    </div>
	                <?php } ?>
	                <div class="clear"></div>
	            </div>
			</form>
		</div>
		<?php
	}

	/**
	 *	Build admin field
	 *
	 *  Generates an admin field. Used across all plugins that require NS Basics
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field($field = null) { 

		if($field == null) {
			$field = array (
				'title' => 'New Field',
				'name' => null,
				'value' => '',
				'placeholder' => null,
				'description' => null,
				'class' => null,
				'group' => null,
				'type' => 'text',
				'options' => null,
			);
		} 

		//generate field class
		$field_class = '';
		if(!empty($field['class'])) { $field_class .= $field['class'].' '; }
		if(!empty($field['parent_name'])) { 
			$field_class .= 'child-field ';
			$field_class .= 'child-field-'.$field['parent_name'].' ';
		}
		?>

		<table class="admin-module <?php echo $field_class; ?>">
            <tr>

                <td class="admin-module-label">
                    <label><?php echo $field['title']; ?></label>
                    <?php if(!empty($field['description'])) { ?><span class="admin-module-note"><?php echo $field['description']; ?></span><?php } ?>
                </td>

                <td class="admin-module-field">

                	<?php if($field['type'] == 'text') { 
                		
                		// TEXT ?>
                		<input type="text" name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />
                	
                	<?php } else if($field['type'] == 'select') { 
                		
                		// SELECT ?>
                		<select name="<?php echo $field['name']; ?>">
                			<?php if(!empty($field['options'])) {
                				foreach($field['options'] as $key=>$value) { ?>
                					<option value="<?php echo $value; ?>" <?php if($field['value'] == $value) { echo 'selected'; } ?>><?php echo $key; ?></option>
                				<?php }
                			} ?>
                		</select>
                	
                	<?php } else if($field['type'] == 'checkbox') { 
                		
                		// CHECKBOX ?>
                		<input type="checkbox" name="<?php echo $field['name']; ?>" value="true" <?php if($field['value'] == 'true') { echo 'checked'; } ?>  />
                	
                	<?php } else if($field['type'] == 'radio_image') { 
                		
                		// RADIO IMAGE ?>
                		<?php if(!empty($field['options'])) { ?>
	                		<?php foreach($field['options'] as $option_name=>$option) { ?>
	                			<label class="selectable-item <?php if($field['value'] == $option['value']) { echo 'active'; } ?>">
	                				<?php if(!empty($option['icon'])) { ?><div><img src="<?php echo $option['icon']; ?>" alt="" /></div><?php } ?>
	                				<input type="radio" id="" name="<?php echo $field['name']; ?>" value="<?php echo $option['value']; ?>" <?php checked($option['value'], $field['value'], true) ?> /><?php echo $option_name; ?><br/>
	                			</label>
	                		<?php } ?>
	                	<?php }
                	
                	} else if($field['type'] == 'textarea') {
                	
                		// TEXTAREA ?>
                		<textarea name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?>><?php echo esc_attr($field['value']); ?></textarea>
                	
                	<?php } else if($field['type'] == 'image_upload') { 

                		// IMAGE UPLOAD ?>
                		<input type="text" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" />
                        <input class="ns_upload_image_button" type="button" value="<?php esc_html_e('Upload Image', 'ns-basics'); ?>" />
                        <span class="button-secondary remove"><?php echo esc_html_e('Remove', 'ns-core'); ?></span>

                	<?php } else if($field['type'] == 'switch') {

                		// SWITCH ?>
                		<div class="toggle-switch" title="<?php if($field['value'] == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                            <input type="checkbox" name="<?php echo $field['name']; ?>" value="true" class="toggle-switch-checkbox" id="<?php echo $field['name']; ?>" <?php checked('true', $field['value'], true) ?>>
                            <label class="toggle-switch-label" data-settings="<?php echo $field['name']; ?>" for="<?php echo $field['name']; ?>"><?php if($field['value'] == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                        </div>
                		
                	<?php } else if($field['type'] == 'number') {

                		// NUMBER 
                		if(isset($field['step'])) { $num_step = 'step="'.$field['step'].'"'; } else { $num_step = ''; }
                		if(isset($field['min'])) { $num_min = 'min="'.$field['min'].'"'; } else { $num_min = ''; }
                		if(isset($field['max'])) { $num_max = 'max="'.$field['max'].'"'; } else { $num_max = ''; }
                		?>
                		<input type="number" <?php echo $num_min; echo $num_max; echo $num_step; ?> name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />

                	<?php } else if($field['type'] == 'color') {

                		// COLOR ?>
                		<input type="text" class="color-field" data-default-color="<?php echo esc_attr($field['value']); ?>" name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />

                	<?php } ?>
                </td>
            </tr>
        </table>

	<?php }

	/**
	 *	Settings page
	 */
	public function settings_page() {

		$modules = new NS_Basics_Modules();

		$args = array(
			'page_name' => 'Nightshift Basics',
			'settings_group' => 'ns-basics-settings-group',
			'pages' => array(
				array('slug' => 'ns-basics-settings', 'name' => 'Settings'),
				array('slug' => 'ns-basics-resources', 'name' => 'Resources')
			),
			'display_actions' => 'true',
			'content' => $modules->output_modules('basic'),
			'content_class' => 'ns-modules',
			'icon' => plugins_url('/ns-basics/images/icon-settings.svg'),
			'ajax' => true,
		);

		if(!current_theme_supports('ns-basics')) {
	        $current_theme = wp_get_theme();
	        $incompatible_theme_alert = $this->admin_alert('info', esc_html__('The active theme ('.$current_theme->name.') does not support NightShift Basics.', 'ns-basics'), $action = NS_SHOP_URL, $action_text = esc_html__('Get a compatible theme', 'ns-basics'), true); 
	        $args['alerts'] = array($incompatible_theme_alert); 
	    }

		$settings_page = $this->build_admin_page($args);
		return $settings_page;
	}

	/**
	 *	Resources page
	 */
	public function resources_page() {

		$args = array(
			'page_name' => 'Nightshift Basics',
			'pages' => array(
				array('slug' => 'ns-basics-settings', 'name' => 'Settings'),
				array('slug' => 'ns-basics-resources', 'name' => 'Resources')
			),
			'display_actions' => 'false',
			'content' => $this->resources_page_content(),
			'icon' => plugins_url('/ns-basics/images/icon-settings.svg'),
		);

		$resources_page = $this->build_admin_page($args);
		return $resources_page;
	}

	private function resources_page_content() {
		ob_start(); ?>
    
	    <p><?php esc_html_e('Nightshift Basics provides the framework essential for all themes and plugins built by Nightshift Creative.', 'ns-basics'); ?></p>
	    <p><?php esc_html_e('For questions and/or support, you can email us directly at support@nightshiftcreative.co.', 'ns-basics'); ?></p>
	    <a href="<?php echo constant('NS_SHOP_URL').'support'; ?>" target="_blank" class="resource-item"><i class="fa fa-envelope icon"></i><?php esc_html_e('Contact Us', 'ns-basics'); ?></a>
	    <a href="<?php echo constant('NS_SHOP_URL').'docs/ns-basics/'; ?>" target="_blank" class="resource-item"><i class="fa fa-book icon"></i><?php esc_html_e('View Documentation', 'ns-basics'); ?></a>
	    <a href="<?php echo constant('NS_SHOP_URL').'themes/'; ?>" target="_blank" class="resource-item"><i class="fa fa-tint icon"></i><?php esc_html_e('Our Themes', 'ns-basics'); ?></a>
	    <a href="<?php echo constant('NS_SHOP_URL').'plugins/'; ?>" target="_blank" class="resource-item"><i class="fa fa-plug icon"></i><?php esc_html_e('Our Plugins', 'ns-basics'); ?></a>
	    <a href="#" target="_blank" class="resource-item"><i class="fa fa-share-alt icon"></i><?php esc_html_e('Follow Us', 'ns-basics'); ?></a>
	    <a href="#" target="_blank" class="resource-item"><i class="fa fa-pencil-alt icon"></i><?php esc_html_e('Our Blog', 'ns-basics'); ?></a>
	    <div class="clear"></div>

	    <?php $output = ob_get_clean();
	    return $output;
	}

	/**
	 *	Admin Alert
	 *
	 *  Outputs an admin alert box
	 *
	 *  @param string $type
	 *		
	 */
	public function admin_alert($type = 'info', $text = null, $action = null, $action_text = null, $dismissible = false, $class = null) {
		ob_start(); ?>

	    <div class="admin-alert-box <?php if(!empty($type)) { ?>admin-<?php echo $type; ?><?php } ?> <?php if(!empty($class)) { echo $class; } ?>">
	        <?php if($type == 'success') { 
	            echo '<i class="fa fa-check"></i>';
	        } else {
	            echo '<i class="fa fa-exclamation-circle"></i>';
	        } ?>
	        <?php if(!empty($text)) { ?><strong><?php echo $text; ?></strong><?php } ?>
	        <?php if(!empty($action)) { ?><a href="<?php echo esc_url($action); ?>" target="_blank"><?php echo $action_text; ?></a><?php } ?>
	        <?php if($dismissible == true) { ?><i class="fa fa-close right admin-alert-close"></i><?php } ?>
	    </div> 

	    <?php $output = ob_get_clean();
	    return $output;
	}

	/**
	 *	Save meta box
	 */
	public function save_meta_box($post_id, $settings, $allowed) {
		foreach($settings as $key=>$field) {
        	if($field['type'] == 'checkbox' || $field['type'] == 'switch') {
	        	if(isset($_POST[$field['name']])) {
			        update_post_meta( $post_id, $field['name'], wp_kses( $_POST[$field['name']], $allowed ) );
			    } else {
			    	update_post_meta( $post_id, $field['name'], wp_kses( '', $allowed ) );
			    }
	        } else {
	        	if(isset($field['name'])) {
		        	update_post_meta( $post_id, $field['name'], wp_kses( $_POST[$field['name']], $allowed ) );
		        }
	        }
        }
    }

}

?>