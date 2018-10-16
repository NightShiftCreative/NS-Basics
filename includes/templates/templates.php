<?php
/*-----------------------------------------------------------------------------------*/
/*  Global Template Loader
/*-----------------------------------------------------------------------------------*/
function rype_basics_template_loader($template, $template_args = array(), $wrapper = true) {
	$theme_file = locate_template(array( 'rype_basics/' . $template));

	if($wrapper == true) { echo '<div class="rype-basics">'; }
	if(empty($theme_file)) {
		include( plugin_dir_path( __FILE__ ) . $template);
	} else {
		include(get_parent_theme_file_path('/rype_basics/'.$template));
	}
	if($wrapper == true) { echo '</div>'; }
}

?>