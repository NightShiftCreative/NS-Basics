<?php

/*-----------------------------------------------------------------------------------*/
/*  Add Meta Tags to Head
/*-----------------------------------------------------------------------------------*/
function ns_basics_add_meta_tags() { 
    $output = '';
    if(is_single()) {
        global $post;
        setup_postdata( $post );
        $excerpt = wp_trim_words(get_the_excerpt(), 20);
        $output .= '<meta name="description" content="'.get_the_title().' - '.$excerpt.'">';
    } else {
        $output .= '<meta name="description" content="'.get_bloginfo('name').' - '.get_bloginfo('description').'">';
    } 
    echo $output;
}
add_action('wp_head', 'ns_basics_add_meta_tags');

/*-----------------------------------------------------------------------------------*/
/*  Login Form Failed
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_login_failed', 'ns_basics_login_fail' );  // hook failed login
function ns_basics_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( add_query_arg('login', 'failed', $referrer) );
      exit;
   }
}

/*-----------------------------------------------------------------------------------*/
/*  Tooltips
/*-----------------------------------------------------------------------------------*/
function ns_basics_tooltip($toggle, $content, $class = null) {
    $output = '';
    $output .= '<div class="ns-tooltip '.$class.'">';
    $output .= '<div class="ns-tooltip-toggle">'.$toggle.'</div>';
    $output .= '<div class="ns-tooltip-content"><div class="ns-tooltip-content-inner">'.$content.'</div></div>';
    $output .= '</div>';
    return $output;
}


/*-----------------------------------------------------------------------------------*/
/*  Generate Icon
/*-----------------------------------------------------------------------------------*/
if( !function_exists('rypecore_get_icon') ){
    function rypecore_get_icon($type, $fa_name, $line_name = null, $dripicon_name = null, $class = null) {
        if($type == 'line' && $line_name != 'n/a') {
            if(empty($line_name)) { $line_name = $fa_name; }
            return '<i class="fa icon-'.$line_name.' icon icon-line '.$class.'"></i>';
        } else if($type == 'dripicon' && $dripicon_name != 'n/a') {
            if(empty($dripicon_name)) { $dripicon_name = $fa_name; }
            return '<i class="fa dripicons-'.$dripicon_name.' icon icon-dripicon'.$class.'"></i>';
        } else {
            return '<i class="fa fa-'.$fa_name.' icon '.$class.'"></i>';
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Image Upload (used for front end avatar upload)
/*-----------------------------------------------------------------------------------*/
function rype_basics_upload_user_file( $file = array() ) {
        
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
                            
    $file_return = wp_handle_upload( $file, array('test_form' => false ) );
                            
    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        return false;
    } else {
                                
        $filename = $file_return['file'];
                                
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );

        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
                                
        require_once (ABSPATH . 'wp-admin/includes/image.php' );
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );
                                    
        if( 0 < intval( $attachment_id ) ) {
            return $attachment_id;
        }
                                
    }
                            
    return false;
}

/*-----------------------------------------------------------------------------------*/
/*  Generate admin gallery upload
/*-----------------------------------------------------------------------------------*/
function rype_basics_generate_gallery($additional_images) { ?>
    <div class="admin-module no-border gallery-container">
        <?php
        if(!empty($additional_images) && !empty($additional_images[0])) { ?>

            <?php
            $additional_images = explode(",", $additional_images[0]);
            $additional_images = array_filter($additional_images);

            function rype_basics_get_image_id($image_url) {
                global $wpdb;
                $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
                return $attachment[0]; 
            }

            foreach ($additional_images as $additional_image) {
                if(!empty($additional_image)) {
                    $image_id = rype_basics_get_image_id($additional_image);

                    if(!empty($image_id)) {
                        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
                        $image_thumb_html = '<img src="'. $image_thumb[0] .'" alt="" />'; 
                    } else {
                        $image_thumb_html = '<img width="150" src="'.$additional_image.'" alt="" />';
                    }

                    echo '
                        <div class="gallery-img-preview">
                            '.$image_thumb_html.'
                            <input type="hidden" name="rypecore_additional_img[]" value="'. $additional_image .'" />
                            <span class="action delete-additional-img" title="'. esc_html__('Delete', 'rype-basics'). '"><i class="fa fa-trash"></i></span>
                            <a href="'.get_admin_url().'upload.php?item='.$image_id.'" class="action edit-additional-img" target="_blank" title="'.esc_html__('Edit', 'rype-basics').'"><i class="fa fa-pencil"></i></a>
                        </div>
                    ';
                }
            }
        } else { echo '<p class="admin-module-note no-gallery-img">'.esc_html__('No gallery images were found.', 'rype-basics').'</p>'; } ?>

        <div class="clear"></div>
        <span class="admin-button add-gallery-media"><i class="fa fa-plus"></i> <?php echo esc_html_e('Add Images', 'rype-basics'); ?></span>
    </div>
<?php }

/*-----------------------------------------------------------------------------------*/
/*  Check if key/value is in array
/*-----------------------------------------------------------------------------------*/
function rype_basics_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = rype_basics_in_array($v, $key, $key_value);
            if( $within_array == true ){
                break;
            }
        } else {
            if( $v == $key_value && $k == $key ){
                $within_array = true;
                break;
            }
        }
    }
    return $within_array;
}

