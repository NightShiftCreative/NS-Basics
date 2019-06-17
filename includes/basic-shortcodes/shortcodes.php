<?php 
add_action( 'media_buttons', function($editor_id) { ?>

    <?php if($editor_id == 'content') { ?>
    <a href="#" data-featherlight="#shortcode-selector" data-featherlight-persist="true" class="button add-shortcode" title="<?php esc_html_e('Add Basic Shortcode', 'ns-basics'); ?>">
        <span class="wp-media-buttons-icon add-shortcode-icon"></span><?php esc_html_e('Basic Shortcode', 'ns-basics'); ?>
    </a>

    <div class="shortcode-selector" id="shortcode-selector">
        <div class="featherlight-header"><?php esc_html_e('Insert a Shortcode', 'ns-basics'); ?></div>
        <div class="shortcode-selector-inner">
            <div class="shortcode-selector-list">
                <p><?php esc_html_e('Choose a shortcode to insert from the list below:', 'ns-basics'); ?></p>
                <a href="#basic-row" class="button"><i class="fa fa-align-justify"></i><?php esc_html_e('Row', 'ns-basics'); ?></a>
                <a href="#basic-col" class="button has-options"><i class="fa fa-columns"></i><?php esc_html_e('Column', 'ns-basics'); ?></a>
                <a href="#basic-module" class="button has-options"><i class="fa fa-expand"></i><?php esc_html_e('Module', 'ns-basics'); ?></a>
                <a href="#basic-module-header" class="button has-options"><i class="fa fa-font"></i><?php esc_html_e('Module Header', 'ns-basics'); ?></a>
                <a href="#basic-button" class="button has-options"><i class="fa fa-link"></i><?php esc_html_e('Button', 'ns-basics'); ?></a>
                <a href="#basic-video" class="button has-options"><i class="fa fa-play"></i><?php esc_html_e('Video', 'ns-basics'); ?></a>
                <a href="#basic-alert" class="button has-options"><i class="fa fa-bell"></i><?php esc_html_e('Alert Box', 'ns-basics'); ?></a>
                <a href="#basic-service" class="button has-options"><i class="fa fa-check"></i><?php esc_html_e('Service', 'ns-basics'); ?></a>
                <a href="#basic-team-member" class="button has-options"><i class="fa fa-user"></i><?php esc_html_e('Team Member', 'ns-basics'); ?></a>
                <a href="#basic-tabs" class="button has-options"><i class="fa fa-list"></i><?php esc_html_e('Tabs', 'ns-basics'); ?></a>
                <a href="#basic-accordion" class="button has-options"><i class="fa fa-list"></i><?php esc_html_e('Accordion', 'ns-basics'); ?></a>
                <a href="#basic-testimonials" class="button has-options"><i class="fa fa-comments"></i><?php esc_html_e('Testimonials', 'ns-basics'); ?></a>
                <a href="#basic-login-form" class="button has-options"><i class="fa fa-key"></i><?php esc_html_e('Login Form', 'ns-basics'); ?></a>
                <a href="#basic-register-form" class="button has-options"><i class="fa fa-user-plus"></i><?php esc_html_e('Register Form', 'ns-basics'); ?></a>
                <a href="#basic-user-dashboard" class="button has-options"><i class="fa fa-th-large"></i><?php esc_html_e('User Dashboard', 'ns-basics'); ?></a>
                <a href="#basic-user-favorites" class="button has-options"><i class="fa fa-heart"></i><?php esc_html_e('User Favorites', 'ns-basics'); ?></a>
                <a href="#basic-user-edit-profile" class="button has-options"><i class="fa fa-cog"></i><?php esc_html_e('User Edit Profile', 'ns-basics'); ?></a>
            </div>
            <div class="shortcode-selector-options">
                <div class="button cancel-shortcode"><i class="fa fa-reply"></i> <?php esc_html_e('Go Back', 'ns-basics'); ?></div>

                <div id="basic-col" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Column', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Width', 'ns-basics'); ?></label>
                        <select class="basic-col-width">
                            <option value="2"><?php esc_html_e('Sixth', 'ns-basics'); ?></option>
                            <option value="3"><?php esc_html_e('Quarter', 'ns-basics'); ?></option>
                            <option value="4"><?php esc_html_e('Third', 'ns-basics'); ?></option>
                            <option value="6" selected><?php esc_html_e('Half', 'ns-basics'); ?></option>
                            <option value="12"><?php esc_html_e('Full', 'ns-basics'); ?></option>
                        </select>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-module" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Module', 'ns-basics'); ?></strong></h3>
                    <div class="form-block" style="margin:15px 0px;">
                        <input type="checkbox" class="basic-module-container" value="true" checked />
                        <label style="display:inline;"><?php esc_html_e('Container', 'ns-basics'); ?></label>
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('CSS Class Name', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-class" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Padding Top', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-padding-top" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Padding Bottom', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-padding-bottom" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Margin Top', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-margin-top" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Margin Bottom', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-margin-bottom" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Background Color', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-bg-color color-field" data-default-color="#ffffff" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Background Image', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-bg-img" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-module-header" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Module Header', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Title', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-header-title" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Text', 'ns-basics'); ?></label>
                        <input type="text" class="basic-module-header-text" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Position', 'ns-basics'); ?></label>
                        <select class="basic-module-header-position">
                            <option value="left"><?php esc_html_e('Left', 'ns-basics'); ?></option>
                            <option value="center"><?php esc_html_e('Center', 'ns-basics'); ?></option>
                            <option value="right"><?php esc_html_e('Right', 'ns-basics'); ?></option>
                        </select>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-alert" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Alert Box', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Title', 'ns-basics'); ?></label>
                        <input type="text" class="basic-alert-title" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Type', 'ns-basics'); ?></label>
                        <select class="basic-alert-type">
                            <option value="success"><?php esc_html_e('Success', 'ns-basics'); ?></option>
                            <option value="error"><?php esc_html_e('Error', 'ns-basics'); ?></option>
                            <option value="warning"><?php esc_html_e('Warning', 'ns-basics'); ?></option>
                            <option value="info"><?php esc_html_e('Info', 'ns-basics'); ?></option>
                        </select>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-service" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Service', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Icon', 'ns-basics'); ?></label>
                        <input type="text" class="basic-service-icon-fa" placeholder="Font Awesome" value="" />
                        <input type="text" class="basic-service-icon-line" placeholder="Line Icon" value="" />
                        <input type="text" class="basic-service-icon-dripicon" placeholder="Dripicon" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Title', 'ns-basics'); ?></label>
                        <input type="text" class="basic-service-title" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Text', 'ns-basics'); ?></label>
                        <input type="text" class="basic-service-text" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-team-member" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Team Member', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Image', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-img" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Name', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-name" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Title/Position', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-title" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Bio', 'ns-basics'); ?></label>
                        <textarea class="basic-team-member-bio"></textarea>
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Facebook', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-fb" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Twitter', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-twitter" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Google Plus', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-google" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Instagram', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-instagram" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Linkedin', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-linkedin" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Youtube', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-youtube" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Vimeo', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-vimeo" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Flickr', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-flickr" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Dribbble', 'ns-basics'); ?></label>
                        <input type="text" class="basic-team-member-dribbble" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-button" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Button', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Button Text', 'ns-basics'); ?></label>
                        <input type="text" class="basic-button-text" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Button URL', 'ns-basics'); ?></label>
                        <input type="text" class="basic-button-url" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Button Type', 'ns-basics'); ?></label>
                        <input type="text" class="basic-button-type" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Button Position', 'ns-basics'); ?></label>
                        <input type="text" class="basic-button-position" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-video" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Video', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Title', 'ns-basics'); ?></label>
                        <input type="text" class="basic-video-title" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Video URL', 'ns-basics'); ?></label>
                        <input type="text" class="basic-video-url" value="" />
                    </div>
                    <div class="form-block">
                        <label><?php esc_html_e('Cover Image', 'ns-basics'); ?></label>
                        <input type="text" class="basic-video-cover" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-tabs" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Tabs', 'ns-basics'); ?></strong></h3>
                    <div class="form-block form-block-tabs">
                        <a href="#" class="button create-tab"><i class="fa fa-plus"></i> <?php esc_html_e('Create Tab', 'ns-basics'); ?></a>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-accordion" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Accordion', 'ns-basics'); ?></strong></h3>
                    <div class="form-block form-block-accordion">
                        <a href="#" class="button create-accordion"><i class="fa fa-plus"></i> <?php esc_html_e('Create Accordion', 'ns-basics'); ?></a>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-testimonials" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Testimonials', 'ns-basics'); ?></strong></h3>
                    <div class="form-block form-block-testimonials">
                        <a href="#" class="button create-testimonial"><i class="fa fa-plus"></i> <?php esc_html_e('Create Testimonial', 'ns-basics'); ?></a>
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-login-form" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Login Form', 'ns-basics'); ?></strong></h3>
                    <div class="form-block">
                        <label><?php esc_html_e('Redirect URL', 'ns-basics'); ?></label>
                        <span class="admin-module-note"><?php esc_html_e('If empty, users will be redirected to the home page after logging in.', 'ns-basics'); ?></span>
                        <input type="text" class="basic-login-form-redirect" value="" />
                    </div>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-register-form" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert Register Form', 'ns-basics'); ?></strong></h3>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-user-dashboard" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert User Dashboard', 'ns-basics'); ?></strong></h3>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-user-favorites" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert User Favorites', 'ns-basics'); ?></strong></h3>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

                <div id="basic-user-edit-profile" class="admin-module no-border">
                    <h3><strong><?php esc_html_e('Insert User Edit Profile', 'ns-basics'); ?></strong></h3>
                    <a href="#" class="admin-button insert-shortcode"><?php esc_html_e('Insert', 'ns-basics'); ?></a>
                </div>

            </div>
        </div>
    </div>
    <?php } ?>
<?php } ); 


