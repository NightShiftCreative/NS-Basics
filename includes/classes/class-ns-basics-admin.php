<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Admin class
 *
 *  Outputs admin pages and provides the core methods for building admin interfaces.
 */
class NS_Basics_Admin {

	/************************************************************************/
	// Initialize
	/************************************************************************/

	/**
	 *	Init
	 */
	public function init() {
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

	/************************************************************************/
	// Interface Methods
	/************************************************************************/

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
	                <div class="ns-settings-version left"><?php esc_html_e('Version', 'ns-basics'); ?> <?php echo NS_BASICS_VERSION; ?> | <?php esc_html_e('Made by', 'ns-basics'); ?> <a href="<?php echo constant('NS_SHOP_URL'); ?>" target="_blank">Nightshift Creative</a> | <a href="<?php echo constant('NS_SHOP_URL').'support-package/'; ?>" target="_blank"><?php esc_html_e('Get Support', 'ns-basics'); ?></a></div>
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

		// initialize field args
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

		//set and filter field types
		$field_types = array(
			'text' => array($this, 'build_admin_field_text'),
			'select' => array($this, 'build_admin_field_select'), 
			'checkbox' => array($this, 'build_admin_field_checkbox'),
			'checkbox_group' => array($this, 'build_admin_field_checkbox_group'),
			'switch' => array($this, 'build_admin_field_switch'),
			'image_upload' => array($this, 'build_admin_field_image_upload'),
			'radio_image' => array($this, 'build_admin_field_radio_image'),
			'textarea' => array($this, 'build_admin_field_textarea'),
			'number' => array($this, 'build_admin_field_number'),
			'color' => array($this, 'build_admin_field_color'),
			'sortable' => array($this, 'build_admin_field_sortable'),
			'editor' => array($this, 'build_admin_field_editor'),
			'gallery' => array($this, 'build_admin_field_gallery'),
		);
		$field_types = apply_filters( 'ns_basics_admin_field_types', $field_types);

		//generate field class
		$field_class = '';
		$field_class .= 'admin-module-'.$field['name'].' ';
		if(!empty($field['class'])) { $field_class .= $field['class'].' '; }
		if(!empty($field['children'])) { $field_class .= 'has-children '; }
		?>

		<table class="admin-module <?php echo $field_class; ?>" <?php if(!empty($field['id'])) { echo 'id="'.$field['id'].'"'; } ?> data-type="<?php echo $field['type']; ?>">
            <tr>

                <td class="admin-module-label">
                    <label><?php echo $field['title']; ?></label>
                    <?php if(!empty($field['description'])) { ?><span class="admin-module-note"><?php echo $field['description']; ?></span><?php } ?>
                </td>

                <td class="admin-module-field">

                	<?php 
                	do_action('ns_basics_admin_before_field', $field);

                	//loop through field types and call the correct method
                	foreach($field_types as $key=>$field_method) {
                		if($key == $field['type']) {
                			call_user_func($field_method, $field);
                		}
                	}

                	do_action('ns_basics_admin_after_field', $field);

                	if(!empty($field['postfix'])) { echo $field['postfix']; } ?>

                </td>
            </tr>

            <?php
            // build radio image child fields
            if($field['type'] == 'radio_image' || $field['type'] == 'select') {
	            if(!empty($field['options'])) {
		            foreach($field['options'] as $option_name=>$option) { 
		            	if($field['type'] == 'radio_image') { $option = $option['value']; }
		            	if(!empty($field['children'])) { ?>
		                	<tr id="selectable-item-options-<?php echo $option; ?>" class="selectable-item-settings <?php if($field['value'] == $option) { echo 'show-table'; } else { echo 'hide-soft'; } ?>">
		                	<?php echo '<td colspan="2">';
		                	foreach($field['children'] as $child_field) {
		                		if($child_field['parent_val'] == $option) {
		                			$this->build_admin_field($child_field); 
			                	}
		                	}
		                	echo '</td></tr>';
		            	}
		            }
	            } 
	        }

	        // build switch child fields
	        if($field['type'] == 'switch') {
	        	if(!empty($field['children'])) { ?>
	        		<tr id="toggle-switch-settings-<?php echo $field['name']; ?>" class="toggle-switch-settings <?php if($field['value'] == 'true') { echo 'show-table'; } else { echo 'hide-soft'; } ?>">
	        		<td colspan="2">
	        		<?php foreach($field['children'] as $child_field) { $this->build_admin_field($child_field); }
		            echo '</td></tr>';
	        	}
	        } ?>

        </table>

	<?php }

