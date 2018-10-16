<?php
/*-----------------------------------------------------------------------------------*/
/*  Global Template Loader
/*-----------------------------------------------------------------------------------*/
function ns_basics_template_loader($template, $template_args = array(), $wrapper = true) {
	$theme_file = locate_template(array( 'ns-basics/' . $template));

	if($wrapper == true) { echo '<div class="ns-basics">'; }
	if(empty($theme_file)) {
		include( plugin_dir_path( __FILE__ ) . $template);
	} else {
		include(get_parent_theme_file_path('/ns-basics/'.$template));
	}
	if($wrapper == true) { echo '</div>'; }
}

?>