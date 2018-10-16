<?php 
//Get global settings
$members_register_page = esc_attr(get_option('rypecore_members_register_page'));

//Get template args
if(isset($template_args)) {
    $redirect = $template_args['redirect'];
} 
?>

<?php if(!is_user_logged_in()) { ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">

            <?php if(!empty($members_register_page)) { ?>
            <p class="center">
                <?php esc_html_e( "Don't have an account yet?", 'rype-basics' ); ?>
                <a href="<?php echo esc_url($members_register_page); ?>"><?php esc_html_e( 'Register here!', 'rype-basics' ); ?></a>
            </p>
            <?php } ?>

            <!-- start login form -->
            <div class="login-form">
                <?php
                    if(isset($_GET['login'])) { $result = $_GET['login']; } else { $result = null; }
                    if($result == 'failed') {
                        echo '<div class="alert-box error">'. esc_html__('The passord or username you entered was incorrect. Please try again.', 'rype-basics') .'</div>';
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

<?php } else { 
    rype_basics_template_loader('alert_logged_in.php', null, false);
} ?>