//REMOVE <p> AND <br/> TAGS FROM SHORTCODE CONTENT
function ns_basics_content_filter($content) {
    $block = join("|",array('ns_module', 'ns_module_header', 'ns_row', 'ns_col', 'ns_button', 'ns_button_alt', 'ns_quote', 'ns_alert_box', 'ns_service', 'ns_team_member', 'ns_testimonials', 'ns_testimonial', 'ns_tabs', 'ns_tab', 'ns_accordions', 'ns_accordion', 'ns_login_form', 'ns_register_form', 'ns_dashboard', 'ns_favorites', 'ns_edit_profile'));
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
return $rep;
}
add_filter("the_content", "ns_basics_content_filter");

/****************************************************************************/
/* GLOBAL */
/****************************************************************************/

/* MODULE */
add_shortcode('ns_module', 'ns_module');
function ns_module($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'class' => '',
        'container' => 'true',
        'padding_top' => '',
        'padding_bottom' => '',
        'margin_top' => '',
        'margin_bottom' => '',
        'bg_color' => '',
        'bg_img' => '',
        'bg_fixed' => '',
        'text_color' => '',
    ), $atts);

    if(!empty($atts['padding_top'])) { $padding_top = 'padding-top:'.$atts['padding_top'].';'; } else { $padding_top = ''; }
    if(!empty($atts['padding_bottom'])) { $padding_bottom = 'padding-bottom:'.$atts['padding_bottom'].';'; } else { $padding_bottom = ''; }
    if(!empty($atts['margin_top'])) { $margin_top = 'margin-top:'.$atts['margin_top'].';'; } else { $margin_top = ''; }
    if(!empty($atts['margin_bottom'])) { $margin_bottom = 'margin-bottom:'.$atts['margin_bottom'].';'; } else { $margin_bottom = ''; }
    if(!empty($atts['bg_color'])) { $bg_color = 'background:'.$atts['bg_color'].';'; } else { $bg_color = ''; }
    if(!empty($atts['bg_fixed'])) { $bg_fixed = 'background-attachment:fixed;'; } else { $bg_fixed=''; }
    if(!empty($atts['bg_img'])) { $bg_img = 'background:'.$atts['bg_color'].' url('.$atts['bg_img'].') no-repeat center; background-size:cover;'.$bg_fixed; } else { $bg_img = ''; }

    if ($atts['container'] == 'false') {
        return '<section class="module ' . $atts['text_color'] .' '. $atts['class'] .'" style="'.$padding_top . $padding_bottom . $margin_top . $margin_bottom . $bg_color . $bg_img .'" >'. do_shortcode($content) .'</section>';
    } else {
        return '<section class="module ' . $atts['text_color'] .' '. $atts['class'] .'" style="'.$padding_top . $padding_bottom . $margin_top . $margin_bottom . $bg_color . $bg_img .'" ><div class="container">'. do_shortcode($content) .'</div></section>';
    }
}