	/**
	 *	Build admin text field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_text($field = null) { ?>
		<input type="text" name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />
	<?php }

	/**
	 *	Build admin select field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_select($field = null) { ?>
		<select name="<?php echo $field['name']; ?>">
        	<?php if(!empty($field['options'])) {
        		foreach($field['options'] as $key=>$value) { ?>
        			<option value="<?php echo $value; ?>" <?php if($field['value'] == $value) { echo 'selected'; } ?>><?php echo $key; ?></option>
        		<?php }
        	} ?>
        </select>
	<?php }

	/**
	 *	Build admin checkbox field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_checkbox($field = null) { ?>
		<input type="checkbox" name="<?php echo $field['name']; ?>" value="true" <?php if($field['value'] == 'true') { echo 'checked'; } ?>  />	
	<?php }

	/**
	 *	Build admin checkbox group field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_checkbox_group($field = null) { ?>
		<?php if(!empty($field['options'])) { 
            echo '<ul class="three-col-list">';
                foreach($field['options'] as $key=>$option) { ?>
                	<li>
                		<input type="checkbox" <?php if(!empty($option['attributes'])) { foreach($option['attributes'] as $attr) { echo $attr.' '; } }?> name="<?php echo $field['name'].'['.$key.'][value]'; ?>" value="<?php echo $key; ?>" <?php if(isset($field['value'][$key]['value'])) { echo 'checked'; } ?> /><?php echo $option['value']; ?>
                		<input type="hidden" name="<?php echo $field['name'].'['.$key.'][attributes]'; ?>" value="<?php echo $option['attributes']; ?>" />
                	</li>
                <?php }
            echo '</ul>';
        } ?>
	<?php }

	/**
	 *	Build admin switch field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_switch($field = null) { ?>
		<div class="toggle-switch <?php if($field['value'] == 'true') { echo 'active'; } ?>" title="<?php if($field['value'] == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
            <input type="checkbox" name="<?php echo $field['name']; ?>" value="true" class="toggle-switch-checkbox" id="<?php echo $field['name']; ?>" <?php checked('true', $field['value'], true) ?>>
            <label class="toggle-switch-label" <?php if(!empty($field['children'])) { echo 'data-settings="'.$field['name'].'"'; } ?> for="<?php echo $field['name']; ?>"><?php if($field['value'] == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
        </div>
	<?php }

	/**
	 *	Build admin image upload field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_image_upload($field = null) { ?>
		<input type="text" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" />
        <input class="ns_upload_image_button" type="button" value="<?php esc_html_e('Upload Image', 'ns-basics'); ?>" />
        <span class="button-secondary remove"><?php echo esc_html_e('Remove', 'ns-core'); ?></span>
        <?php if(!empty($field['display_img']) && !empty($field['value'])) { ?><div class="option-preview logo-preview"><img src="<?php echo $field['value']; ?>" alt="" /></div><?php } ?>
	<?php }

	/**
	 *	Build admin radio field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_radio_image($field = null) { ?>
		<?php if(!empty($field['options'])) { ?>
	        <?php foreach($field['options'] as $option_name=>$option) { ?>
	            <label class="selectable-item <?php if($field['value'] == $option['value']) { echo 'active'; } ?>">
	            	<?php if(!empty($option['icon'])) { ?><div><img src="<?php echo $option['icon']; ?>" alt="" /></div><?php } ?>
	            	<input type="radio" name="<?php echo $field['name']; ?>" value="<?php echo $option['value']; ?>" <?php checked($option['value'], $field['value'], true) ?> /><?php echo $option_name; ?><br/>
	            </label>
	        <?php } ?>
	    <?php }
	}

	/**
	 *	Build admin textarea field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_textarea($field = null) { ?>
		<textarea name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?>><?php echo esc_attr($field['value']); ?></textarea>
	<?php }

	/**
	 *	Build admin number field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_number($field = null) {
		if(isset($field['step'])) { $num_step = 'step="'.$field['step'].'"'; } else { $num_step = ''; }
        if(isset($field['min'])) { $num_min = 'min="'.$field['min'].'"'; } else { $num_min = ''; }
        if(isset($field['max'])) { $num_max = 'max="'.$field['max'].'"'; } else { $num_max = ''; } ?>
        <input type="number" <?php echo $num_min; echo $num_max; echo $num_step; ?> name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />
	<?php }

	/**
	 *	Build admin color field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_color($field = null) {
		$default_color = $field['value'];
        if(!empty($field['default_color'])) { $default_color = $field['default_color']; } ?>
        <input type="text" class="color-field" data-default-color="<?php echo esc_attr($default_color); ?>" name="<?php echo $field['name']; ?>" <?php if(!empty($field['placeholder'])) { echo 'placeholder="'.$field['placeholder'].'"'; } ?> value="<?php echo esc_attr($field['value']); ?>" />
	<?php }

	/**
	 *	Build admin sortable field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_sortable($field = null) {
		$sortable_fields = $field['value'];
        $count = 0; ?>

        <ul class="sortable-list">
            <?php if(isset($sortable_fields) && !empty($sortable_fields)) { ?>
            <?php foreach($sortable_fields as $value) { 

            if(isset($value['name'])) { $name = $value['name']; } 
            if(isset($value['slug'])) { $slug = $value['slug']; } 
            if(isset($value['active']) && $value['active'] == 'true') { $active = 'true'; } else { $active = 'false'; }

            //If item is an add-on, check if it is active
            if(isset($value['add_on'])) { 
                if(ns_basics_is_plugin_active($value['add_on'])) { $add_on = 'true'; } else { $add_on = 'false'; }
            } else {
                $add_on = 'true'; 
            } ?>

            <?php if($add_on == 'true') { ?>
            <li class="sortable-item">

                <div class="sortable-item-header">
	                <div class="sort-arrows"><i class="fa fa-bars"></i></div>
	                <div class="toggle-switch" title="<?php if($active == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
	                    <input type="checkbox" name="<?php echo $field['name']; ?>[<?php echo $count; ?>][active]" value="true" class="toggle-switch-checkbox" id="<?php echo $field['name']; ?>_<?php echo esc_attr($slug); ?>" <?php checked('true', $active, true) ?>>
	                    <label class="toggle-switch-label" for="<?php echo $field['name']; ?>_<?php echo esc_attr($slug); ?>"><?php if($active == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
	                </div>
	                <span class="sortable-item-title"><?php echo esc_attr($name); ?></span><div class="clear"></div>
	                <input type="hidden" name="<?php echo $field['name']; ?>[<?php echo $count; ?>][name]" value="<?php echo $name; ?>" />
                    <input type="hidden" name="<?php echo $field['name']; ?>[<?php echo $count; ?>][slug]" value="<?php echo $slug; ?>" />
	            </div>

	            <a href="#advanced-options-content-<?php echo esc_attr($slug); ?>" class="sortable-item-action advanced-options-toggle right">
	            	<i class="fa fa-gear"></i> <?php echo esc_html_e('Additional Settings', 'ns-basics'); ?>
	            </a>

	            <div id="advanced-options-content-<?php echo esc_attr($slug); ?>" class="advanced-options-content hide-soft">
	                <?php 
	                //build label field
	                $this->build_admin_field(array('title' => 'Label', 'name' => $field['name'].'['.$count.'][label]', 'value' => $value['label'], 'type' => 'text',));

	                //build sidebar field
	                if($field['display_sidebar'] == true) {
	                	$this->build_admin_field(array('title' => 'Display in Sidebar?', 'name' => $field['name'].'['.$count.'][sidebar]', 'value' => $value['sidebar'], 'type' => 'checkbox',));
	                }  

	                //build child fields
	                if(!empty($field['children'])) {
	                    foreach($field['children'] as $child_field) {
	                    	if($child_field['parent_val'] == $slug) { $this->build_admin_field($child_field); }
	                    }
	                } ?>
	            </div>
            </li>
            <?php } ?>

            <?php $count++; } } ?>
        </ul>
	<?php }

	/**
	 *	Build admin editor field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_editor($field = null) {
		$editor_id = $field['name'];
        $settings = array('textarea_name' => $field['name'], 'editor_height' => 180);
        wp_editor( $field['value'], $editor_id, $settings);
	}

	/**
	 *	Build admin gallery field
	 *
	 *  @param array $field
	 *		
	 */
	public function build_admin_field_gallery($field = null) { ?>
		
		<div class="gallery-container">
			<?php $additional_images = $field['value'];
			if(!empty($additional_images) && !empty($additional_images[0])) {

	            $additional_images = unserialize($additional_images[0]); 
	            foreach ($additional_images as $additional_image) {
	            	if(!empty($additional_image)) {

	            		$image_id = ns_basics_get_image_id($additional_image);

	            		if(!empty($image_id)) {
	                        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
	                        if(!empty($image_thumb)) { 
	                            $image_thumb_html = '<img src="'. $image_thumb[0] .'" alt="" />'; 
	                        } else {
	                           $image_thumb_html = '<img src="'. plugins_url('images/default-post-image.gif', dirname(__FILE__)) .'" alt="" />';  
	                        }
	                    } else {
	                        $image_thumb_html = '<img width="150" src="'.$additional_image.'" alt="" />';
	                    } ?>

	                    <div class="gallery-img-preview">
	                    	<?php echo $image_thumb_html; ?>
	                    	<input type="hidden" name="<?php echo $field['name']; ?>[]" value="<?php echo $additional_image; ?>" />
	                    	<span class="action delete-additional-img" title="<?php esc_html_e('Delete', 'ns-basics'); ?>"><i class="fa fa-trash"></i></span>
	                    	<a href="<?php echo get_admin_url(); ?>upload.php?item=<?php echo $image_id; ?>" class="action edit-additional-img" target="_blank" title="<?php esc_html_e('Edit', 'ns-basics'); ?>"><i class="fa fa-pencil-alt"></i></a>
	                    </div>
	                    <?php 

	            	}
	            }

			} else { echo '<p class="admin-module-note no-gallery-img">'.esc_html__('No gallery media was found.', 'ns-basics').'</p>'; } ?>
				
			<div class="clear"></div>
		    <span class="admin-button add-gallery-media">
		        <span class="hide gallery-field-name"><?php echo $field['name']; ?></span>
		        <i class="fa fa-plus"></i> <?php echo esc_html_e('Add Media', 'ns-basics'); ?>
		    </span>
		</div>

	<?php }


