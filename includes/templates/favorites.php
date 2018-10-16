<?php 
//Get global settings
global $current_user, $wp_roles;
$icon_set = esc_attr(get_option('rypecore_icon_set', 'fa'));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

//Get template args
if(isset($template_args)) {
	$show_posts = $template_args['show_posts'];
} 
?>    

<!-- start user dashboard -->
<div class="user-dashboard">
	<?php if(is_user_logged_in()) { ?>
		
		<?php
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
			<?php if(function_exists('rype_basics_show_user_likes_count')) {
			    $show_user_likes_count = rype_basics_show_user_likes_count($current_user); 
			    echo rype_basics_sl_format_count($show_user_likes_count );
			} ?>
			<?php esc_html_e('Favorites', 'rype-basics'); ?>
		</h4>

		<table class="user-dashboard-table favorites-listing">
			<tr class="user-dashboard-table-header favorites-listing-header">
	            <td class="user-dashboard-table-img favorites-listing-img"><?php esc_html_e('Image', 'rype-basics'); ?></td>
	            <td class="favorites-listing-title"><?php esc_html_e('Title', 'rype-basics'); ?></td>
	            <td class="favorites-listing-type"><?php esc_html_e('Post Type', 'rype-basics'); ?></td>
	            <td class="user-dashboard-table-actions favorites-listing-actions"><?php esc_html_e('Actions', 'rype-basics'); ?></td>
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
	        			<a href="<?php the_permalink(); ?>"><?php echo rypecore_get_icon($icon_set, 'eye', 'eye', 'preview'); ?><?php esc_html_e('View', 'rype-basics'); ?></a>
	        			<?php if(function_exists('rype_basics_get_post_likes_button')) { echo rype_basics_get_post_likes_button(get_the_ID()).' Unlike'; } ?>
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
		            'prev_text'    => esc_html__('&raquo; Previous', 'rype-basics'),
		            'next_text'    => esc_html__('Next &raquo;', 'rype-basics'),
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
		        <p><?php esc_html_e('You have not liked any posts yet.', 'rype-basics'); ?></p>
		        <?php wp_reset_postdata(); ?>
		    <?php endif; ?>

		<!-- hook in for Rype Basics -->
        <?php do_action( 'rype_basics_after_favorites'); ?>

	<?php } else {
		rype_basics_template_loader('alert_not_logged_in.php');
    } ?>
</div><!-- end user dashboard -->