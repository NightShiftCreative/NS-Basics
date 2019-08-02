<?php 
//Get global settings
$members_register_page = esc_attr(get_option('ns_core_members_register_page'));
if(function_exists('ns_core_load_theme_options')) { $members_register_page = ns_core_load_theme_options('ns_core_members_register_page'); }

//Get template args
if(isset($template_args)) {
    $redirect = $template_args['redirect'];
} 
?>

<?php if(!is_user_logged_in()) { ?>

    <?php do_action( 'ns_basics_before_login_form'); ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">

            <?php if(!empty($members_register_page)) { ?>
            <p class="center">
                <?php esc_html_e( "Don't have an account yet?", 'ns-basics' ); ?>
                <a href="<?php echo esc_url($members_register_page); ?>"><?php esc_html_e( 'Register here!', 'ns-basics' ); ?></a>
            </p>
            <?php } ?>

            <!-- start login form -->
            <div class="login-form">
                <?php
                    if(isset($_GET['login'])) { $result = $_GET['login']; } else { $result = null; }
                    if($result == 'failed') {
                        echo '<div class="alert-box error">'. esc_html__('The passord or username you entered was incorrect. Please try again.', 'ns-basics') .'</div>';
                    }

                    if(!empty($redirect)) {
                        $login_redirect = $redirect;
                    } else {
                        $login_redirect = site_url();
                    }
                    $args = array(
                    'echo' => true,
                    'redirect' => $login_redirect, 
                    'form_id' => 'loginform'
                    );
                    wp_login_form($args);
                ?>
            </div><!-- end login form -->

        </div><!-- end col -->
    </div><!-- end row -->

    <?php do_action( 'ns_basics_after_login_form'); ?>

<?php } else { 
    ns_basics_template_loader('alert_logged_in.php', null, false);
} ?>