/** MODULE HEADER **/
add_shortcode('ns_module_header', 'ns_module_header');
function ns_module_header($atts, $content=null) {

    $atts = shortcode_atts(
        array (
        'title' => '',
        'text' => '',
        'position' => '',
    ), $atts);

    if(!empty($atts['title'])) { $title = '<h2>'.$atts['title'].'</h2>'; } else { $title = ''; }
    if(!empty($atts['text'])) { $text = '<p>'.$atts['text'].'</p>'; } else { $text = ''; }
    
    if($atts['position'] == 'left') { 
        $position = 'module-header-left';
        $widget_divider = '<table class="widget-divider"><tr><td><div class="widget-divider-icon"></div></td><td><div class="bar"></div></td></tr></table>'; 
    } else if($atts['position'] == 'right') { 
        $position = 'module-header-right'; 
        $widget_divider = '<table class="widget-divider"><tr><td><div class="bar"></div></td><td><div class="widget-divider-icon"></div></td></tr></table>';
    } else { 
        $position = ''; 
        $widget_divider = '<table class="widget-divider"><tr><td><div class="bar"></div></td><td><div class="widget-divider-icon"></div></td><td><div class="bar bar-second"></div></td></tr></table>';
    } 

    return '<div class="module-header '.$position.'">'.$title . $widget_divider . $text.'</div>';
}