	/************************************************************************/
	// Output Pages
	/************************************************************************/

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

	/************************************************************************/
	// Settings Methods
	/************************************************************************/

	/**
	 *	Get settings
	 *
	 * @param array $settings_init
	 * @param string $single_setting
	 * @param boolean $single_esc
	 *
	 */
	public function get_settings($settings_init, $single_setting = null, $single_esc = true) {
		
		// Return single setting
		if(isset($single_setting)) {

			if(array_key_exists($single_setting, $settings_init)) {
				$default = $settings_init[$single_setting]['value'];
				if($single_esc == false) {
					$single_setting_value = get_option($single_setting, $default);
				} else {
					$single_setting_value = esc_attr(get_option($single_setting, $default));
				}
				return $single_setting_value;
			} else {
				return false;
			}

		// Return all settings
		} else {
			$settings = array();
			foreach($settings_init as $key=>$field) { 
				if(isset($field['esc']) && $field['esc'] == false) {
					$settings[$key] = get_option($key, $field['value']); 
				} else {
					$settings[$key] = esc_attr(get_option($key, $field['value'])); 
				}
			}
			return $settings;
		}
	}


	/************************************************************************/
	// Meta-Box Methods
	/************************************************************************/

	/**
	 *	Get meta box values
	 */
	public function get_meta_box_values($post_id, $settings_init) {

		$settings = array();
		foreach($settings_init as $key=>$field) {
		    $values = get_post_custom($post_id);
		    $settings[$key] = $field;
		    
		    if($field['serialized'] == true) {
		    	$settings[$key]['value'] = isset($values[$field['name']] ) ? $values[$field['name']] : $field['value'];
		    	if(is_serialized($settings[$key]['value'][0])) { $settings[$key]['value'] = unserialize($settings[$key]['value'][0]); }
		    } else {
		    	$settings[$key]['value'] = isset( $values[$field['name']] ) ? esc_attr( $values[$field['name']][0] ) : $field['value'];
		    }
		    
		    //get child values
		    if(!empty($field['children'])) {
		    	foreach($field['children'] as $child_key=>$child_field) {
		    		$settings[$key]['children'][$child_key]['value'] = isset( $values[$child_field['name']] ) ? esc_attr( $values[$child_field['name']][0] ) : $child_field['value'];
		    		if(!empty($child_field['children'])) {
		    			foreach($child_field['children'] as $nested_child_key=>$nested_child_field) {
		    				$settings[$key]['children'][$child_key]['children'][$nested_child_key]['value'] = isset( $values[$nested_child_field['name']] ) ? esc_attr( $values[$nested_child_field['name']][0] ) : $nested_child_field['value'];
		    			}
		    		}
		    	}
		    }
		}
		return $settings;
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
	        } else if($field['serialized'] == true) {
			    if (isset($_POST[$field['name']])) {
			        update_post_meta( $post_id, $field['name'], $_POST[$field['name']] );
			    } else {
			        update_post_meta( $post_id, $field['name'], '');
			    }
	        } else {
	        	if(isset($_POST[$field['name']])) {
		        	update_post_meta( $post_id, $field['name'], wp_kses( $_POST[$field['name']], $allowed ) );
		        }
	        }

	        //save child fields
	        if(!empty($field['children'])) {
	        	foreach($field['children'] as $child_field) {
	        		update_post_meta( $post_id, $child_field['name'], wp_kses( $_POST[$child_field['name']], $allowed ) );
	        		if(!empty($child_field['children'])) {
	        			foreach($child_field['children'] as $nested_child_field) {
	        				update_post_meta( $post_id, $nested_child_field['name'], wp_kses( $_POST[$nested_child_field['name']], $allowed ) );
	        			}
	        		}
	        	}
	        }

	        //dynamic hook
	        $post_type = get_post_type($post_id);
	        do_action('ns_basics_save_meta_box_'.$post_type, $post_id);

        }
    }

    /************************************************************************/
	// Misc Methods
	/************************************************************************/

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

}

?>