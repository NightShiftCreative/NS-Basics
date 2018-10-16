<?php

/*-----------------------------------------------------------------------------------*/
/* VALIDATE LICENSE KEY
/*-----------------------------------------------------------------------------------*/
function ns_basics_is_valid_license_key($license) {
    if(empty($license['key']) || empty($license['email'])) {
        return array('result' => false, 'error' => '');
    } else {
        $data_args = array('timeout' => 15, 'sslverify' => false);
        $data = wp_remote_get('http://rypecreative.com/rype-test/woocommerce/?wc-api=software-api&request=check&email='.$license['email'].'&license_key='.$license['key'].'&product_id='.$license['slug'], $data_args);
        if(!is_wp_error($data)) {
            $data = $data['body'];
            $obj = json_decode($data);
            if($obj->success == true) {
                return array('result' => true, 'error' => '');
            } else {
                return array('result' => false, 'error' => esc_html__('Your license key and/or license email is invalid.', 'ns-basics'));
            }
        } else {
            return array('result' => false, 'error' => $data->get_error_message());
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*  UPDATE LICENSE KEY STATUS (fires only when settings are saved)
/*-----------------------------------------------------------------------------------*/
function ns_basics_activate_license_key( $old_value, $new_value, $option ) {
    $valid_key = ns_basics_is_valid_license_key($new_value);
    if($valid_key['result'] == true) {
        $new_value['registered'] = true;
        $new_value['error'] = '';
    } else {
        $new_value['registered'] = false;
        $new_value['error'] = $valid_key['error'];
    }
    update_option($option, $new_value);
}

/*-----------------------------------------------------------------------------------*/
/* GET LICENSE KEY STATUS
/*-----------------------------------------------------------------------------------*/
function ns_basics_get_license_status($license, $product_link = null, $register_link = null, $show_errors = null) {
    if(!ns_basics_is_paid_plugin_active($license['slug'])) { ?>
        <?php if(!empty($product_link)) { ?><a href="<?php echo $product_link; ?>" target="_blank" class="button button-purchase button-green"><?php esc_html_e('Purchase', 'ns-basics'); ?></a><?php } ?>
    <?php } else {
        if($license['registered'] == true) {
            echo '<a href="'.$register_link.'" class="button button-activated button-green"><i class="fa fa-check"></i> '.esc_html__('Registered', 'ns-basics').'</a>';
        } else {
            echo '<a href="'.$register_link.'" class="button button-activated button-red">'.esc_html__('Unregistered', 'ns-basics').'</a>';
            if($show_errors == 'true' && !empty($license['error'])) { echo '<span class="admin-module-note license-error">'.$license['error'].'</span>'; }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* CHECK IF PAID ADD-ON PLUGIN IS ACTIVE
/*-----------------------------------------------------------------------------------*/
function ns_basics_is_paid_plugin_active($add_on_slug) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(is_plugin_active($add_on_slug.'/'.$add_on_slug.'.php')) { 
        return true; 
    } else { 
        return false;
    }
}

?>