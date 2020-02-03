<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Members class
 *
 *  Adds member methods
 */
class NS_Basics_Members {

	/**
	 *	Init
	 */
	public function init() {
		$this->register_dashboard_sidebar();
		add_action( 'show_user_profile', array($this, 'create_user_fields'));
        add_action( 'edit_user_profile', array($this, 'create_user_fields'));
        add_action( 'personal_options_update', array($this, 'save_user_fields'));
        add_action( 'edit_user_profile_update', array($this, 'save_user_fields'));
	}

	/**
	 *	Register dashboard sidebar
	 */
	public function register_dashboard_sidebar() {
		register_sidebar( array(
		    'name' => esc_html__( 'Dashboard Sidebar', 'ns-basics' ),
		    'id' => 'dashboard_sidebar',
		    'before_widget' => '<div class="widget widget-sidebar %2$s">',
		    'after_widget' => '</div>',
		    'before_title' => '<h4 class="widget-header">',
		    'after_title' => '</h4>',
		));
	}

	/**
     *  Create User Fields
     */
    public function create_user_fields($user) { ?>
        <h3><?php _e("Extra profile information", "ns-basics"); ?></h3>

        <table class="form-table admin-module admin-module-user-image">
        <tr>
            <th><label><?php esc_html_e('User Image', 'ns-basics'); ?></label></th>
            <td>
                <?php
                $avatar = get_the_author_meta('avatar', $user->ID);
                if(!empty($avatar)) { echo '<div class="option-preview">'.wp_get_attachment_image($avatar, array('96', '96')).'</div>'; }
                ?>
                <div>
                <input type="text" name="avatar" value="<?php echo $avatar; ?>" class="regular-text" />
                <input class="ns_upload_image_button attachment_id" type="button" value="<?php esc_html_e('Upload Image', 'ns-basics'); ?>" />
                <span class="button-secondary remove"><?php echo esc_html_e('Remove', 'ns-core'); ?></span><br/>
                <span class="description"><?php esc_html_e("Upload an image or enter the attachment ID.", 'ns-basics'); ?></span>
                </div>
            </td>
        </tr>
        </table>

        <?php do_action('ns_basics_after_user_fields', $user->ID); ?>

    <?php }

     /**
     *  Save User Fields
     */
    public function save_user_fields($user_id) {
        if(!current_user_can( 'edit_user', $user_id )) { return false; }
        if(isset($_POST['avatar'])) { update_user_meta( $user_id, 'avatar', $_POST['avatar'] ); }
    }

}

?>