/* ROW */
add_shortcode('ns_row', 'ns_row');
function ns_row($atts, $content=null) {
	return '<div class="row">'. do_shortcode($content) .'</div>';
}

/* COLUMN */
add_shortcode('ns_col', 'ns_col');
function ns_col($atts, $content=null) {
	$atts = shortcode_atts(
		array (
		'span' => '4'
	), $atts);

	return '<div class="col-lg-'. $atts['span'] .' col-md-'. $atts['span'] .'">'. do_shortcode($content) .'</div>';
}

/* BUTTON (DEFAULT) */
add_shortcode('ns_button', 'ns_button');
function ns_button($atts, $content = null) {
	$atts = shortcode_atts(
		array (
			'url' => '#',
			'type' => '',
			'position' => '',
		), $atts);

	if ($atts['position'] == 'center') {
		return '<div style="width:100%; text-align:center;"><a href="'. $atts['url'] .'" class="button '. $atts['type'] .'">'. ucwords($content) .'</a></div>';
	} else {
		return '<a href="'. $atts['url'] .'" class="button '. $atts['type'] .' '. $atts['position'] .'">'. ucwords($content) .'</a>';
	}
}

/* BUTTON ALTERNATIVE */
add_shortcode('ns_button_alt', 'ns_button_alt');
function ns_button_alt($atts, $content = null) {
	$atts = shortcode_atts(
		array (
			'url' => '#',
			'type' => '',
			'position' => '',
		), $atts);

	if ($atts['position'] == 'center') {
		return '<div style="width:100%; text-align:center;"><a href="'. $atts['url'] .'" class="button alt '. $atts['type'] .'">'. ucwords($content) .'</a></div>';
	} else {
		return '<a href="'. $atts['url'] .'" class="button alt '. $atts['type'] .' '. $atts['position'] .'">'. ucwords($content) .'</a>';
	}
}

