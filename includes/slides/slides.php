<?php

    add_action( 'init', 'ns_basics_create_slides_post_type' );
    function ns_basics_create_slides_post_type() {
        register_post_type( 'slides',
            array(
                'labels' => array(
                    'name' => __( 'Slides', 'ns-basics' ),
                    'singular_name' => __( 'Slide', 'ns-basics' ),
                    'add_new_item' => __( 'Add New Slide', 'ns-basics' ),
                    'search_items' => __( 'Search Slides', 'ns-basics' ),
                    'edit_item' => __( 'Edit Slide', 'ns-basics' ),
                ),
            'public' => true,
            'show_in_menu' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page_attributes')
            )
        );
    }

     /* Add sub-text (meta box) */ 
     function ns_basics_add_slide_details_meta_box() {
        add_meta_box( 'slide-meta-box', 'Slide Details', 'ns_basics_slide_details', 'slides', 'normal', 'high' );
     }
    add_action( 'add_meta_boxes', 'ns_basics_add_slide_details_meta_box' );

    function ns_basics_slide_details($post) {
        $slide_values = get_post_custom( $post->ID );
        $slide_text_align = isset( $slide_values['ns_basics_slide_text_align'] ) ? esc_attr( $slide_values['ns_basics_slide_text_align'][0] ) : '';
        $slide_button_link = isset( $slide_values['ns_slide_button_link'] ) ? $slide_values['ns_slide_button_link'][0] : '';
        $slide_button_text = isset( $slide_values['ns_slide_button_text'] ) ? $slide_values['ns_slide_button_text'][0] : __('Contact Us', 'ns-basics');
        $slide_overlay = isset( $slide_values['ns_slide_overlay'] ) ? $slide_values['ns_slide_overlay'][0] : 'true';
        $slide_overlay_opacity = isset( $slide_values['ns_slide_overlay_opacity'] ) ? $slide_values['ns_slide_overlay_opacity'][0] : '0.25';
        $slide_overlay_color = isset( $slide_values['ns_slide_overlay_color'] ) ? $slide_values['ns_slide_overlay_color'][0] : '#000000';

        wp_nonce_field( 'ns_slide_details_meta_box_nonce', 'ns_slide_details_meta_box_nonce' );
        ?>
        
        <div class="meta-box-form meta-box-form-slides">

            <table class="admin-module">
                <tr>
                    <td class="admin-module-label"><label><?php echo esc_html_e('Text Align', 'ns-basics'); ?></label></td>
                    <td class="admin-module-field">
                        <select name="ns_basics_slide_text_align">
                            <option value="left" <?php if($slide_text_align == 'left') { echo 'selected'; } ?>><?php echo esc_html_e('Left', 'ns-basics'); ?></option>
                            <option value="center" <?php if($slide_text_align == 'center') { echo 'selected'; } ?>><?php echo esc_html_e('Center', 'ns-basics'); ?></option>
                            <option value="right" <?php if($slide_text_align == 'right') { echo 'selected'; } ?>><?php echo esc_html_e('Right', 'ns-basics'); ?></option>
                        </select>
                    </td>
                 </tr>
            </table>

            <table class="admin-module">
                <tr>
                    <td class="admin-module-label">
                        <label><?php esc_html_e('Button Link', 'ns-basics'); ?></label>
                        <span class="admin-module-note"><?php esc_html_e('Provide a url for the slide button', 'ns-basics'); ?></span>
                    </td>
                    <td class="admin-module-field">
                        <input type="text" name="ns_slide_button_link" id="slide_button_link" value="<?php echo $slide_button_link; ?>" />
                    </td>
                 </tr>
            </table>

            <table class="admin-module">
                <tr>
                    <td class="admin-module-label">
                        <label><?php esc_html_e('Button Text', 'ns-basics'); ?></label>
                        <span class="admin-module-note"><?php esc_html_e('Provide the text for the slide button (If empty, button will be hidden)', 'ns-basics'); ?></span>
                    </td>
                    <td class="admin-module-field">
                        <input type="text" name="ns_slide_button_text" id="slide_button_text" value="<?php echo $slide_button_text; ?>" />
                    </td>
                 </tr>
            </table>

            <table class="admin-module">
                <tr>
                    <td class="admin-module-label"><label><?php echo esc_html_e('Display Slide Overlay', 'ns-basics'); ?></label></td>
                    <td class="admin-module-field"><input id="slide_overlay" type="checkbox" name="ns_slide_overlay" value="true" <?php if($slide_overlay == 'true') { echo 'checked'; } ?> /></td>
                 </tr>
            </table>

            <table class="admin-module">
                <tr>
                    <td class="admin-module-label">
                        <label><?php esc_html_e('Overlay Opacity', 'ns-basics'); ?></label>
                        <span class="admin-module-note"><?php echo esc_html_e('Choose an opacity ranging from 0 to 1 (0 is fully transparent).', 'ns-basics'); ?></span>
                    </td>
                    <td class="admin-module-field">
                        <input type="number" step="0.01" name="ns_slide_overlay_opacity" id="slide_overlay_opacity" value="<?php echo $slide_overlay_opacity; ?>" />
                    </td>
                 </tr>
            </table>

            <table class="admin-module no-border">
                <tr>
                    <td class="admin-module-label"><label><?php echo esc_html_e('Overlay Color', 'ns-basics'); ?></label></td>
                    <td class="admin-module-field"><input type="text" name="ns_slide_overlay_color" id="slide_overlay_color" class="color-field" data-default-color="#000000" value="<?php echo $slide_overlay_color; ?>" /></td>
                 </tr>
            </table>

        </div>

    <?php }

    /* Save slide */
    add_action( 'save_post', 'ns_basics_save_slide_meta_box' );
    function ns_basics_save_slide_meta_box( $post_id )
    {
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['ns_slide_details_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ns_slide_details_meta_box_nonce'], 'ns_slide_details_meta_box_nonce' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post', $post_id ) ) return;

        // save the data
        $allowed = array(
            'a' => array( // on allow a tags
                'href' => array() // and those anchors can only have href attribute
            ),
            'span' => array(),
            'b' => array()
        );

        // make sure data is set before saving
        if( isset( $_POST['ns_basics_slide_text_align'] ) ) {
            update_post_meta( $post_id, 'ns_basics_slide_text_align', wp_kses( $_POST['ns_basics_slide_text_align'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_slide_text_align', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_slide_button_link'] ) )
            update_post_meta( $post_id, 'ns_slide_button_link', wp_kses( $_POST['ns_slide_button_link'], $allowed ) );

        if( isset( $_POST['ns_slide_button_text'] ) )
            update_post_meta( $post_id, 'ns_slide_button_text', wp_kses( $_POST['ns_slide_button_text'], $allowed ) );

        if( isset( $_POST['ns_slide_overlay'] ) ) {
            update_post_meta( $post_id, 'ns_slide_overlay', wp_kses( $_POST['ns_slide_overlay'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_slide_overlay', wp_kses( '', $allowed ) );
        }
        
        if( isset( $_POST['ns_slide_overlay_opacity'] ) )
            update_post_meta( $post_id, 'ns_slide_overlay_opacity', wp_kses( $_POST['ns_slide_overlay_opacity'], $allowed ) );
        
        if( isset( $_POST['ns_slide_overlay_color'] ) )
            update_post_meta( $post_id, 'ns_slide_overlay_color', wp_kses( $_POST['ns_slide_overlay_color'], $allowed ) );
        }

/*-----------------------------------------------------------------------------------*/
/*  Add Slide Category Taxonomy
/*-----------------------------------------------------------------------------------*/
function ns_basics_slide_category_init() {
    $labels = array(
    'name'                          => __( 'Slide Category', 'ns-basics' ),
    'singular_name'                 => __( 'Slide Category', 'ns-basics' ),
    'search_items'                  => __( 'Search Slide Categories', 'ns-basics' ),
    'popular_items'                 => __( 'Popular Slide Categories', 'ns-basics' ),
    'all_items'                     => __( 'All Slide Categories', 'ns-basics' ),
    'parent_item'                   => __( 'Parent Slide Category', 'ns-basics' ),
    'edit_item'                     => __( 'Edit Slide Category', 'ns-basics' ),
    'update_item'                   => __( 'Update Slide Category', 'ns-basics' ),
    'add_new_item'                  => __( 'Add New Slide Category', 'ns-basics' ),
    'new_item_name'                 => __( 'New Slide Category', 'ns-basics' ),
    'separate_items_with_commas'    => __( 'Separate categories with commas', 'ns-basics' ),
    'add_or_remove_items'           => __( 'Add or remove categories', 'ns-basics' ),
    'choose_from_most_used'         => __( 'Choose from most used categories', 'ns-basics' )
    );
    
    register_taxonomy(
        'slide_category',
        'slides',
        array(
            'label'         => __( 'Slide Category', 'ns-basics' ),
            'labels'        => $labels,
            'hierarchical'  => true,
            'rewrite' => array( 'slug' => 'slide-category' )
        )
    );
}
add_action( 'init', 'ns_basics_slide_category_init' );

?>