<?php

/*-----------------------------------------------------------------------------------*/
/*  Register Member Sidebar
/*-----------------------------------------------------------------------------------*/
register_sidebar( array(
    'name' => esc_html__( 'Dashboard Sidebar', 'rype-basics' ),
    'id' => 'dashboard_sidebar',
    'before_widget' => '<div class="widget widget-sidebar %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
) );

?>