/* QUOTE */
add_shortcode('ns_quote', 'ns_quote');
function ns_quote($atts, $content = null) {
	return '<blockquote>'. wp_kses_post($content) .'</blockquote>';
}

/* ALERT BOXES */
add_shortcode('ns_alert_box', 'ns_alert_box');
function ns_alert_box($atts, $content = null) {
	$atts = shortcode_atts(
		array (
			'title' => '',
			'type' => 'success'
		), $atts);

	return '
	<div class="alert-box '. $atts['type'] .'">
        <h4>'. wp_kses_post($content) .'</h4>
    </div>
	';
}

/** SERVICES **/
add_shortcode('ns_service', 'ns_service');
function ns_service($atts, $content = null) {
    $icon_set = get_option('ns_core_icon_set', 'fa');

    $atts = shortcode_atts(
        array (
            'icon' => '',
            'icon_line' => '',
            'dripicon' => '',
            'title' => '',
            'text' => ''
        ), $atts);

    if(!empty($atts['icon'])) { $icon =  ns_core_get_icon($icon_set, $atts['icon'], $atts['icon_line'], $atts['dripicon']); } else { $icon = ''; }
    if(!empty($atts['title'])) { $title =  '<h4>'. $atts['title'] .'</h4>'; } else { $title = ''; }

    return '
        <div class="service-item">
            '. $icon .'
            '. $title .'
            <p>'. $atts['text'] .'</p>
        </div>
    ';
}

