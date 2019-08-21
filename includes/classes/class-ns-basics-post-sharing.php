<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Post_Sharing class
 *
 *  Adds social sharing tooltip below post titles.
 */
class NS_Basics_Post_Sharing {

	/************************************************************************/
	// Initialize
	/************************************************************************/

	/**
	 *	Init
	 */
	public function init() {
		add_action( 'ns_core_after_post_meta', array( $this, 'add_post_sharing' ));
	}

	/************************************************************************/
	// Output Post Sharing
	/************************************************************************/

	/**
	 * Add post sharing to blog posts
	 */
	public function add_post_sharing() { 
		echo '<li>'.$this->build_post_sharing_links('post-share', true).'</li>';
	}

	/**
	 * Build post sharing links
	 *
	 * @param string $class
	 * @param string $toggle_text
	 */
	public function build_post_sharing_links($class = null, $toggle_text = null) { 
		
		//global settings
		global $post;
        $icon_set = esc_attr(get_option('ns_core_icon_set', 'fa'));
        if(function_exists('ns_core_load_theme_options')) { $icon_set = ns_core_load_theme_options('ns_core_icon_set'); }
        $toggle = ns_core_get_icon($icon_set, 'share-alt', 'share2', 'forward');
        $content = '';

        //email details
        $mail_icon = ns_core_get_icon($icon_set, 'envelope', '', 'mail');
        $subject = get_the_title().' on '.get_bloginfo('name');
        $body = '';
        $body .= get_the_permalink();
        $body .= '%0D%0A %0D%0A'.strip_tags(get_the_content($post->ID)).'%0D%0A %0D%0A';

        ob_start();

        if($toggle_text === true) { $toggle = $toggle.esc_html__('Share', 'ns-basics'); } 

        $content .= '<ul class="clean-list">';
        $content .= '<li><a href="http://www.facebook.com/sharer/sharer.php?u='.get_the_permalink().'&t='.rawurlencode(get_the_title()).' target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
        $content .= '<li><a href="https://twitter.com/share?url='.get_the_permalink().'" target="_blank"><i class="fab fa-twitter"></i></a></li>';
        $content .= '<li><a href="https://plus.google.com/share?url='.get_the_permalink().'" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>';
        $content .= '<li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.get_the_permalink().'&title='.rawurlencode(get_the_title()).'&summary=&source=" target="_blank"><i class="fab fa-linkedin"></i></a></li>';
        $content .= '<li><a href="https://pinterest.com/pin/create/button/?url=&media='.get_the_permalink().'&description=" target="_blank"><i class="fab fa-pinterest"></i></a></li>';
        $content .= '<li><a href="mailto:?subject='.$subject.'&body='.$body.'">'.$mail_icon.'</a></li>';
        $content .= '</ul>';

        echo ns_basics_tooltip($toggle, $content, $class);

        $output = ob_get_clean();
        return $output;
	}

}

?>