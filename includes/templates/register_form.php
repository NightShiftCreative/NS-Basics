<?php 
//Get global settings
$members_login_page = esc_attr(get_option('ns_core_members_login_page')); 
if(function_exists('ns_core_load_theme_options')) { $members_login_page = ns_core_load_theme_options('ns_core_members_login_page'); }

//Get template args
if(isset($template_args)) {
    $role = $template_args['role'];
    if(empty($role)) { $role = 'subscriber'; }
} 
?>

<?php

    //PROCESS FORM
    $success = '';
    $usernameError = '';
    $passError = '';
    $emailError = '';
    $insertUserError = '';

    $username = '';
    $password = '';
    $email = '';

    if (!empty($_POST)) {

        do_action( 'ns_basics_register_submitted');

        if($_POST['register_username'] == '') {
            $usernameError = esc_html__('Please enter a username', 'ns-basics');
            $hasError = true;
        } else {
            $username = $_POST['register_username'];
        }

        if($_POST['register_pass'] == '') {
            $passError = esc_html__('Please enter a password', 'ns-basics');
            $hasError = true;
        } else {
            $password = $_POST['register_pass'];
        }

        if($_POST['register_email'] == '') {
            $emailError = esc_html__('Please enter an email', 'ns-basics');
            $hasError = true;
        } else {
            $email = $_POST['register_email'];
        }

        if(!isset($hasError)) {

            $userdata = array(
                'user_login'  =>  $username,
                'user_pass'    =>  $password,
                'user_email'   =>  $email,
                'role' => $role
            );

            $user_id = wp_insert_user( $userdata );

            //If no errors, log the user in
            if( !is_wp_error($user_id) ) {
                $success = esc_html__('Your account has been created.', 'ns-basics') .' <a href="'. $members_login_page .'">'. esc_html__('Login here.', 'ns-basics') .'</a>';
            } else {
                $insertUserError = $user_id->get_error_message();
            }
        }

    }
?>

<?php if(!is_user_logged_in()) { ?>

    <?php do_action( 'ns_basics_before_register_form'); ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">

            <?php if(!empty($members_login_page)) { ?>
            <p class="center">
                <?php esc_html_e( "Already have an account?", 'ns-basics' ); ?>
                <a href="<?php echo esc_url($members_login_page); ?>"><?php esc_html_e( 'Login here!', 'ns-basics' ); ?></a>
            </p>
            <?php } ?>

            <!-- start register form -->
            <div class="login-form">
                <?php if($success != '') { ?>
                    <div class="alert-box success"><h4><?php echo wp_kses_post($success); ?></h4></div>
                <?php } ?>
                <?php if($usernameError != '') { ?>
                    <div class="alert-box error"><h4><?php echo esc_attr($usernameError); ?></h4></div>
                <?php } ?>
                <?php if($passError != '') { ?>
                    <div class="alert-box error"><h4><?php echo esc_attr($passError); ?></h4></div>
                <?php } ?>
                <?php if($emailError != '') { ?>
                    <div class="alert-box error"><h4><?php echo esc_attr($emailError); ?></h4></div>
                <?php } ?>
                <?php if($insertUserError != '') { ?>
                    <div class="alert-box error"><h4><?php echo esc_attr($insertUserError); ?></h4></div>
                <?php } ?>
                <form method="post" action="<?php the_permalink(); ?>">
                    <div class="form-block">
                        <label for="register_username"><?php esc_html_e( 'Username', 'ns-basics' ); ?></label>
                        <input type="text" name="register_username" id="register_username" value="<?php if(isset($_POST['register_username'])) { echo esc_attr($username); } ?>" />
                    </div>
                    <div class="form-block">
                        <label for="register_pass"><?php esc_html_e( 'Password', 'ns-basics' ); ?></label>
                        <input type="password" name="register_pass" id="register_pass" value="<?php if(isset($_POST['register_pass'])) { echo esc_attr($password); } ?>" />
                    </div>
                    <div class="form-block">
                        <label for="register_email"><?php esc_html_e( 'Email', 'ns-basics' ); ?></label>
                        <input type="email" name="register_email" id="register_email" value="<?php if(isset($_POST['register_email'])) { echo esc_attr($email); } ?>" />
                    </div>

                    <?php do_action( 'ns_basics_after_register_form_fields'); ?>

                    <input type="submit" class="button" value="<?php esc_html_e( 'Create Account', 'ns-basics' ); ?>" />
                </form>
            </div>
            <!-- end register form -->

        </div><!-- end col -->
    </div><!-- end row -->

    <?php do_action( 'ns_basics_after_register_form'); ?>

<?php } else { 
    ns_basics_template_loader('alert_logged_in.php', null, false);
} ?>