/** TEAM MEMBER **/
add_shortcode('ns_team_member', 'ns_team_member');
function ns_team_member($atts, $content = null) {
    $atts = shortcode_atts(
        array (
            'img' => '',
            'name' => '',
            'title' => '',
            'bio' => '',
            'facebook' => '',
            'twitter' => '',
            'google' => '',
            'instagram' => '',
            'linkedin' => '',
            'youtube' => '',
            'vimeo' => '',
            'flickr' => '',
            'dribbble' => ''
        ), $atts);

    $output = '';
    $output .= '<div class="team-member shadow-hover">';
    if(!empty($atts['img'])) { 
        $output .= '<div class="team-member-img" style="background-image:url('.$atts['img'].');"><p>'.$atts['bio'].'</p><div class="img-overlay"></div><div class="img-fade"></div></div>'; 
    }
    $output .= '<div class="team-member-content"><h4>'.$atts['name'].'</h4><p>'.$atts['title'].'</p>';
    $output .= '<ul class="social-icons circle">';
    if(!empty($atts['facebook'])) { $output .= '<li><a target="_blank" href="'.$atts['facebook'].'"><i class="fab fa-facebook-f"></i></a></li>'; }
    if(!empty($atts['twitter'])) { $output .= '<li><a target="_blank" href="'.$atts['twitter'].'"><i class="fab fa-twitter"></i></a></li>'; }
    if(!empty($atts['google'])) { $output .= '<li><a target="_blank" href="'.$atts['google'].'"><i class="fab fa-google-plus"></i></a></li>'; }
    if(!empty($atts['instagram'])) { $output .= '<li><a target="_blank" href="'.$atts['instagram'].'"><i class="fab fa-instagram"></i></a></li>'; }
    if(!empty($atts['linkedin'])) { $output .= '<li><a target="_blank" href="'.$atts['linkedin'].'"><i class="fab fa-linkedin"></i></a></li>'; }
    if(!empty($atts['youtube'])) { $output .= '<li><a target="_blank" href="'.$atts['youtube'].'"><i class="fab fa-youtube"></i></a></li>'; }
    if(!empty($atts['vimeo'])) { $output .= '<li><a target="_blank" href="'.$atts['vimeo'].'"><i class="fab fa-vimeo"></i></a></li>'; }
    if(!empty($atts['flickr'])) { $output .= '<li><a target="_blank" href="'.$atts['flickr'].'"><i class="fab fa-flickr"></i></a></li>'; }
    if(!empty($atts['dribbble'])) { $output .= '<li><a target="_blank" href="'.$atts['dribbble'].'"><i class="fab fa-dribbble"></i></a></li>'; }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

/** VIDEO **/
add_shortcode('ns_video', 'ns_video');
function ns_video($atts, $content = null) {
    $atts = shortcode_atts(
        array (
            'title' => '',
            'url' => '',
            'cover_img' => ''
        ), $atts);

    $output = '';
    $output .= '<a data-fancybox class="video-cover" href="'.$atts['url'].'" title="'.$atts['title'].'">';
    $output .= '<div class="video-cover-content"><i class="fa fa-play icon"></i><p>'.$atts['title'].'</p></div>';
    if(!empty($atts['cover_img'])) { $output .= '<img src="'. $atts['cover_img'] .'" alt="'. $atts['title'] .'" />'; }
    $output .= '</a>';

    return $output;
}

/** TABS **/
$tabs_divs = '';

add_shortcode('ns_tabs', 'ns_tabs');
function ns_tabs($atts, $content=null) {
    global $tabs_divs;
    $tabs_divs = '';

    return '<div class="tabs"><ul class="clean-list">'. do_shortcode(wp_kses_post($content)) .'</ul><div class="panel-container">'. $tabs_divs .'</div></div>';
}

add_shortcode('ns_tab', 'ns_tab');
function ns_tab($atts, $content=null) {
    global $tabs_divs;
    $icon_set = get_option('ns_core_icon_set', 'fa');

    $atts = shortcode_atts(
        array (
            'id' => '',
            'title' => '',
            'icon' => '',
            'icon_line' => '',
            'dripicon' => '',
        ), $atts);

    if(!empty($atts['icon'])) { $icon = ns_core_get_icon($icon_set, $atts['icon'], $atts['icon_line'], $atts['dripicon']); } else { $icon = ''; }

    $tabs_divs.= '<div id="tab'. $atts['id'] .'">'.$content.'</div>';

    return '<li><a href="#tab'. $atts['id'] .'">'. $icon . $atts['title'] .'</a></li>';
}

/** ACCORDION **/
add_shortcode('ns_accordions', 'ns_accordions');
function ns_accordions($atts, $content=null) {
    return '<div class="accordion" class="content">'. do_shortcode(wp_kses_post($content)) .'</div>';
}

add_shortcode('ns_accordion', 'ns_accordion');
function ns_accordion($atts, $content=null) {
    $atts = shortcode_atts(
        array (
            'title' => '',
        ), $atts);

    return '
        <h3>'. $atts['title'] .'</h3>
        <div>'. wp_kses_post($content) .'</div>
    ';
}

/** TESTIMONIALS **/
add_shortcode('ns_testimonials', 'ns_testimonials');
function ns_testimonials($atts, $content=null) {

	$output = '';
    $output .= '<div class="slider-wrap slider-wrap-testimonials">';
    $output .= '<div class="slider-nav slider-nav-testimonials">';
    $output .= '<span class="slider-prev slick-arrow"><i class="fa fa-angle-left"></i></span>';
    $output .= '<span class="slider-next slick-arrow"><i class="fa fa-angle-right"></i></span>';
    $output .= '</div>';
    $output .= '<div class="slider slider-testimonials">'. do_shortcode($content) .'</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('ns_testimonial', 'ns_testimonial');
function ns_testimonial($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'img' => '',
        'name' => '',
        'title' => '',
    ), $atts);

	$output = '';
    $output .= '<div class="testimonial slide">';
    $output .= '<h3>'. do_shortcode($content) .'</h3>';
    $output .= '<div class="testimonial-details">';
    if(!empty($atts['img']))  { $output .= '<img class="testimonial-img" src="'. $atts['img'] .'" alt="" />'; }
    if(!empty($atts['name']))  { $output .= '<span class="testimonial-name"><strong>'. $atts['name'] .'</strong></span>'; }
    if(!empty($atts['title']))  { $output .= '<span class="testiomnial-title"><em>'. $atts['title'] .'</em></span>'; }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

/** LIST POSTS **/
add_shortcode('ns_list_posts', 'ns_list_posts');
function ns_list_posts($atts, $content=null) {
    ob_start();

    echo '<div class="row ns-list-posts">';

    $post_listing_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
    );

    $post_listing_query = new WP_Query( $post_listing_args );
    if ( $post_listing_query->have_posts() ) : while ( $post_listing_query->have_posts() ) : $post_listing_query->the_post();

        echo '<div class="col-lg-4">';
        get_template_part('template_parts/loop_blog_post');
        echo '</div>';

    endwhile; 
    wp_reset_postdata();
    else:
    endif; 

    echo '</div>';

    $output = ob_get_clean();
    return $output;
}


