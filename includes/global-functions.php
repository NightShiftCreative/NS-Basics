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
        if($type == 'line' && $line_name != 'n/a' && wp_style_is('linear-icons')) {
            if(empty($line_name)) { $line_name = $fa_name; }
            return '<i class="fa icon-'.$line_name.' icon icon-line '.$class.'"></i>';
        } else if($type == 'dripicon' && $dripicon_name != 'n/a' && wp_style_is('dripicons')) {
            if(empty($dripicon_name)) { $dripicon_name = $fa_name; }
            return '<i class="fa dripicons-'.$dripicon_name.' icon icon-dripicon'.$class.'"></i>';
        } else {
            return '<i class="fa fa-'.$fa_name.' icon '.$class.'"></i>';
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Sort an array by order
/*-----------------------------------------------------------------------------------*/
function ns_basics_sort_by_order($a, $b) { 
    return $a['order'] - $b['order'];   
}

/*-----------------------------------------------------------------------------------*/
/*  Check if key/value is in array
/*-----------------------------------------------------------------------------------*/
function ns_basics_in_array($array, $key, $key_value) {
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
/*  Check if key exists in multi-dimensional array
/*-----------------------------------------------------------------------------------*/
function ns_basics_in_array_key($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && ns_basics_in_array_key($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

/*-----------------------------------------------------------------------------------*/
/*  Check if plugin is active
/*-----------------------------------------------------------------------------------*/
function ns_basics_is_plugin_active($plugin_slug) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(is_plugin_active($plugin_slug.'/'.$plugin_slug.'.php')) { 
        return true; 
    } else { 
        return false;
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Get Image ID
/*-----------------------------------------------------------------------------------*/
function ns_basics_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
    return $attachment[0]; 
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

        $attachment_id = wp_insert_attachment( $attachment, $filename );
                                
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
/* Adds async/defer attributes to scripts/styles
/*-----------------------------------------------------------------------------------*/
add_filter( 'script_loader_tag', 'ns_basics_add_async_to_script', 10, 3 );
function ns_basics_add_async_to_script( $tag, $handle, $src ) {
    if (!is_admin()) {

        $script_array = array();
        $script_array = apply_filters( 'ns_basics_async_scripts', $script_array);

        if (in_array($handle, $script_array)) {
            $tag = '<script async type="text/javascript" src="' . esc_url( $src ) . '"></script>';
        }
    }
    return $tag;
}

add_filter( 'style_loader_tag', 'ns_basics_add_async_to_style', 10, 3 );
function ns_basics_add_async_to_style($html, $handle) {
    if (!is_admin()) {

        $style_array = array();
        $style_array = apply_filters( 'ns_basics_async_styles', $style_array);

        $onload = "if(media!='all')media='all'";
        $media = 'media="none" onload="'.$onload.'"';
        if(in_array($handle, $style_array)) {
            return str_replace( "media='all'", $media, $html );
        }
    }
    return $html;
}

?>