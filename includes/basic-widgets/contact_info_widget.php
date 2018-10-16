<?php
/**
 * Contact Info Widget Class
 */
class ns_basics_contact_info_widget extends WP_Widget {

    /** constructor */
    function __construct() {

        $widget_options = array(
          'classname'=>'contact-info',
          'description'=> esc_html__('Display your contact info.', 'ns-basics'),
          'panels_groups' => array('ns-basics')
        );
		parent::__construct('ns_basics_contact_info_widget', esc_html__('(NightShift) Contact Info', 'ns-basics'), $widget_options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
		global $wpdb;

        $icon_set = get_option('rypecore_icon_set', 'fa');

        $title = apply_filters('widget_title', $instance['title']);
        $before_text = $instance['before_text'];
		    $address = $instance['address'];
		    $phone = $instance['phone'];
		    $email = $instance['email'];

        ?>
              
        <?php echo wp_kses_post($before_widget); ?>
                  
        <?php if ( $title )
          echo wp_kses_post($before_title . $title . $after_title); ?>

        <?php if($before_text) { echo '<p>'.esc_attr($before_text).'</p>'; } ?> 

        <ul class="contact-list clean-list">
							<?php 
							if ( $address ) { ?>
								<li><?php echo rypecore_get_icon($icon_set, 'map-marker', '', 'location'); ?> <?php echo esc_attr($address); ?></li>
							<?php } ?>  

							<?php if ( $phone ) { ?>
								<li><?php echo rypecore_get_icon($icon_set, 'phone', 'telephone'); ?> <?php echo esc_attr($phone); ?></li>
							<?php } ?>

							<?php if ( $email ) { ?>
								<li><?php echo rypecore_get_icon($icon_set, 'envelope', '', 'mail'); ?> <?php echo esc_attr($email); ?></li>
							<?php } ?> 
				</ul>

              <?php echo wp_kses_post($after_widget); ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
    $instance['before_text'] = strip_tags($new_instance['before_text']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['email'] = strip_tags($new_instance['email']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

        if (isset($instance['title'])) { $title = esc_attr($instance['title']); } else { $title = ''; }
        if (isset($instance['before_text'])) { $before_text = esc_attr($instance['before_text']); } else { $before_text = ''; }
		    if (isset($instance['address'])) { $address = esc_attr($instance['address']); } else { $address = ''; }
		    if (isset($instance['phone'])) { $phone = esc_attr($instance['phone']); } else { $phone = ''; }
		    if (isset($instance['email'])) { $email = esc_attr($instance['email']); } else { $email = ''; }

        ?>

        <p>
	       <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'ns-basics'); ?></label>
	       <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	      </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id('before_text')); ?>"><?php esc_html_e('Text Before:', 'ns-basics'); ?></label>
          <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('before_text')); ?>" name="<?php echo esc_attr($this->get_field_name('before_text')); ?>"><?php echo esc_attr($before_text); ?></textarea>
        </p>

        <p>
		      <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Address:', 'ns-basics'); ?></label>
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>" />
        </p>

		    <p>
		      <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone:', 'ns-basics'); ?></label>
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
        </p>

        <p>
		      <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email:', 'ns-basics'); ?></label>
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
        </p>

        <?php
    }

} // class utopian_recent_posts
add_action('widgets_init', create_function('', 'return register_widget("ns_basics_contact_info_widget");'));

?>