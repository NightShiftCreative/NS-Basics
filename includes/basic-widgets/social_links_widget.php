<?php
/**
 * Social Links Widget Class
 */
class ns_basics_social_links_widget extends WP_Widget {

    /** constructor */
    function __construct() {

        $widget_options = array(
          'classname'=>'social-links',
          'description'=> esc_html__('Display your social media links.', 'ns-basics'),
          'panels_groups' => array('ns-basics')
        );
		parent::__construct('ns_basics_social_links_widget', esc_html__('(NightShift) Social Links', 'ns-basics'), $widget_options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        global $wpdb;

        $title = apply_filters('widget_title', $instance['title']);
        $source = $instance['source'];
        $text_before = $instance['text_before'];
        $text_after = $instance['text_after'];

        ?>
              <?php echo wp_kses_post($before_widget); ?>
                  <?php if ( $title )
                        echo wp_kses_post($before_title . $title . $after_title); ?>

                        <div class="socil-links-widget">

                            <?php if($text_before) { echo '<div class="social-links-before-text">'. wp_kses_post($text_before) .'</div><div class="divider"></div>'; } ?>

                            <?php
                            if($source == 'custom') {
                                $fb = $instance['facebook'];
                                $twitter = $instance['twitter'];
                                $google = $instance['google'];
                                $linkedin = $instance['linkedin'];
                                $youtube = $instance['youtube'];
                                $vimeo = $instance['vimeo'];
                                $instagram = $instance['instagram'];
                                $flickr = $instance['flickr'];
                                $dribbble = $instance['dribbble'];
                            } else {
                                $fb = esc_attr(get_option('rypecore_fb'));
                                $twitter = esc_attr(get_option('rypecore_twitter'));
                                $google = esc_attr(get_option('rypecore_google'));
                                $linkedin = esc_attr(get_option('rypecore_linkedin'));
                                $youtube = esc_attr(get_option('rypecore_youtube'));
                                $vimeo = esc_attr(get_option('rypecore_vimeo'));
                                $instagram = esc_attr(get_option('rypecore_instagram'));
                                $flickr = esc_attr(get_option('rypecore_flickr'));
                                $dribbble = esc_attr(get_option('rypecore_dribbble'));
                            }
                            ?>

                            <ul class="social-icons circle clean-list">
                                <?php if(!empty($fb)) { ?><li><a href="<?php echo esc_url($fb); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                <?php if(!empty($twitter)) { ?><li><a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                <?php if(!empty($google)) { ?><li><a href="<?php echo esc_url($google); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                <?php if(!empty($linkedin)) { ?><li><a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                <?php if(!empty($youtube)) { ?><li><a href="<?php echo esc_url($youtube); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                                <?php if(!empty($vimeo)) { ?><li><a href="<?php echo esc_url($vimeo); ?>" target="_blank"><i class="fa fa-vimeo"></i></a></li><?php } ?>
                                <?php if(!empty($instagram)) { ?><li><a href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                                <?php if(!empty($flickr)) { ?><li><a href="<?php echo esc_url($flickr); ?>" target="_blank"><i class="fa fa-flickr"></i></a></li><?php } ?>
                                <?php if(!empty($dribbble)) { ?><li><a href="<?php echo esc_url($dribbble); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li><?php } ?>
                            </ul>

                            <?php if($text_after) { echo '<div class="divider"></div><div class="social-links-after-text">'. wp_kses_post($text_after) .'</div>'; } ?>
                        </div>

              <?php echo wp_kses_post($after_widget); ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['source'] = $new_instance['source'];
        $instance['facebook'] = $new_instance['facebook'];
        $instance['twitter'] = $new_instance['twitter'];
        $instance['google'] = $new_instance['google'];
        $instance['linkedin'] = $new_instance['linkedin'];
        $instance['youtube'] = $new_instance['youtube'];
        $instance['vimeo'] = $new_instance['vimeo'];
        $instance['instagram'] = $new_instance['instagram'];
        $instance['flickr'] = $new_instance['flickr'];
        $instance['dribbble'] = $new_instance['dribbble'];
        $instance['text_before'] = $new_instance['text_before'];
        $instance['text_after'] = $new_instance['text_after'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {  

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text_before' => null, 'text_after' => null) );
        $title = esc_attr($instance['title']);
        $source = esc_attr($instance['source']);
        $facebook = esc_attr($instance['facebook']);
        $twitter = esc_attr($instance['twitter']);
        $google = esc_attr($instance['google']);
        $linkedin = esc_attr($instance['linkedin']);
        $youtube = esc_attr($instance['youtube']);
        $vimeo = esc_attr($instance['vimeo']);
        $instagram = esc_attr($instance['instagram']);
        $flickr = esc_attr($instance['flickr']);
        $dribbble = esc_attr($instance['dribbble']);
        $text_before = esc_attr($instance['text_before']);
        $text_after = esc_attr($instance['text_after']);

        ?>

        <p>
           <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'ns-basics'); ?></label>
           <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('source')); ?>"><?php esc_html_e('Source:', 'ns-basics'); ?></label>
            <select class="widefat social-links-source" name="<?php echo esc_attr($this->get_field_name('source')); ?>">
                <option value="theme-options" <?php if($source == 'theme-options') { echo 'selected'; } ?>><?php esc_html_e('Theme Options', 'ns-basics'); ?></option>
                <option value="custom" <?php if($source == 'custom') { echo 'selected'; } ?>><?php esc_html_e('Custom', 'ns-basics'); ?></option>
            </select>
        </p>

        <div class="custom-social-fields <?php if($source == 'custom') { echo 'show'; } else { echo 'hide-soft'; } ?>">
            <p><label>Facebook: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" value="<?php echo esc_url($facebook); ?>" /></p>
            <p><label>Twitter: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" value="<?php echo esc_url($twitter); ?>" /></p>
            <p><label>Google Plus: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('google')); ?>" value="<?php echo esc_url($google); ?>" /></p>
            <p><label>Linkedin: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" value="<?php echo esc_url($linkedin); ?>" /></p>
            <p><label>Youtube: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" value="<?php echo esc_url($youtube); ?>" /></p>
            <p><label>Vimeo: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" value="<?php echo esc_url($vimeo); ?>" /></p>
            <p><label>Instagram: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" value="<?php echo esc_url($instagram); ?>" /></p>
            <p><label>Flickr: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" value="<?php echo esc_url($flickr); ?>" /></p>
            <p><label>Dribbble: </label><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('dribbble')); ?>" value="<?php echo esc_url($dribbble); ?>" /></p>
        </div>

        <div class="admin-module-note theme-note <?php if($source == 'theme-options') { echo 'show'; } else { echo 'hide'; } ?>"><?php esc_html_e('Only compatible with themes by NightShift Creative.', 'ns-basics'); ?></div>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id('text_before')); ?>"><?php esc_html_e('Text Before:', 'ns-basics'); ?></label>
          <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text_before')); ?>" name="<?php echo esc_attr($this->get_field_name('text_before')); ?>"><?php echo esc_attr($text_before); ?></textarea>
        </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id('text_after')); ?>"><?php esc_html_e('Text After:', 'ns-basics'); ?></label>
          <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text_after')); ?>" name="<?php echo esc_attr($this->get_field_name('text_after')); ?>"><?php echo esc_attr($text_after); ?></textarea>
        </p>

        <?php
    }

} // class utopian_recent_posts
add_action('widgets_init', create_function('', 'return register_widget("ns_basics_social_links_widget");'));

?>