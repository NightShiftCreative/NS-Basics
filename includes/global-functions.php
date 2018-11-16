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
if(!function_exists('ns_core_get_icon')) {
    function ns_core_get_icon($type, $fa_name, $line_name = null, $dripicon_name = null, $class = null) {
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
function ns_basics_upload_user_file( $file = array() ) {
        
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
function ns_basics_generate_gallery($additional_images) { ?>
    <div class="admin-module no-border gallery-container">
        <?php
        if(!empty($additional_images) && !empty($additional_images[0])) { ?>

            <?php
            $additional_images = explode(",", $additional_images[0]);
            $additional_images = array_filter($additional_images);

            function ns_basics_get_image_id($image_url) {
                global $wpdb;
                $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
                return $attachment[0]; 
            }

            foreach ($additional_images as $additional_image) {
                if(!empty($additional_image)) {
                    $image_id = ns_basics_get_image_id($additional_image);

                    if(!empty($image_id)) {
                        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
                        $image_thumb_html = '<img src="'. $image_thumb[0] .'" alt="" />'; 
                    } else {
                        $image_thumb_html = '<img width="150" src="'.$additional_image.'" alt="" />';
                    }

                    echo '
                        <div class="gallery-img-preview">
                            '.$image_thumb_html.'
                            <input type="hidden" name="ns_additional_img[]" value="'. $additional_image .'" />
                            <span class="action delete-additional-img" title="'. esc_html__('Delete', 'ns-basics'). '"><i class="fa fa-trash"></i></span>
                            <a href="'.get_admin_url().'upload.php?item='.$image_id.'" class="action edit-additional-img" target="_blank" title="'.esc_html__('Edit', 'ns-basics').'"><i class="fa fa-pencil"></i></a>
                        </div>
                    ';
                }
            }
        } else { echo '<p class="admin-module-note no-gallery-img">'.esc_html__('No gallery images were found.', 'ns-basics').'</p>'; } ?>

        <div class="clear"></div>
        <span class="admin-button add-gallery-media"><i class="fa fa-plus"></i> <?php echo esc_html_e('Add Images', 'ns-basics'); ?></span>
    </div>
<?php }

/*-----------------------------------------------------------------------------------*/
/*  Check if key/value is in array
/*-----------------------------------------------------------------------------------*/
function ns_basics_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = ns_basics_in_array($v, $key, $key_value);
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
function ns_basics_admin_alert($type = 'info', $text = null, $action = null, $action_text = null, $dismissible = false, $class = null) {
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

?>