/****************************************************************************/
/* MEMBER SHORTCODES */
/****************************************************************************/

/** LOGIN FORM **/
add_shortcode('ns_login_form', 'ns_login_form');
function ns_login_form($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'redirect' => '',
    ), $atts);

    ob_start();
    if(function_exists('ns_basics_template_loader')) { 
        
        //Set template args
        $template_args = array();
        $template_args['redirect'] = $atts['redirect'];
        
        //Load template
        ns_basics_template_loader('login_form.php', $template_args);
    }
    $output = ob_get_clean();

    return $output;
}

/** REGISTER FORM **/
add_shortcode('ns_register_form', 'ns_register_form');
function ns_register_form($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'role' => 'subscriber',
    ), $atts);

    ob_start();
    if(function_exists('ns_basics_template_loader')) { 
        
        //Set template args
        $template_args = array();
        $template_args['role'] = $atts['role'];
        
        //Load template
        ns_basics_template_loader('register_form.php', $template_args);
    }
    $output = ob_get_clean();

    return $output;
}

/** USER DASHBOARD **/
add_shortcode('ns_dashboard', 'ns_dashboard');
function ns_dashboard($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'role' => '',
    ), $atts);

    ob_start();
    if(function_exists('ns_basics_template_loader')) { 
        
        //Set template args
        $template_args = array();
        
        //Load template
        ns_basics_template_loader('dashboard.php', $template_args);
    }
    $output = ob_get_clean();

    return $output;
}

/** USER FAVORITES **/
add_shortcode('ns_favorites', 'ns_favorites');
function ns_favorites($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'show_posts' => '12',
    ), $atts);

    ob_start();
    if(function_exists('ns_basics_template_loader')) { 
        
        //Set template args
        $template_args = array();
        $template_args['show_posts'] = $atts['show_posts'];
        
        //Load template
        ns_basics_template_loader('favorites.php', $template_args);
    }
    $output = ob_get_clean();

    return $output;
}

/** USER EDIT PROFILE **/
add_shortcode('ns_edit_profile', 'ns_edit_profile');
function ns_edit_profile($atts, $content=null) {
    $atts = shortcode_atts(
        array (
        'show_posts' => '',
    ), $atts);

    ob_start();
    if(function_exists('ns_basics_template_loader')) { 
        
        //Set template args
        $template_args = array();
        
        //Load template
        ns_basics_template_loader('edit_profile.php', $template_args);
    }
    $output = ob_get_clean();

    return $output;
}


?>