/*-----------------------------------------------------------------------------------*/
/*  Admin Alerts
/*-----------------------------------------------------------------------------------*/
function rype_basics_admin_alert($type = 'info', $text = null, $action = null, $action_text = null, $dismissible = false, $class = null) {
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

/*-----------------------------------------------------------------------------------*/
/*  Main Contact Form
/*-----------------------------------------------------------------------------------*/
function rype_basics_main_contact_form() {

    $default_email = get_option('admin_email');
    $contact_form_email = esc_attr(get_option('rypecore_email', $default_email));
    $contact_form_success = esc_attr(get_option(' rypecore_contact_form_success', esc_html__('Thanks! Your email has been delivered!', 'rypecore')));
    
    $nameError = '';
    $emailError= '';
    $commentError = '';
    $emailSent = null;

    //If the form is submitted
    if(isset($_POST['submitted'])) {
      
      // require a name from user
      if(trim($_POST['contact-name']) === '') {
        $nameError =  esc_html__('Forgot your name!', 'rype-basics'); 
        $hasError = true;
      } else {
        $contact_name = trim($_POST['contact-name']);
      }
      
      // need valid email
      if(trim($_POST['contact-email']) === '')  {
        $emailError = esc_html__('Forgot to enter in your e-mail address.', 'rype-basics');
        $hasError = true;
      } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['contact-email']))) {
        $emailError = esc_html__('You entered an invalid email address.', 'rype-basics');
        $hasError = true;
      } else {
        $contact_email = trim($_POST['contact-email']);
      }

      // get phone
      if(trim($_POST['contact-phone']) === '') {
        // do nothing
      } else {
        $contact_phone = trim($_POST['contact-phone']);
      }

      // get subject
      if(trim($_POST['contact-subject']) === '') {
        // do nothing
      } else {
        $contact_subject = trim($_POST['contact-subject']);
      }
        
      // we need at least some content
      if(trim($_POST['contact-message']) === '') {
        $commentError = esc_html__('You forgot to enter a message!', 'rype-basics');
        $hasError = true;
      } else {
        if(function_exists('stripslashes')) {
          $contact_message = stripslashes(trim($_POST['contact-message']));
        } else {
          $contact_message = trim($_POST['contact-message']);
        }
      }
        
      // upon no failure errors let's email now!
      if(!isset($hasError)) {

        /*---------------------------------------------------------*/
        /* SET EMAIL ADDRESS HERE                                  */
        /*---------------------------------------------------------*/
        $emailTo = $contact_form_email;
        $subject = 'Submitted message from '.$contact_name;
        $sendCopy = trim($_POST['sendCopy']);
        $body = "Subject:$contact_subject \n\nName: $contact_name \n\nEmail: $contact_email \n\nPhone: $contact_phone \n\nMessage: $contact_message";
        $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $contact_email;

        mail($emailTo, $subject, $body, $headers);
            
        // set our boolean completion value to TRUE
        $emailSent = true;
      }
    }

    ?>

    <form method="post" class="contact-form">

        <div class="alert-box success <?php if($emailSent) { echo 'show'; } else { echo 'hide'; } ?>"><?php echo $contact_form_success; ?></div>

        <div class="contact-form-fields">
            <div class="form-block">
                <?php if($nameError != '') { echo '<div class="alert-box error">'.$nameError.'</div>'; } ?>
                <label><?php esc_html_e( 'Name', 'rype-basics' ); ?>*</label>
                <input type="text" name="contact-name" placeholder="<?php esc_html_e( 'Your Name', 'rype-basics' ); ?>" class="requiredField" value="<?php if(isset($contact_name)) { echo $contact_name; } ?>" />
            </div>

            <div class="form-block">
                <?php if($emailError != '') { echo '<div class="alert-box error">'.$emailError.'</div>'; } ?>
                <label><?php esc_html_e( 'Email', 'rype-basics' ); ?>*</label>
                <input type="email" name="contact-email" placeholder="<?php esc_html_e( 'Your Email', 'rype-basics' ); ?>" class="requiredField email" value="<?php if(isset($contact_email)) { echo $contact_email; } ?>" />
            </div>

            <div class="form-block">
                <label><?php esc_html_e( 'Phone', 'rype-basics' ); ?></label>
                <input type="text" name="contact-phone" placeholder="<?php esc_html_e( 'Your Phone', 'rype-basics' ); ?>" value="<?php if(isset($_POST['contact-phone'])) { echo $_POST['contact-phone']; } ?>" />
            </div>

            <div class="form-block">
                <label><?php esc_html_e( 'Subject', 'rype-basics' ); ?></label>
                <input type="text" name="contact-subject" placeholder="<?php esc_html_e( 'Subject', 'rype-basics' ); ?>" value="<?php if(isset($_POST['contact-subject'])) { echo $_POST['contact-subject']; } ?>" />
            </div>

            <div class="form-block">
                <?php if($commentError != '') { echo '<div class="alert-box error">'.$commentError.'</div>'; } ?>
                <label><?php esc_html_e( 'Message', 'rype-basics' ); ?>*</label>
                <textarea name="contact-message" placeholder="<?php esc_html_e( 'Your Message', 'rype-basics' ); ?>" class="requiredField"><?php if(isset($contact_message)) { echo $contact_message; } ?></textarea>
            </div>

            <div class="form-block">
                <input type="hidden" name="submitted" id="submitted" value="true" />
                <input type="submit" value="<?php esc_html_e( 'Submit', 'rype-basics' ); ?>" />
                <div class="form-loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /> <?php esc_html_e( 'Loading...', 'rype-basics' ); ?></div>
            </div>
        </div>

    </form>

<?php }

?>