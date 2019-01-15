<?php
    function ns_basics_add_page_layout_meta_box() {
        $post_types = array('page');
        add_meta_box( 'page-layout-meta-box', 'Page Settings', 'ns_basics_page_layout_meta_box', $post_types, 'normal', 'low' );
    }
    add_action( 'add_meta_boxes', 'ns_basics_add_page_layout_meta_box' );

    function ns_basics_page_layout_meta_box($post) {

        //global banner values
        $page_banner_bg = esc_attr(get_option('ns_core_page_banner_bg'));
        $page_banner_bg_display = esc_attr(get_option('ns_core_page_banner_bg_display'));
        $page_banner_title_align = esc_attr(get_option('ns_core_page_banner_title_align'));
        $page_banner_padding_top = esc_attr(get_option('ns_core_page_banner_padding_top'));
        $page_banner_padding_bottom = esc_attr(get_option('ns_core_page_banner_padding_bottom'));
        $page_banner_overlay = esc_attr(get_option('ns_core_page_banner_overlay_display'));
        $page_banner_overlay_opacity = esc_attr(get_option('ns_core_page_banner_overlay_opacity', '0.25'));
        $page_banner_overlay_color = esc_attr(get_option('ns_core_page_banner_overlay_color', '#000000'));
        $page_banner_display_breadcrumb = esc_attr(get_option('ns_core_page_banner_display_breadcrumb'));
        $page_banner_display_search = esc_attr(get_option('ns_core_page_banner_display_search'));

        //banner values
        $values = get_post_custom( $post->ID );
        $banner_display = isset( $values['ns_basics_banner_display'] ) ? esc_attr( $values['ns_basics_banner_display'][0] ) : 'true';
        $banner_source = isset( $values['ns_basics_banner_source'] ) ? esc_attr( $values['ns_basics_banner_source'][0] ) : 'image_banner';
        $banner_title = isset( $values['ns_basics_banner_title'] ) ? esc_attr( $values['ns_basics_banner_title'][0] ) : '';
        $banner_text = isset( $values['ns_basics_banner_text'] ) ? esc_attr( $values['ns_basics_banner_text'][0] ) : '';
        $banner_custom_settings = isset( $values['ns_basics_banner_custom_settings'] ) ? esc_attr( $values['ns_basics_banner_custom_settings'][0] ) : '';
        $banner_bg_img = isset( $values['ns_basics_banner_bg_img'] ) ? esc_attr( $values['ns_basics_banner_bg_img'][0] ) : $page_banner_bg;
        $banner_bg_display = isset( $values['ns_basics_banner_bg_display'] ) ? esc_attr( $values['ns_basics_banner_bg_display'][0] ) : $page_banner_bg_display;
        $banner_text_align = isset( $values['ns_basics_banner_text_align'] ) ? esc_attr( $values['ns_basics_banner_text_align'][0] ) : $page_banner_title_align;
        $banner_padding_top = isset( $values['ns_basics_banner_padding_top'] ) ? esc_attr( $values['ns_basics_banner_padding_top'][0] ) : $page_banner_padding_top;
        $banner_padding_bottom = isset( $values['ns_basics_banner_padding_bottom'] ) ? esc_attr( $values['ns_basics_banner_padding_bottom'][0] ) : $page_banner_padding_bottom;
        $banner_overlay = isset( $values['ns_basics_banner_overlay'] ) ? esc_attr( $values['ns_basics_banner_overlay'][0] ) : $page_banner_overlay;
        $banner_overlay_opacity = isset( $values['ns_basics_banner_overlay_opacity'] ) ? esc_attr( $values['ns_basics_banner_overlay_opacity'][0] ) : $page_banner_overlay_opacity;
        $banner_overlay_color = isset( $values['ns_basics_banner_overlay_color'] ) ? esc_attr( $values['ns_basics_banner_overlay_color'][0] ) : $page_banner_overlay_color;
        $banner_breadcrumbs = isset( $values['ns_basics_banner_breadcrumbs'] ) ? esc_attr( $values['ns_basics_banner_breadcrumbs'][0] ) : $page_banner_display_breadcrumb;
        $banner_search = isset( $values['ns_basics_banner_search'] ) ? esc_attr( $values['ns_basics_banner_search'][0] ) : $page_banner_display_search;

        //banner slider values
        $banner_slider_cat = isset( $values['ns_basics_banner_slider_cat'] ) ? esc_attr( $values['ns_basics_banner_slider_cat'][0] ) : '';
        $banner_slider_layout = isset( $values['ns_basics_banner_slider_layout'] ) ? esc_attr( $values['ns_basics_banner_slider_layout'][0] ) : 'minimal';
        $banner_slider_num = isset( $values['ns_basics_banner_slider_num'] ) ? esc_attr( $values['ns_basics_banner_slider_num'][0] ) : '3';
        $banner_shortcode = isset( $values['ns_basics_banner_shortcode'] ) ? esc_attr( $values['ns_basics_banner_shortcode'][0] ) : '';

        //cta values
        $cta_display = isset( $values['ns_basics_cta_display'] ) ? esc_attr( $values['ns_basics_cta_display'][0] ) : '';
        $cta_title = isset( $values['ns_basics_cta_title'] ) ? esc_attr( $values['ns_basics_cta_title'][0] ) : '';
        $cta_text = isset( $values['ns_basics_cta_text'] ) ? esc_attr( $values['ns_basics_cta_text'][0] ) : '';
        $cta_button_text = isset( $values['ns_basics_cta_button_text'] ) ? esc_attr( $values['ns_basics_cta_button_text'][0] ) : '';
        $cta_button_url = isset( $values['ns_basics_cta_button_url'] ) ? esc_attr( $values['ns_basics_cta_button_url'][0] ) : '';
        $cta_bg_img = isset( $values['ns_basics_cta_bg_img'] ) ? esc_attr( $values['ns_basics_cta_bg_img'][0] ) : '';
        $cta_bg_display = isset( $values['ns_basics_cta_bg_display'] ) ? esc_attr( $values['ns_basics_cta_bg_display'][0] ) : '';

        //page layout values
        $page_layout_default = 'full';
        $page_layout_widget_area_default = 'Page_sidebar';
        $page_layout = isset( $values['ns_basics_page_layout'] ) ? esc_attr( $values['ns_basics_page_layout'][0] ) : $page_layout_default;
        $page_layout_widget_area = isset( $values['ns_basics_page_layout_widget_area'] ) ? esc_attr( $values['ns_basics_page_layout_widget_area'][0] ) : $page_layout_widget_area_default;
        $page_layout_container = isset( $values['ns_basics_page_layout_container'] ) ? esc_attr( $values['ns_basics_page_layout_container'][0] ) : 'true';
        wp_nonce_field( 'ns_basics_page_layout_meta_box_nonce', 'ns_basics_page_layout_meta_box_nonce' );
        ?>
        
        <div id="accordion" class="accordion ns-accordion hide">
            <h3 class="accordion-tab"><i class="fa fa-chevron-right icon"></i> <?php echo esc_html_e('Banner', 'ns-basics'); ?></h3>
            <div>
                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Display Banner', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input id="banner_display" type="checkbox" name="ns_basics_banner_display" value="true" <?php if($banner_display == 'true') { echo 'checked'; } ?> /></td>
                     </tr>
                </table>

                <div class="admin-module no-border">
                    <label class="selectable-item <?php if($banner_source == 'image_banner') { echo 'active'; } ?>" for="banner_source_image_banner">
                        <img src="<?php echo plugins_url('/ns-basics/images/default-banner-icon.png'); ?>" alt="" /><br/>
                        <input type="radio" id="banner_source_image_banner" name="ns_basics_banner_source" value="image_banner" <?php checked('image_banner', $banner_source, true) ?> /><?php esc_html_e('Default Banner', 'ns-basics'); ?><br/>   
                    </label>
                    <label class="selectable-item <?php if($banner_source == 'slides') { echo 'active'; } ?>" for="banner_source_slides">
                        <img src="<?php echo plugins_url('/ns-basics/images/slider-icon.png'); ?>" alt="" /><br/>
                        <input type="radio" id="banner_source_slides" name="ns_basics_banner_source" value="slides" <?php checked('slides', $banner_source, true) ?> /> <?php echo wp_kses_post(__('Slider from <b><i>slides</i></b> custom post type', 'ns-basics')); ?><br/>
                    </label>
                    <label class="selectable-item <?php if($banner_source == 'shortcode') { echo 'active'; } ?>" for="banner_source_shortcode">
                        <img src="<?php echo plugins_url('/ns-basics/images/slider-revolution-icon.png'); ?>" alt="" /><br/>
                        <input type="radio" id="banner_source_shortcode" name="ns_basics_banner_source" value="shortcode" <?php checked('shortcode', $banner_source, true) ?> /> <?php esc_html_e('Shortcode', 'ns-basics'); ?><br/>
                    </label>

                    <!-- hook in for other add-ons -->
                    <?php do_action( 'ns_basics_before_page_banner_options', $values); ?>

                    <div id="selectable-item-options-image_banner" class="selectable-item-settings <?php if($banner_source == 'image_banner') { echo 'show'; } else { echo 'hide-soft'; } ?>">
                        <h4><?php echo esc_html_e('Banner Settings', 'ns-basics'); ?></h4>

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label"><label><?php echo esc_html_e('Banner Title', 'ns-basics'); ?></label></td>
                                <td class="admin-module-field"><input type="text" name="ns_basics_banner_title" value="<?php echo esc_attr($banner_title); ?>" /></td>
                             </tr>
                        </table>    

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label"><label><?php echo esc_html_e('Banner Text', 'ns-basics'); ?></label></td>
                                <td class="admin-module-field"><input type="text" name="ns_basics_banner_text" value="<?php echo esc_attr($banner_text); ?>" /></td>
                             </tr>
                        </table> 

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label">
                                    <label><?php echo esc_html_e('Use Custom Banner Settings', 'ns-basics'); ?></label>
                                    <span class="admin-module-note"><?php echo esc_html_e('The banner global settings are configured in the theme options (Appearance > Theme Options)', 'ns-basics'); ?></span>
                                </td>
                                <td class="admin-module-field">
                                    <div class="toggle-switch" title="<?php if($banner_custom_settings == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                                        <input type="checkbox" name="ns_basics_banner_custom_settings" value="true" class="toggle-switch-checkbox" id="page_banner_custom_settings" <?php checked('true', $banner_custom_settings, true) ?>>
                                        <label class="toggle-switch-label" data-settings="banner-custom-settings" for="page_banner_custom_settings"><?php if($banner_custom_settings == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                                    </div>
                                </td>
                             </tr>
                        </table>

                        <div class="admin-module no-padding banner-custom-settings <?php if($banner_custom_settings) { echo 'show'; } else { echo 'hide-soft'; } ?>">
                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Banner Background Image', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <input type="text" id="banner_bg_img" name="ns_basics_banner_bg_img" value="<?php echo esc_attr($banner_bg_img); ?>" />
                                        <input id="_btn" class="ns_upload_image_button" type="button" value="<?php esc_html_e('Upload Image', 'ns-basics'); ?>" />
                                    </td>
                                 </tr>
                            </table>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Banner Background Display', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <select name="ns_basics_banner_bg_display">
                                            <option value="cover" <?php if($banner_bg_display == 'cover') { echo 'selected'; } ?>><?php echo esc_html_e('Cover', 'ns-basics'); ?></option>
                                            <option value="fixed" <?php if($banner_bg_display == 'fixed') { echo 'selected'; } ?>><?php echo esc_html_e('Fixed', 'ns-basics'); ?></option>
                                            <option value="repeat" <?php if($banner_bg_display == 'repeat') { echo 'selected'; } ?>><?php echo esc_html_e('Tiled', 'ns-basics'); ?></option>
                                        </select>
                                    </td>
                                 </tr>
                            </table> 

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Text Alignment', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <select name="ns_basics_banner_text_align">
                                            <option value="left" <?php if($banner_text_align == 'left') { echo 'selected'; } ?>><?php echo esc_html_e('Left', 'ns-basics'); ?></option>
                                            <option value="center" <?php if($banner_text_align == 'center') { echo 'selected'; } ?>><?php echo esc_html_e('Center', 'ns-basics'); ?></option>
                                            <option value="right" <?php if($banner_text_align == 'right') { echo 'selected'; } ?>><?php echo esc_html_e('Right', 'ns-basics'); ?></option>
                                        </select>
                                    </td>
                                 </tr>
                            </table>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Banner Padding Top', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <input type="number" name="ns_basics_banner_padding_top" id="banner_padding_top" value="<?php echo $banner_padding_top; ?>" />
                                        <?php echo esc_html_e('Pixels', 'ns-basics'); ?>
                                    </td>
                                 </tr>
                            </table>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Banner Padding Bottom', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <input type="number" name="ns_basics_banner_padding_bottom" id="banner_padding_bottom" value="<?php echo $banner_padding_bottom; ?>" />
                                        <?php echo esc_html_e('Pixels', 'ns-basics'); ?>
                                    </td>
                                 </tr>
                            </table>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Display Banner Overlay', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <div class="toggle-switch" title="<?php if($banner_overlay == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                                            <input type="checkbox" name="ns_basics_banner_overlay" value="true" class="toggle-switch-checkbox" id="page_banner_overlay_display" <?php checked('true', $banner_overlay, true) ?>>
                                            <label class="toggle-switch-label" data-settings="banner-overlay-settings" for="page_banner_overlay_display"><?php if($banner_overlay == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                                        </div>
                                    </td>
                                 </tr>
                            </table>

                            <div class="admin-module no-padding banner-overlay-settings <?php if($banner_overlay == 'true') { echo 'show'; } else { echo 'hide-soft'; } ?>">
                                <table class="admin-module">
                                    <tr>
                                        <td class="admin-module-label">
                                            <label><?php esc_html_e('Banner Overlay Opacity', 'ns-basics'); ?></label>
                                            <span class="admin-module-note"><?php echo esc_html_e('Choose an opacity ranging from 0 to 1 (0 is fully transparent).', 'ns-basics'); ?></span>
                                        </td>
                                        <td class="admin-module-field">
                                            <input type="number" step="0.01" min="0.00" max="1.00" name="ns_basics_banner_overlay_opacity" id="banner_overlay_opacity" value="<?php echo $banner_overlay_opacity; ?>" />
                                        </td>
                                     </tr>
                                </table>

                                <table class="admin-module">
                                    <tr>
                                        <td class="admin-module-label"><label><?php echo esc_html_e('Banner Overlay Color', 'ns-basics'); ?></label></td>
                                        <td class="admin-module-field">
                                            <input type="text" name="ns_basics_banner_overlay_color" id="banner_overlay_color" class="color-field" data-default-color="#000000" value="<?php echo $banner_overlay_color; ?>" />
                                        </td>
                                     </tr>
                                </table>
                            </div>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Display Breadcrumbs', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <div class="toggle-switch" title="<?php if($banner_breadcrumbs == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                                            <input type="checkbox" name="ns_basics_banner_breadcrumbs" value="true" class="toggle-switch-checkbox" id="page_banner_breadcrumbs" <?php checked('true', $banner_breadcrumbs, true) ?>>
                                            <label class="toggle-switch-label" for="page_banner_breadcrumbs"><?php if($banner_breadcrumbs == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                                        </div>
                                    </td>
                                 </tr>
                            </table>

                            <table class="admin-module">
                                <tr>
                                    <td class="admin-module-label"><label><?php echo esc_html_e('Display Search Form', 'ns-basics'); ?></label></td>
                                    <td class="admin-module-field">
                                        <div class="toggle-switch" title="<?php if($banner_search == 'true') { esc_html_e('Active', 'ns-basics'); } else { esc_html_e('Disabled', 'ns-basics'); } ?>">
                                            <input type="checkbox" name="ns_basics_banner_search" value="true" class="toggle-switch-checkbox" id="page_banner_search" <?php checked('true', $banner_search, true) ?>>
                                            <label class="toggle-switch-label" for="page_banner_search"><?php if($banner_search == 'true') { echo '<span class="on">'.esc_html__('On', 'ns-basics').'</span>'; } else { echo '<span>'.esc_html__('Off', 'ns-basics').'</span>'; } ?></label>
                                        </div>
                                    </td>
                                 </tr>
                            </table>
                        </div><!-- end custom settings -->

                        <!-- hook in for other add-ons -->
                        <?php do_action( 'ns_basics_after_page_banner_options', $values); ?>
                    </div>

                    <div id="selectable-item-options-slides" class="selectable-item-settings <?php if($banner_source == 'slides') { echo 'show'; } else { echo 'hide-soft'; } ?>">
                        <h4><?php echo esc_html_e('Slider Settings', 'ns-basics'); ?></h4>
                        <p class="admin-module-note">Use the <a href="<?php echo admin_url(); ?>/edit.php?post_type=slides" target="_blank">slides</a> post type add, edit, or delete slides.</p>

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label"><label><?php echo esc_html_e('Display Slides from Category', 'ns-basics'); ?></label></td>
                                <td class="admin-module-field">
                                    <select name="ns_basics_banner_slider_cat">
                                        <option value=""><?php _e( 'All Categories', 'ns-basics' ); ?></option>
                                        <?php
                                        $slide_cats = get_terms('slide_category', array( 'hide_empty' => false, 'parent' => 0 )); 
                                        if (!empty( $slide_cats ) && !is_wp_error($slide_cats)) { ?>
                                            <?php foreach($slide_cats as $slide_cat) { ?>
                                                <option value="<?php echo esc_attr($slide_cat->slug); ?>" <?php if($slide_cat->slug == $banner_slider_cat) { echo 'selected'; } ?>><?php echo esc_attr($slide_cat->name); ?></option>
                                                <?php 
                                                $term_children = get_term_children($slide_cat->term_id, 'slide_category'); 
                                                if(!empty($term_children)) {
                                                    echo '<optgroup label="'.$slide_cat->name.'">';
                                                    foreach ( $term_children as $child ) {
                                                        $term = get_term_by( 'id', $child, 'slide_category' );
                                                        if($term->slug == $banner_slider_cat) { $term_selected = 'selected'; } else { $term_selected = ''; }
                                                        echo '<option value="'.$term->slug.'" '.$term_selected.'>'.$term->name.'</option>';
                                                    }
                                                    echo '</optgroup>';
                                                } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                             </tr>
                        </table>

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label"><label><?php echo esc_html_e('Slider Layout', 'ns-basics'); ?></label></td>
                                <td class="admin-module-field">
                                    <select name="ns_basics_banner_slider_layout">
                                        <option value="minimal" <?php if(esc_attr($banner_slider_layout) == 'minimal') { echo 'selected'; } ?>><?php echo esc_html_e('Minimal', 'ns-basics'); ?></option>
                                        <option value="detailed" <?php if(esc_attr($banner_slider_layout) == 'detailed') { echo 'selected'; } ?>><?php echo esc_html_e('Detailed', 'ns-basics'); ?></option>
                                    </select>
                                </td>
                             </tr>
                        </table>

                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label"><label><?php echo esc_html_e('Number of Slides', 'ns-basics'); ?></label></td>
                                <td class="admin-module-field"><input type="number" id="banner_slider_num" name="ns_basics_banner_slider_num" value="<?php echo $banner_slider_num; ?>" /></td>
                             </tr>
                        </table>
                    </div>

                    <div id="selectable-item-options-shortcode" class="selectable-item-settings <?php if($banner_source == 'shortcode') { echo 'show'; } else { echo 'hide-soft'; } ?>">
                        <h4><?php echo esc_html_e('Shortcode Settings', 'ns-basics'); ?></h4>
                        <table class="admin-module">
                            <tr>
                                <td class="admin-module-label">
                                    <label><?php echo esc_html_e('Shortcode', 'ns-basics'); ?></label>
                                    <span class="admin-module-note"><?php echo esc_html_e('Copy and paste your shortcode to display content from other sources, such as a slider revolution.', 'ns-basics'); ?></span>
                                </td>
                                <td class="admin-module-field"><input type="text" id="banner_shortcode" name="ns_basics_banner_shortcode" value="<?php echo $banner_shortcode; ?>" /></td>
                             </tr>
                        </table>
                    </div>
                </div><!-- end admin module -->

                <!-- hook in for other add-ons -->
                <?php do_action( 'ns_basics_banner_options_end', $values); ?>

            </div><!-- end banner tab -->
            
            <h3 class="accordion-tab"><i class="fa fa-chevron-right icon"></i> <?php echo esc_html_e('Page Layout', 'ns-basics'); ?></h3>
            <div>

                <?php do_action( 'ns_basics_before_page_layout_options', $values); ?>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Page Layout', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field">
                            <table class="left right-bump">
                            <tr>
                            <td><input type="radio" name="ns_basics_page_layout" id="page_layout_full" value="full" <?php if($page_layout == 'full') { echo 'checked="checked"'; } ?> /></td>
                            <td><img class="sidebar-icon" src="<?php echo plugins_url('../../images/full-width-icon.png', __FILE__); ?>" alt="" /></td>
                            </tr>
                            <tr>
                            <td></td>
                            <td><?php echo esc_html_e('Full Width', 'ns-basics'); ?></td>
                            </tr>
                            </table>

                            <table class="left">
                            <tr>
                            <td><input type="radio" name="ns_basics_page_layout" id="page_layout_right_sidebar" value="right sidebar" <?php if($page_layout == 'right sidebar') { echo 'checked="checked"'; } ?> /></td>
                            <td><img class="sidebar-icon" src="<?php echo plugins_url('../../images/right-sidebar-icon.png', __FILE__); ?>" alt="" /></td>
                            </tr>
                            <tr>
                            <td></td>
                            <td><?php echo esc_html_e('Right Sidebar', 'ns-basics'); ?></td>
                            </tr>
                            </table>

                            <table class="left">
                            <tr>
                            <td><input type="radio" name="ns_basics_page_layout" id="page_layout_left_sidebar" value="left sidebar" <?php if($page_layout == 'left sidebar') { echo 'checked="checked"'; } ?> /></td>
                            <td><img class="sidebar-icon" src="<?php echo plugins_url('../../images/left-sidebar-icon.png', __FILE__); ?>" alt="" /></td>
                            </tr>
                            <tr>
                            <td></td>
                            <td><?php echo esc_html_e('Left Sidebar', 'ns-basics'); ?></td>
                            </tr>
                            </table>
                            <div class="clear"></div>
                        </td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Use Page Container', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input id="page_layout_container" type="checkbox" name="ns_basics_page_layout_container" value="true" <?php if($page_layout_container == 'true') { echo 'checked'; } ?> /></td>
                    </tr>
                </table>

                <table class="admin-module no-border">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Sidebar Widget Area', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field">
                            <select name="ns_basics_page_layout_widget_area" id="page_layout_widget_area">
                                <?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
                                     <option value="<?php echo ucwords( $sidebar['id'] ); ?>" <?php if($page_layout_widget_area == ucwords( $sidebar['id'] )) { echo 'selected'; } ?>>
                                              <?php echo ucwords( $sidebar['name'] ); ?>
                                     </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <?php do_action( 'ns_basics_after_page_layout_options', $values); ?>

            </div><!-- page layout tab -->

            <h3 class="accordion-tab"><i class="fa fa-chevron-right icon"></i> <?php echo esc_html_e('Call to Action', 'ns-basics'); ?></h3>
            <div>

                <?php do_action( 'ns_basics_before_page_cta_options', $values); ?>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Display Call to Action', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input id="cta_display" type="checkbox" name="ns_basics_cta_display" value="true" <?php if($cta_display == 'true') { echo 'checked'; } ?> /></td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Title', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input type="text" name="ns_basics_cta_title" value="<?php echo esc_attr($cta_title); ?>" /></td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Text', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input type="text" name="ns_basics_cta_text" value="<?php echo esc_attr($cta_text); ?>" /></td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Button Text', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input type="text" name="ns_basics_cta_button_text" value="<?php echo esc_attr($cta_button_text); ?>" /></td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Button Url', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field"><input type="text" name="ns_basics_cta_button_url" value="<?php echo esc_url($cta_button_url); ?>" /></td>
                    </tr>
                </table>

                <table class="admin-module">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Background Image', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field">
                            <input type="text" id="cta_bg_img" name="ns_basics_cta_bg_img" value="<?php echo esc_attr($cta_bg_img); ?>" />
                            <input id="_btn" class="ns_upload_image_button" type="button" value="<?php esc_html_e('Upload Image', 'ns-basics'); ?>" />
                        </td>
                    </tr>
                </table>

                <table class="admin-module no-border">
                    <tr>
                        <td class="admin-module-label"><label><?php echo esc_html_e('Call to Action Background Display', 'ns-basics'); ?></label></td>
                        <td class="admin-module-field">
                            <select name="ns_basics_cta_bg_display">
                                <option value="cover" <?php if($cta_bg_display == 'cover') { echo 'selected'; } ?>><?php echo esc_html_e('Cover', 'ns-basics'); ?></option>
                                <option value="fixed" <?php if($cta_bg_display == 'fixed') { echo 'selected'; } ?>><?php echo esc_html_e('Fixed', 'ns-basics'); ?></option>
                                <option value="repeat" <?php if($cta_bg_display == 'repeat') { echo 'selected'; } ?>><?php echo esc_html_e('Tiled', 'ns-basics'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>

                <?php do_action( 'ns_basics_after_page_cta_options', $values); ?>

            </div><!-- end cta tab -->
        </div><!-- end accordion -->

    <?php } 

    /* Save banner form */
    add_action( 'save_post', 'ns_basics_save_page_layout_meta_box' );
    function ns_basics_save_page_layout_meta_box( $post_id )
    {
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['ns_basics_page_layout_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ns_basics_page_layout_meta_box_nonce'], 'ns_basics_page_layout_meta_box_nonce' ) ) return;

        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post', $post_id ) ) return;

        // save the data
        $allowed = array(
            'a' => array( // on allow a tags
                'href' => array() // and those anchors can only have href attribute
            ),
            'b' => array(),
            'strong' => array(),
            'i' => array()
        );
         
        // make sure data is set before saving
        if( isset( $_POST['ns_basics_banner_display'] ) ) {
            update_post_meta( $post_id, 'ns_basics_banner_display', wp_kses( $_POST['ns_basics_banner_display'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_banner_display', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_basics_banner_source'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_source', wp_kses( $_POST['ns_basics_banner_source'], $allowed ) );
            
        if( isset( $_POST['ns_basics_banner_title'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_title', wp_kses( $_POST['ns_basics_banner_title'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_text'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_text', wp_kses( $_POST['ns_basics_banner_text'], $allowed ) );
            
        if( isset( $_POST['ns_basics_banner_custom_settings'] ) ) {
            update_post_meta( $post_id, 'ns_basics_banner_custom_settings', wp_kses( $_POST['ns_basics_banner_custom_settings'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_banner_custom_settings', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_basics_banner_bg_img'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_bg_img', wp_kses( $_POST['ns_basics_banner_bg_img'], $allowed ) );
            
        if( isset( $_POST['ns_basics_banner_bg_display'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_bg_display', wp_kses( $_POST['ns_basics_banner_bg_display'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_overlay'] ) ) {
            update_post_meta( $post_id, 'ns_basics_banner_overlay', wp_kses( $_POST['ns_basics_banner_overlay'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_banner_overlay', wp_kses( '', $allowed ) );
        }
        
        if( isset( $_POST['ns_basics_banner_overlay_opacity'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_overlay_opacity', wp_kses( $_POST['ns_basics_banner_overlay_opacity'], $allowed ) );
            
        if( isset( $_POST['ns_basics_banner_overlay_color'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_overlay_color', wp_kses( $_POST['ns_basics_banner_overlay_color'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_text_align'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_text_align', wp_kses( $_POST['ns_basics_banner_text_align'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_padding_top'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_padding_top', wp_kses( $_POST['ns_basics_banner_padding_top'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_padding_bottom'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_padding_bottom', wp_kses( $_POST['ns_basics_banner_padding_bottom'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_breadcrumbs'] ) ) {
            update_post_meta( $post_id, 'ns_basics_banner_breadcrumbs', wp_kses( $_POST['ns_basics_banner_breadcrumbs'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_banner_breadcrumbs', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_basics_banner_search'] ) ) {
            update_post_meta( $post_id, 'ns_basics_banner_search', wp_kses( $_POST['ns_basics_banner_search'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_banner_search', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_basics_banner_slider_cat'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_slider_cat', wp_kses( $_POST['ns_basics_banner_slider_cat'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_slider_layout'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_slider_layout', wp_kses( $_POST['ns_basics_banner_slider_layout'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_slider_num'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_slider_num', wp_kses( $_POST['ns_basics_banner_slider_num'], $allowed ) );

        if( isset( $_POST['ns_basics_banner_shortcode'] ) )
            update_post_meta( $post_id, 'ns_basics_banner_shortcode', wp_kses( $_POST['ns_basics_banner_shortcode'], $allowed ) );

        if( isset( $_POST['ns_basics_page_layout'] ) )
            update_post_meta( $post_id, 'ns_basics_page_layout', wp_kses( $_POST['ns_basics_page_layout'], $allowed ) );

        if( isset( $_POST['ns_basics_page_layout_container'] ) ) {
            update_post_meta( $post_id, 'ns_basics_page_layout_container', wp_kses( $_POST['ns_basics_page_layout_container'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_page_layout_container', wp_kses( '', $allowed ) );
        }

        if( isset( $_POST['ns_basics_page_layout_widget_area'] ) )
            update_post_meta( $post_id, 'ns_basics_page_layout_widget_area', wp_kses( $_POST['ns_basics_page_layout_widget_area'], $allowed ) );

        if( isset( $_POST['ns_basics_cta_display'] ) ) {
            update_post_meta( $post_id, 'ns_basics_cta_display', wp_kses( $_POST['ns_basics_cta_display'], $allowed ) );
        } else {
            update_post_meta( $post_id, 'ns_basics_cta_display', wp_kses( '', $allowed ) );
        }
            
        if( isset( $_POST['ns_basics_cta_title'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_title', wp_kses( $_POST['ns_basics_cta_title'], $allowed ) );

        if( isset( $_POST['ns_basics_cta_text'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_text', wp_kses( $_POST['ns_basics_cta_text'], $allowed ) );

        if( isset( $_POST['ns_basics_cta_button_text'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_button_text', wp_kses( $_POST['ns_basics_cta_button_text'], $allowed ) );

        if( isset( $_POST['ns_basics_cta_button_url'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_button_url', wp_kses( $_POST['ns_basics_cta_button_url'], $allowed ) );

        if( isset( $_POST['ns_basics_cta_bg_img'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_bg_img', wp_kses( $_POST['ns_basics_cta_bg_img'], $allowed ) );
            
        if( isset( $_POST['ns_basics_cta_bg_display'] ) )
            update_post_meta( $post_id, 'ns_basics_cta_bg_display', wp_kses( $_POST['ns_basics_cta_bg_display'], $allowed ) );

        //hook in for other add-ons
        do_action( 'ns_basics_save_page_settings', $post_id); 
    }

?>