<?php
/**
 * List Posts Widget Class
 */
class ns_basics_list_posts_widget extends WP_Widget {

    /** constructor */
    function __construct() {

        $widget_options = array(
          'classname'=>'list-posts-widget',
          'description'=> esc_html__('Display a list of blog posts.', 'ns-basics'),
          'panels_groups' => array('ns-basics')
        );
		parent::__construct('ns_basics_list_posts_widget', esc_html__('(Nightshift) List Posts', 'ns-basics'), $widget_options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        global $wpdb;

        $title = apply_filters('widget_title', $instance['title']);
        $num = $instance['num'];
        $show_thumb = $instance['show_thumb'];
        $show_date = $instance['show_date'];
        $show_excerpt = $instance['show_excerpt'];
        $excerpt_size = $instance['excerpt_size'];
        $filter = $instance['filter'];

        ?>
              <?php echo wp_kses_post($before_widget); ?>
                  <?php if ( $title )
                        echo wp_kses_post($before_title . $title . $after_title);

                        $post_listing_args = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'showposts' => $num,
                            'category_name' => $filter,
                        );

                        $post_listing_query = new WP_Query( $post_listing_args );
                        if ( $post_listing_query->have_posts() ) : while ( $post_listing_query->have_posts() ) : $post_listing_query->the_post(); ?>

                            <div class="list-posts">
                                <div class="row">

                                    <?php if ($show_thumb == 'yes') {  ?>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="post-img">
                                                <?php if (has_post_thumbnail()) {  ?>
                                                    <a href="<?php the_permalink(); ?>" class="post-img-link"><?php the_post_thumbnail('thumbnail'); ?></a>
                                                <?php } else { ?>
                                                    <a href="<?php the_permalink(); ?>" class="post-img-link"><img src="<?php echo plugins_url('../../images/default-post-image.gif', __FILE__); ?>" alt="" /></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <h5 title="<?php the_title(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                            <?php if($show_date) { echo '<p><i class="fa fa-calendar icon"></i>'.get_the_date().'</p>'; } ?>
                                            <?php if($show_excerpt && function_exists('ns_core_excerpt')) { echo '<p>'.ns_core_excerpt($excerpt_size).'</p>'; } ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-lg-12">
                                            <h5 title="<?php the_title(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                            <?php if($show_date) { echo '<p><i class="fa fa-calendar-o icon"></i>'.get_the_date().'</p>'; } ?>
                                            <?php if($show_excerpt && function_exists('ns_core_excerpt')) { echo '<p>'.ns_core_excerpt($excerpt_size).'</p>'; } ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                        <?php 
                        endwhile; 
                        wp_reset_postdata();
                        else:
                        endif; 
                        ?>

              <?php echo wp_kses_post($after_widget); ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num'] = strip_tags($new_instance['num']);
        $instance['show_thumb'] = strip_tags($new_instance['show_thumb']);
        $instance['show_date'] = strip_tags($new_instance['show_date']);
        $instance['show_excerpt'] = strip_tags($new_instance['show_excerpt']);
        $instance['excerpt_size'] = strip_tags($new_instance['excerpt_size']);
        $instance['filter'] = strip_tags($new_instance['filter']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {  

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'num' => 3, 'excerpt_size' => 10, 'show_thumb' => null, 'show_date' => null, 'show_excerpt' => null, 'filter' => null) );
        $title = esc_attr($instance['title']);
        $num = esc_attr($instance['num']);
        $show_thumb = esc_attr($instance['show_thumb']);
        $show_date = esc_attr($instance['show_date']);
        $show_excerpt = esc_attr($instance['show_excerpt']);
        $excerpt_size = esc_attr($instance['excerpt_size']);
        $filter = esc_attr($instance['filter']);

        ?>

        <p>
           <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'ns-basics'); ?></label>
           <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id('num')); ?>"><?php esc_html_e('Number of Posts:', 'ns-basics'); ?></label>
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('num')); ?>" name="<?php echo esc_attr($this->get_field_name('num')); ?>" type="number" value="<?php echo esc_attr($num); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>"><?php esc_html_e('Show Thumbnail:', 'ns-basics'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>">
                <option value="yes" <?php if($show_thumb == 'yes') { echo 'selected'; } ?>><?php esc_html_e('Yes', 'ns-basics'); ?></option>
                <option value="no" <?php if($show_thumb == 'no') { echo 'selected'; } ?>><?php esc_html_e('No', 'ns-basics'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('filter')); ?>"><?php esc_html_e('Filter By Category:', 'ns-basics'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('filter')); ?>" name="<?php echo esc_attr($this->get_field_name('filter')); ?>">
                <option value="">All Categories</option>
                <?php $categories = get_categories(); ?>
                <?php foreach($categories as $category) { ?>
                    <option value="<?php echo esc_attr($category->slug); ?>" <?php if($filter == $category->slug) { echo 'selected'; } ?>><?php echo esc_attr($category->name); ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Show Date:', 'ns-basics'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" type="checkbox" value="true" <?php if($show_date) { echo 'checked'; } ?> />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>"><?php esc_html_e('Show Excerpt:', 'ns-basics'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>" name="<?php echo esc_attr($this->get_field_name('show_excerpt')); ?>" type="checkbox" value="true" <?php if($show_excerpt) { echo 'checked'; } ?> />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('excerpt_size')); ?>"><?php esc_html_e('Excerpt Size:', 'ns-basics'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('excerpt_size')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_size')); ?>" type="number" value="<?php echo esc_attr($excerpt_size); ?>" />
        </p>

        <?php
    }

} // class utopian_recent_posts
add_action('widgets_init', create_function('', 'return register_widget("ns_basics_list_posts_widget");'));

?>