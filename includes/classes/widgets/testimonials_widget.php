<?php
/**
 * Testimonials Widget Class
 */
class ns_basics_testimonials_widget extends WP_Widget {

    /** constructor */
    function __construct() {

        $widget_options = array(
          'classname'=>'testimonials-widget',
          'description'=> esc_html__('Display a testimonials slider.', 'ns-basics'),
          'panels_groups' => array('ns-basics')
        );
        parent::__construct('ns_basics_testimonials_widget', esc_html__('(Nightshift) Testimonials', 'ns-basics'), $widget_options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        global $wpdb;

        $icon_set = get_option('ns_core_icon_set', 'fa');
        if(function_exists('ns_core_load_theme_options')) { $icon_set = ns_core_load_theme_options('ns_core_icon_set'); }

        $slides_default = array(
            array('name'=> 'John Doe', 'position'=> 'CEO at Google', 'image'=> '', 'text' => 'NightShift Creative provided fast and beautiful web design!'),
        );

        $title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : '';
        $slides = isset( $instance['slides'] ) ? $instance['slides'] : $slides_default;

        ?>
              <?php echo wp_kses_post($before_widget); ?>
                  <?php 

                        if($title) {
                            echo wp_kses_post($before_title . $title . $after_title); ?>
                        <?php }
                        ?>

                        <div class="slider-wrap slider-wrap-testimonials">
                            <div class="slider-nav slider-nav-testimonials">
                                <span class="slider-prev slick-arrow"><i class="fa fa-angle-left"></i></span>
                                <span class="slider-next slick-arrow"><i class="fa fa-angle-right"></i></span>
                            </div>

                            <div class="slider slider-testimonials">
                                <?php foreach($slides as $slide) { ?>
                                    <?php if(!empty($slide['name']) || !empty($slide['position']) || !empty($slide['image']) || !empty($slide['text'])) { ?>
                                        <div class="testimonial slide">
                                            <?php if(!empty($slide['text'])) { ?><h3><?php echo $slide['text']; ?></h3><?php } ?>
                                            <div class="testimonial-details">
                                                <?php if(!empty($slide['image'])) { ?><img class="testimonial-img" src="<?php echo $slide['image']; ?>" alt="" /><?php } ?>
                                                <?php if(!empty($slide['name'])) { ?><span class="testimonial-name"><strong><?php echo $slide['name']; ?></strong></span><?php } ?>
                                                <?php if(!empty($slide['position'])) { ?><span class="testiomnial-title"><em><?php echo $slide['position']; ?></em></span><?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

              <?php echo wp_kses_post($after_widget); ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['slides'] = array();
        if ( isset ( $new_instance['slides'] ) ) {
            foreach ( $new_instance['slides'] as $value ) { 
                if ('' !== $value) { $instance['slides'][] = $value; }
            }
        }

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) { 

        if (isset($instance['title'])) { $title = esc_attr($instance['title']); } else { $title = ''; }

        $slides_default = array(
            array('name'=> 'John Doe', 'position'=> 'CEO at Google', 'image'=> '', 'text' => 'NightShift Creative provided fast and beautiful web design!'),
        );
        $slides = isset ( $instance['slides'] ) ? $instance['slides'] : $slides_default;

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'ns-basics'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <div class="testimonials-widget-container">
                <span class="testimonial-field-name" style="display:none;"><?php echo esc_attr($this->get_field_name('slides')); ?></span>
                <?php $slide_count = 0; ?>
                <?php foreach ( $slides as $slide ) { ?>
                    <?php if(!empty($slide['name']) || !empty($slide['position']) || !empty($slide['image']) || !empty($slide['text'])) { ?>
                    <div class="testimonial-item">
                        <div class="testimonial-header">
                            <i class="icon fa fa-cog"></i> <strong><?php echo $slide['name']; ?></strong>
                            <span class="right testimonial-delete"><i class="icon fa fa-close"></i> <?php esc_html_e('Remove', 'ns-basics'); ?></span>
                        </div>
                        <div class="testimonial-content">
                            <table>
                                <tr>
                                    <td valign="top"><label><?php esc_html_e('Name:', 'ns-basics'); ?></label></td>
                                    <td valign="top"><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('slides')); ?>[<?php echo $slide_count; ?>][name]" value="<?php echo $slide['name']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td valign="top"><label><?php esc_html_e('Position:', 'ns-basics'); ?></label></td>
                                    <td valign="top"><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('slides')); ?>[<?php echo $slide_count; ?>][position]" value="<?php echo $slide['position']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td valign="top"><label><?php esc_html_e('Image URL:', 'ns-basics'); ?></label></td>
                                    <td valign="top"><input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('slides')); ?>[<?php echo $slide_count; ?>][image]" value="<?php echo $slide['image']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td valign="top"><label><?php esc_html_e('Testimonial:', 'ns-basics'); ?></label></td>
                                    <td valign="top"><textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('slides')); ?>[<?php echo $slide_count; ?>][text]"><?php echo $slide['text']; ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php $slide_count++; ?>
                    <?php } ?>
                <?php } ?>
                <span class="button button-add-testimonial"><?php esc_html_e('Add Testimonial', 'ns-basics'); ?></span>
            </div>
        </p>

        <?php
    }

}

add_action('widgets_init', 'ns_basics_testimonials_widget_init');
function ns_basics_testimonials_widget_init() { 
    return register_widget('ns_basics_testimonials_widget'); 
}

?>