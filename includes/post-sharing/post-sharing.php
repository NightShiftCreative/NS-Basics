<?php

function rype_basics_get_social_share($class = null, $toggle_text = null) {
        global $post;
        $icon_set = esc_attr(get_option('rypecore_icon_set', 'fa'));
        $toggle = rypecore_get_icon($icon_set, 'share-alt', 'share2', 'forward');
        $content = '';

        //email details
        $mail_icon = rypecore_get_icon($icon_set, 'envelope', '', 'mail');
        $subject = get_the_title().' on '.get_bloginfo('name');
        $body = '';
        $body .= get_the_permalink();
        $body .= '%0D%0A %0D%0A'.strip_tags(get_the_content($post->ID)).'%0D%0A %0D%0A';

        ob_start();

        if($toggle_text === true) { $toggle = $toggle.esc_html__('Share', 'rype-basics'); } 

        $content .= '<ul class="clean-list">';
        $content .= '<li><a href="http://www.facebook.com/sharer/sharer.php?u='.get_the_permalink().'&t='.rawurlencode(get_the_title()).' target="_blank"><i class="fa fa-facebook"></i></a></li>';
        $content .= '<li><a href="https://twitter.com/share?url='.get_the_permalink().'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
        $content .= '<li><a href="https://plus.google.com/share?url='.get_the_permalink().'" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
        $content .= '<li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.get_the_permalink().'&title='.rawurlencode(get_the_title()).'&summary=&source=" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
        $content .= '<li><a href="https://pinterest.com/pin/create/button/?url=&media='.get_the_permalink().'&description=" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
        $content .= '<li><a href="mailto:?subject='.$subject.'&body='.$body.'">'.$mail_icon.'</a></li>';
        $content .= '</ul>';

        echo ns_basics_tooltip($toggle, $content, 'post-share');
        $output = ob_get_clean();
        return $output;
}

function rype_basics_add_post_share() { ?> 
    <li><?php echo rype_basics_get_social_share('blog-share', true); ?></li>
<?php }
add_action( 'ns_basics_after_post_meta', 'rype_basics_add_post_share' );

?>