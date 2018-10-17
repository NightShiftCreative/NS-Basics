<?php 
//Get global settings
global $current_user, $wp_roles; 
$members_login_page = esc_attr(get_option('ns_core_members_login_page'));

//Get template args
if(isset($template_args)) {
    //set template args here
} 
?>    

<!-- start user dashboard -->
<div class="user-dashboard">
	<?php if(is_user_logged_in()) { 

		$error = array();

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

	        /* Upload avatar */
	        if( !empty( $_FILES ) ) {
	            foreach( $_FILES as $file ) {
	                if($_FILES['avatar']['tmp_name']) {
	                    $attachment_id_avatar_img = ns_basics_upload_user_file( $_FILES['avatar'] );
	                    update_user_meta( $current_user->ID, 'avatar', $attachment_id_avatar_img );
	                }
	            }
	        }

	        if(!$_FILES['avatar']['tmp_name'] && !empty( $_POST['avatar_remove'] ) && $_POST['avatar_remove'] == 'true') {
	            //remove avatar
	            delete_user_meta($current_user->ID, 'avatar');
	        }

	        /* Update user password. */
	        if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
	            if ( $_POST['pass1'] == $_POST['pass2'] )
	                wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
	            else
	                $error[] = esc_html__('The passwords you entered do not match.  Your password was not updated.', 'ns-basics');
	        }

	        /* Update user information. */
	        if ( !empty( $_POST['url'] ) )
	            wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
	        if ( !empty( $_POST['email'] ) ){
	            if (!is_email(esc_attr( $_POST['email'] )))
	                $error[] = esc_html__('The Email you entered is not valid.  please try again.', 'ns-basics');
	            elseif(email_exists(esc_attr( $_POST['email'] )) && email_exists(esc_attr( $_POST['email'] )) != $current_user->ID)
	                $error[] = esc_html__('This email is already used by another user.  try a different one.', 'ns-basics');
	            else{
	                wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
	            }
	        }

	        if ( !empty( $_POST['first-name'] ) )
	            update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
	        if ( !empty( $_POST['last-name'] ) )
	            update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
	        if ( !empty( $_POST['description'] ) )
	            update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

	        /* Redirect so the page will show updated info.*/
	        if ( count($error) == 0 ) {
	            //action hook for plugins and extra fields saving
	            do_action('edit_user_profile_update', $current_user->ID);
	            //wp_redirect( get_permalink().'?updated=true' );
	            //exit;
	        }
	    } ?>

	    <!-- start user profile form -->
        <div class="user-profile-form">

            <?php
            if(!empty($error)) {
                foreach($error as $value) {
                    echo '<div class="alert-box error">'.$value.'</div>';
                }
            } else if(isset($_GET['updated']) && $_GET['updated'] == 'true') {
                echo '<div class="alert-box success">'. esc_html__('Your profile was updated!', 'ns-basics') .'</div>';
            }
            ?>
            <form method="post" id="adduser" action="<?php the_permalink(); ?>" enctype="multipart/form-data">

                <div class="module-header module-header-left">
                    <h4><strong><?php esc_html_e('General Info', 'ns-basics'); ?></strong></h4>
                </div>

                <div class="row">

                    <div class="col-lg-5 col-md-5">
                        <div class="avatar-upload">
                            <label><?php esc_html_e('Change Avatar', 'ns-basics'); ?></label>
                            <div class="avatar-img">
                                <?php 
                                    $avatar_id = get_user_meta( $current_user->ID, 'avatar', true ); 
                                    if(!empty($avatar_id)) {
                                        echo wp_get_attachment_image($avatar_id, array('96', '96'));
                                    } else {
                                        echo '<img src="'.plugins_url('/ns-basics/images/avatar-default.png').'" />';
                                    }
                                ?>
                            </div>
                            <div class="avatar-img-controls">
                                <input name="avatar" type="file" />
                                <span class="button small avatar-remove"><?php esc_html_e('Remove', 'ns-basics'); ?></span>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-7 col-md-7">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p class="form-username">
                                    <label for="first-name"><?php esc_html_e('First Name', 'ns-basics'); ?></label>
                                    <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <p class="form-username">
                                    <label for="last-name"><?php esc_html_e('Last Name', 'ns-basics'); ?></label>
                                    <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                                </p>
                            </div>
                        </div>
                        
                        <p class="form-email">
                            <label for="email"><?php esc_html_e('E-mail *', 'ns-basics'); ?></label>
                            <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                        </p><!-- .form-email -->

                        <p class="form-url">
                            <label for="url"><?php esc_html_e('Website', 'ns-basics'); ?></label>
                            <input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
                        </p><!-- .form-url -->
                    </div>

                </div><!-- end row -->

                <p class="form-textarea">
                    <label for="description"><?php esc_html_e('Biographical Information', 'ns-basics') ?></label>
                    <textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                </p><!-- .form-textarea -->
                
                <div class="update-password">
                    <div class="module-header module-header-left">
                        <h4><strong><?php esc_html_e('Change Password', 'ns-basics'); ?></strong></h4>
                    </div>
                    <p class="form-password">
                        <label for="pass1"><?php esc_html_e('Password *', 'ns-basics'); ?> </label>
                        <input class="text-input" name="pass1" type="password" id="pass1" />
                    </p><!-- .form-password -->
                    <p class="form-password">
                        <label for="pass2"><?php esc_html_e('Repeat Password *', 'ns-basics'); ?></label>
                        <input class="text-input" name="pass2" type="password" id="pass2" />
                    </p><!-- .form-password -->
                </div>

                <?php 
                    //action hook for plugin and extra fields
                    do_action('edit_user_profile',$current_user); 
                ?>

                <p class="form-submit">
                    <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php esc_html_e('Update Profile', 'ns-basics'); ?>" />
                    <?php wp_nonce_field( 'update-user' ) ?>
                    <input name="action" type="hidden" id="action" value="update-user" />
                </p><!-- .form-submit -->
            </form>
        </div><!-- end user profile form -->

    	<?php
		// hook in for NS Basics
        do_action( 'ns_basics_after_edit_profile'); 

	} else {
		ns_basics_template_loader('alert_not_logged_in.php');
    } ?>
</div><!-- end user dashboard -->