<?php
// Exit if accessed directly
if (!defined( 'ABSPATH')) { exit; }

/**
 *	NS_Basics_Post_Likes class
 *
 *  Adds post liking capabilities
 */
class NS_Basics_Post_Likes {

	/**
	 *	Init
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts'));
		add_action( 'wp_ajax_nopriv_process_simple_like', array( $this, 'process_post_like'));
		add_action( 'wp_ajax_process_simple_like', array( $this, 'process_post_like'));
		add_action( 'show_user_profile', array( $this, 'show_user_likes'));
		add_action( 'ns_core_after_post_meta', array( $this, 'add_post_like'));
	}

	/**
	 * Load frontend scripts
	 */
	public function frontend_scripts() {
		wp_enqueue_script( 'ns-basics-post-likes-js', NS_BASICS_PLUGIN_DIR.'/js/post-likes.js', array( 'jquery' ), '0.5', false );
		wp_localize_script( 'ns-basics-post-likes-js', 'simpleLikes', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'like' => esc_html__( 'Like', 'ns-basics' ),
			'unlike' => esc_html__( 'Unlike', 'ns-basics' )
		));
	}

	/**
	 * Process post like
	 */
	public function process_post_like() {
		// Security
		$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
		if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
			exit( esc_html__( 'Not permitted', 'ns-basics' ) );
		}
		// Test if javascript is disabled
		$disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
		// Test if this is a comment
		$is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
		// Base variables
		$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
		$result = array();
		$post_users = NULL;
		$like_count = 0;
		// Get plugin options
		if ( $post_id != '' ) {
			$count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
			$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
			if ( !$this->already_liked( $post_id, $is_comment ) ) { // Like the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id = get_current_user_id();
					$post_users = $this->post_user_likes( $user_id, $post_id, $is_comment );
					if ( $is_comment == 1 ) {
						// Update User & Comment
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						}
					} else {
						// Update User & Post
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						update_user_option( $user_id, "_user_like_count", ++$user_like_count );
						if ( $post_users ) {
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip = $this->get_ip();
					$post_users = $this->post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count = ++$count;
				$response['status'] = "liked";
				$response['icon'] = $this->get_liked_icon();
			} else { // Unlike the post
				if ( is_user_logged_in() ) { // user is logged in
					$user_id = get_current_user_id();
					$post_users = $this->post_user_likes( $user_id, $post_id, $is_comment );
					// Update User
					if ( $is_comment == 1 ) {
						$user_like_count = get_user_option( "_comment_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, "_comment_like_count", --$user_like_count );
						}
					} else {
						$user_like_count = get_user_option( "_user_like_count", $user_id );
						$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
						if ( $user_like_count > 0 ) {
							update_user_option( $user_id, '_user_like_count', --$user_like_count );
						}
					}
					// Update Post
					if ( $post_users ) {	
						$uid_key = array_search( $user_id, $post_users );
						unset( $post_users[$uid_key] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_liked", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_liked", $post_users );
						}
					}
				} else { // user is anonymous
					$user_ip = $this->get_ip();
					$post_users = $this->post_ip_likes( $user_ip, $post_id, $is_comment );
					// Update Post
					if ( $post_users ) {
						$uip_key = array_search( $user_ip, $post_users );
						unset( $post_users[$uip_key] );
						if ( $is_comment == 1 ) {
							update_comment_meta( $post_id, "_user_comment_IP", $post_users );
						} else { 
							update_post_meta( $post_id, "_user_IP", $post_users );
						}
					}
				}
				$like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
				$response['status'] = "unliked";
				$response['icon'] = $this->get_unliked_icon();
			}
			if ( $is_comment == 1 ) {
				update_comment_meta( $post_id, "_comment_like_count", $like_count );
				update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
			} else { 
				update_post_meta( $post_id, "_post_like_count", $like_count );
				update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
			}
			$response['count'] = $this->get_like_count( $like_count );
			$response['testing'] = $is_comment;
			if ( $disabled == true ) {
				if ( $is_comment == 1 ) {
					wp_redirect( get_permalink( get_the_ID() ) );
					exit();
				} else {
					wp_redirect( get_permalink( $post_id ) );
					exit();
				}
			} else {
				wp_send_json( $response );
			}
		}
	}

	/**
	 * Utility to test if the post is already liked
	 *
	 * @param int $post_id
	 * @param boolean $is_comment
	 */
	public function already_liked($post_id, $is_comment ) {
		$post_users = NULL;
		$user_id = NULL;
		if ( is_user_logged_in() ) { // user is logged in
			$user_id = get_current_user_id();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
			if ( count( $post_meta_users ) != 0 ) {
				$post_users = $post_meta_users[0];
			}
		} else { // user is anonymous
			$user_id = $this->get_ip();
			$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" ); 
			if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
				$post_users = $post_meta_users[0];
			}
		}
		if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Utility to test if the post is already liked
	 *
	 * @param int $post_id
	 * @param boolean $is_comment
	 * @param boolean $button
	 * @param string $button_text
	 */
	public function get_post_likes_button($post_id, $is_comment = NULL, $button = NULL, $button_text = NULL) {
		$is_comment = ( NULL == $is_comment ) ? 0 : 1;
		$output = '';
		$nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
		if ( $is_comment == 1 ) {
			$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
			$comment_class = esc_attr( ' sl-comment' );
			$like_count = get_comment_meta( $post_id, "_comment_like_count", true );
			$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		} else {
			$post_id_class = esc_attr( ' sl-button-' . $post_id );
			$comment_class = esc_attr( '' );
			$like_count = get_post_meta( $post_id, "_post_like_count", true );
			$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
		}
		$count = $this->get_like_count( $like_count );

	    $icon_empty = $this->get_unliked_icon($button_text);
	    $icon_full = $this->get_liked_icon($button_text);

		// Loader
		$loader = '<span class="sl-loader"></span>';
		// Liked/Unliked Variables
		if ( $this->already_liked( $post_id, $is_comment ) ) {
			$class = esc_attr( ' liked' );
			$title = esc_html__( 'Unlike', 'ns-basics' );
			$icon = $icon_full;
		} else {
			$class = '';
			$title = esc_html__( 'Like', 'ns-basics' );
			$icon = $icon_empty;
		}

	    if($button == 'true') {
	        $output = '<div class="sl-wrapper sl-wrapper-button ns-tooltip"><a href="' . admin_url( 'admin-ajax.php?action=ns_basics_process_post_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true&button=true' ) . '" class="button small outline sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count .'</a>' .$loader . '</div>';
	    } else {
	        $output = '<div class="sl-wrapper ns-tooltip"><a href="'.admin_url( 'admin-ajax.php?action=ns_basics_process_post_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button ns-tooltip-toggle' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</div>';
	    }
		return $output;
	}

	/**
	 * Utility retrieves post meta user likes (user id array), then adds new user id to retrieved array
	 *
	 * @param int $user_id
	 * @param int $post_id
	 * @param boolean $is_comment
	 */
	public function post_user_likes($user_id, $post_id, $is_comment) {
		$post_users = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_id, $post_users ) ) {
			$post_users['user-' . $user_id] = $user_id;
		}
		return $post_users;
	}

	/**
	 * Utility retrieves post meta ip likes (ip array), then adds new ip to retrieved array
	 *
	 * @param int $user_ip
	 * @param int $post_id
	 * @param boolean $is_comment
	 */
	public function post_ip_likes($user_ip, $post_id, $is_comment) {
		$post_users = '';
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
		// Retrieve post information
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_ip, $post_users ) ) {
			$post_users['ip-' . $user_ip] = $user_ip;
		}
		return $post_users;
	}

	/**
	 * Utility to retrieve IP address
	 */
	public function get_ip() {
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		}
		$ip = filter_var( $ip, FILTER_VALIDATE_IP );
		$ip = ( $ip === false ) ? '0.0.0.0' : $ip;
		return $ip;
	}

	/**
	 * Utility returns the button icon for "like" action
	 *
	 * @param string $button_text
	 */
	public function get_liked_icon($button_text = null) {
		if(empty($button_text)) { $button_text = esc_html__( 'Unlike', 'ns-basics' ); }
		$icon = '<span class="fa fa-heart sl-icon icon"></span>'.'<span class="sl-button-text">'.$button_text.'</span>';
		return $icon;
	}

	/**
	 * Utility returns the button icon for "unlike" action
	 *
	 * @param string $button_text
	 */
	public function get_unliked_icon($button_text = null) {
		if(empty($button_text)) { $button_text = esc_html__( 'Like', 'ns-basics' ); }
		$icon = '<span class="fa fa-heart sl-icon icon"></span>'.'<span class="sl-button-text">'.$button_text.'</span>';
		return $icon;
	}

	/**
	 * Utility to format the like count
	 *
	 * @param int $number
	 */
	public function format_count($number) {
		$precision = 2;
		if ( $number >= 1000 && $number < 1000000 ) {
			$formatted = number_format( $number/1000, $precision ).'K';
		} else if ( $number >= 1000000 && $number < 1000000000 ) {
			$formatted = number_format( $number/1000000, $precision ).'M';
		} else if ( $number >= 1000000000 ) {
			$formatted = number_format( $number/1000000000, $precision ).'B';
		} else {
			$formatted = $number; // Number is less than 1000
		}
		$formatted = str_replace( '.00', '', $formatted );
		return $formatted;
	}

	/**
	 * Utility retrieves like count
	 *
	 * @param int $like_count
	 */
	public function get_like_count($like_count) {
		$like_text = esc_html__( 'Like', 'ns-basics' );
		if ( is_numeric( $like_count ) && $like_count > 0 ) { 
			$number = $this->format_count( $like_count );
		} else {
			$number = $like_text;
		}
		$count = '<div class="sl-count ns-tooltip-content"><div class="ns-tooltip-content-inner">' . $number . '</div></div>';
		return $count;
	}

	/**
	 * User Profile List
	 *
	 * @param object $user
	 */
	public function show_user_likes($user) { ?>
		<table class="form-table">
			<tr>
				<th><label for="user_likes"><?php esc_html_e( 'You Like:', 'ns-basics' ); ?></label></th>
				<td>
				<?php
				$types = get_post_types( array( 'public' => true ) );
				$args = array(
				  'numberposts' => -1,
				  'post_type' => $types,
				  'meta_query' => array (
					array (
					  'key' => '_user_liked',
					  'value' => $user->ID,
					  'compare' => 'LIKE'
					)
				  ) );		
				$sep = '';
				$like_query = new WP_Query( $args );
				if ( $like_query->have_posts() ) : ?>
				<p>
				<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
				echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				<?php
				$sep = ' &middot; ';
				endwhile; 
				?>
				</p>
				<?php else : ?>
				<p><?php esc_html_e( 'You do not like anything yet.', 'ns-basics' ); ?></p>
				<?php 
				endif; 
				wp_reset_postdata(); 
				?>
				</td>
			</tr>
		</table>
	<?php }

	/**
	 * Get User Like Count
	 *
	 * @param object $user
	 */
	public function show_user_likes_count($user) {
		$types = get_post_types( array( 'public' => true ) );
	    $args = array(
	        'numberposts' => -1,
	        'showposts' => -1,
	        'post_type' => $types,
	        'meta_query' => array (
	            array (
	                'key' => '_user_liked',
	                'value' => $user->ID,
	                'compare' => 'LIKE'
	            )
	        ) 
	    );     
	    $like_query = new WP_Query( $args ); 
	            
	    $count = $like_query->post_count;
	    return $count;
	}

	/**
	 * Add post like to template
	 */
	public function add_post_like() {
		echo '<li>'.$this->get_post_likes_button(get_the_ID(), null, true).'</li>';
	}

}

?>