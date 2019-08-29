<?php global $current_user, $wp_roles; ?>    

<div class="user-dashboard">
    <?php if(is_user_logged_in()) { ?>

    	<?php do_action( 'ns_basics_before_dashboard'); ?>

    	<h3><?php esc_html_e('Welcome back,', 'ns-basics'); ?> <strong><?php echo esc_attr($current_user->user_login); ?>!</strong></h3>
        
        <?php do_action( 'ns_basics_dashboard_stats'); ?><div class="clear"></div>
        <?php do_action( 'ns_basics_after_dashboard'); ?>

	<?php } else {
        ns_basics_template_loader('alert_not_logged_in.php');
    } ?>

    <div class="clear"></div>
</div>