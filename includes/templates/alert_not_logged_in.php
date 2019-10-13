<?php 
$members_login_page = esc_attr(get_option('ns_core_members_login_page'));
if(function_exists('ns_core_load_theme_options')) { $members_login_page = ns_core_load_theme_options('ns_core_members_login_page'); } 
?>

<div class="alert-box info">
    <p><?php esc_html_e( 'You must be logged in and have the correct privileges to view this page.', 'ns-basics' ); ?></p>
    <?php if(!empty($members_login_page)) { ?><a class="button small" href="<?php echo $members_login_page; ?>"><?php esc_html_e( 'Login', 'ns-basics' ); ?></a><?php } ?>
</div>