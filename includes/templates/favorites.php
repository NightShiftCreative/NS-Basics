<?php 
//Get global settings
global $current_user, $wp_roles;
$icon_set = esc_attr(get_option('ns_core_icon_set', 'fa'));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

//Get template args
if(isset($template_args)) {
	$show_posts = $template_args['show_posts'];
} 
?>    

<div class="user-dashboard">
	<?php if(is_user_logged_in()) { 
		
		do_action( 'ns_basics_before_favorites');

		$all_types = get_post_types( array( 'public' => true ) );

		$post_favorites_args = array(
	        'post_type' => $all_types,
	        'posts_per_page' => $show_posts,
	        'paged' => $paged,
	        'meta_query' => array (
	            array (
	                'key' => '_user_liked',
	                'value' => $current_user->ID,
	                'compare' => 'LIKE'
	            )
	        )
	    );
	    $post_favorites_query = new WP_Query( $post_favorites_args );
		?>

		<h4>
			<?php if(function_exists('ns_basics_show_user_likes_count')) {
			    $show_user_likes_count = ns_basics_show_user_likes_count($current_user); 
			    echo ns_basics_sl_format_count($show_user_likes_count );
			} ?>
			<?php esc_html_e('Favorites', 'ns-basics'); ?>
		</h4>

		<table class="user-dashboard-table favorites-listing">
			<tr class="user-dashboard-table-header favorites-listing-header">
	            <td class="user-dashboard-table-img favorites-listing-img"><?php esc_html_e('Image', 'ns-basics'); ?></td>
	            <td class="favorites-listing-title"><?php esc_html_e('Title', 'ns-basics'); ?></td>
	            <td class="favorites-listing-type"><?php esc_html_e('Post Type', 'ns-basics'); ?></td>
	            <td class="user-dashboard-table-actions favorites-listing-actions"><?php esc_html_e('Actions', 'ns-basics'); ?></td>
	        </tr>

	        <?php if ( $post_favorites_query->have_posts() ) : while ( $post_favorites_query->have_posts() ) : $post_favorites_query->the_post(); ?>
	        	
	        	<?php
	        	$post_type = get_post_type();
	        	foreach($all_types as $type) {
					if($type == $post_type) {
						$post_type_data = get_post_type_object($type);
						$post_type_slug = $post_type_data->rewrite['slug'];
						if(!empty($post_type_slug )) { $post_type = $post_type_slug; }
					}
				} ?>

	        	<tr>
	        		<td class="user-dashboard-table-img favorites-listing-img"><?php if(has_post_thumbnail()) { the_post_thumbnail('thumb'); } else { echo '--'; } ?></td>
	        		<td class="favorites-listing-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
	        		<td class="favorites-listing-type"><?php echo $post_type; ?></td>
	        		<td class="user-dashboard-table-actions favorites-listing-actions">
	        			<a href="<?php the_permalink(); ?>"><?php echo ns_core_get_icon($icon_set, 'eye', 'eye', 'preview'); ?><?php esc_html_e('View', 'ns-basics'); ?></a>
	        			<?php if(function_exists('ns_basics_get_post_likes_button')) { echo ns_basics_get_post_likes_button(get_the_ID(), null, true); } ?>
	        		</td>
	        	</tr>
		    <?php endwhile; ?>
		        </table>
		        <?php wp_reset_postdata();
		        $big = 999999999; // need an unlikely integer

		        $args = array(
		            'base'         => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		            'format'       => '/page/%#%',
		            'total'        => $post_favorites_query->max_num_pages,
		            'current'      => max( 1, get_query_var('paged') ),
		            'show_all'     => False,
		            'end_size'     => 1,
		            'mid_size'     => 2,
		            'prev_next'    => True,
		            'prev_text'    => esc_html__('&raquo; Previous', 'ns-basics'),
		            'next_text'    => esc_html__('Next &raquo;', 'ns-basics'),
		            'type'         => 'plain',
		            'add_args'     => False,
		            'add_fragment' => '',
		            'before_page_number' => '',
		            'after_page_number' => ''
		        );
		        ?>
		        <div class="page-list"><?php echo paginate_links( $args ); ?> </div>
		    <?php else: ?>
		        </table>
		        <p><?php esc_html_e('You have not liked any posts yet.', 'ns-basics'); ?></p>
		        <?php wp_reset_postdata(); ?>
		    <?php endif; ?>

        <?php do_action( 'ns_basics_after_favorites'); ?>

	<?php } else {
		ns_basics_template_loader('alert_not_logged_in.php');
    } ?>
</div><!-- end favorites -->