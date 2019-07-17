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
function ns_basics_sort_by_order($a, $b) { return $a['order'] - $b['order']; }

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

?>