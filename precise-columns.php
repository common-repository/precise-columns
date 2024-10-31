<?php
/*
* Plugin Name: Precise Columns
* Description: Shortcodes for more precise control of your column layouts. More control over column responsive behaviour and column margins.
* Version: 1.0
* Author: Simon Edge
*/

// SET CONSTANT FOR PLUGIN PATH
define('PC_PLUGIN_PATH', plugins_url('/', __FILE__));

// ADD CSS FOR WORDPRESS DASHBOARD (ADMIN)
add_action('admin_enqueue_scripts', 'wp_dashboard_css_function');
function wp_dashboard_css_function() {
    wp_enqueue_style('wp_dashboard_css', PC_PLUGIN_PATH.'css/admin_style.css');
}



// ###########################################################################
// ##### ADD CUSTOM BUTTON TO WORDPRESS TINYMCE EDITOR - PRECISE COLUMNS #####
// ###########################################################################
add_action('admin_head', 'add_tinymce_precise_columns_button');
function add_tinymce_precise_columns_button() {
	global $typenow;
	// check user permissions
	if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	// check if WYSIWYG is enabled
	if (get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'add_tinymce_precise_columns_plugin');
		add_filter('mce_buttons', 'register_tinymce_precise_columns_button');
	}
}
function add_tinymce_precise_columns_plugin($plugin_array) {
	$plugin_array['tinymce_precise_columns_button'] = PC_PLUGIN_PATH.'js/add_tinymce_button.js';
	return $plugin_array;
}
function register_tinymce_precise_columns_button($buttons) {
	array_push($buttons, 'tinymce_precise_columns_button');
	return $buttons;
}



// ##############################
// ##### 6-COLUMN SHORTCODE #####
// ##############################
function col6_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoints - comma separated
	//						(value1 = 3-columns breakpoint, value2 = 1-column breakpoint)
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 6 column gap, value2 = 3 column gap, value3 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '959,479',
		'gap' => '2,4,6',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_arr = explode(",", $break);
	$break_3col = $break_arr[0];
	$break_1col = $break_arr[1];
	$gap_arr = explode(",", $gap);
	$gap_6col = $gap_arr[0];
	$gap_3col = $gap_arr[1];
	$gap_1col = $gap_arr[2];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_3col)) { $break_3col == '959'; }
	if (!is_int($break_1col)) { $break_1col == '479'; }
	if (!is_int($gap_6col)) { $gap_6col == '2'; }
	if (!is_int($gap_3col)) { $gap_3col == '4'; }
	if (!is_int($gap_1col)) { $gap_1col == '6'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "col6_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 6 columns
	$gap = $gap_6col;
	$width_6col = (100 - ($gap * 5)) / 6;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_6col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; }\n";
	// 3 columns
	$gap = $gap_3col;
	$width_3col = (100 - ($gap * 2)) / 3;
	$output .= "@media only screen and (max-width:".$break_3col."px) {\n";
	$output .= "#".$id." > div { width:".$width_3col."%; margin-left:".$gap."%; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col3 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col4 { margin-left:0px; }\n";
	$output .= "}\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100%; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col6 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col6', 'col6_shortcode');



// ##############################
// ##### 5-COLUMN SHORTCODE #####
// ##############################
function col5_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoints - comma separated
	//						(value1 = 3-columns breakpoint, value2 = 1-column breakpoint)
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 5 column gap, value2 = 3 column gap, value3 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '959,479',
		'gap' => '2,4,6',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_arr = explode(",", $break);
	$break_3col = $break_arr[0];
	$break_1col = $break_arr[1];
	$gap_arr = explode(",", $gap);
	$gap_5col = $gap_arr[0];
	$gap_3col = $gap_arr[1];
	$gap_1col = $gap_arr[2];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_3col)) { $break_3col == '959'; }
	if (!is_int($break_1col)) { $break_1col == '479'; }
	if (!is_int($gap_5col)) { $gap_5col == '2'; }
	if (!is_int($gap_3col)) { $gap_3col == '4'; }
	if (!is_int($gap_1col)) { $gap_1col == '6'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "col5_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 6 columns
	$gap = $gap_5col;
	$width_5col = (100 - ($gap * 4)) / 5;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_5col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; }\n";
	// 3 columns
	$gap = $gap_3col;
	$width_3col = (100 - ($gap * 2)) / 3;
	$half_width = $width_3col / 2;
	$output .= "@media only screen and (max-width:".$break_3col."px) {\n";
	$output .= "#".$id." > div { width:".$width_3col."%; margin-left:".$gap."%; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col3 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col4 { margin-left:".$half_width."%; }\n";
	$output .= "#".$id." > .col6 { margin-right:".$half_width."%; }\n";
	$output .= "}\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100%; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col6 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col5', 'col5_shortcode');



// ##############################
// ##### 4-COLUMN SHORTCODE #####
// ##############################
function col4_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoints - comma separated
	//						(value1 = 2-columns breakpoint, value2 = 1-column breakpoint)
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 4 column gap, value2 = 2 column gap, value3 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '959,479',
		'gap' => '3,5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_arr = explode(",", $break);
	$break_2col = $break_arr[0];
	$break_1col = $break_arr[1];
	$gap_arr = explode(",", $gap);
	$gap_4col = $gap_arr[0];
	$gap_2col = $gap_arr[1];
	$gap_1col = $gap_arr[2];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_2col)) { $break_2col == '959'; }
	if (!is_int($break_1col)) { $break_1col == '479'; }
	if (!is_int($gap_4col)) { $gap_4col == '3'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "col4_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 4 columns
	$gap = $gap_4col;
	$width_4col = (100 - ($gap * 3)) / 4;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_4col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; }\n";
	// 2 columns
	$gap = $gap_2col;
	$width_2col = (100 - $gap) / 2;
	$output .= "@media only screen and (max-width:".$break_2col."px) {\n";
	$output .= "#".$id." > div { width:".$width_2col."%; margin-left:".$gap."%; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col3 { margin-left:0px; }\n";
	$output .= "}\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100%; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col4 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col4', 'col4_shortcode');



// ##############################
// ##### 3-COLUMN SHORTCODE #####
// ##############################
function col3_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoints - comma separated
	//						(value1 = 2-columns breakpoint, value2 = 1-column breakpoint)
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 3 column gap, value2 = 2 column gap, value3 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '959,767',
		'gap' => '4,6,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_arr = explode(",", $break);
	$break_2col = $break_arr[0];
	$break_1col = $break_arr[1];
	$gap_arr = explode(",", $gap);
	$gap_3col = $gap_arr[0];
	$gap_2col = $gap_arr[1];
	$gap_1col = $gap_arr[2];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_2col)) { $break_2col == '959'; }
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_3col)) { $gap_3col == '4'; }
	if (!is_int($gap_2col)) { $gap_2col == '6'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "col3_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 3 columns
	$gap = $gap_3col;
	$width_3col = (100 - ($gap * 2)) / 3;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_3col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; }\n";
	// 2 column
	$gap = $gap_2col;
	$width_2col = (100 - $gap) / 2;
	$half_width = $width_2col / 2;
	$output .= "@media only screen and (max-width:".$break_2col."px) {\n";
	$output .= "#".$id." > div { width:".$width_2col."%; margin-left:".$gap."%; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:".$gap."%; }\n";
	$output .= "#".$id." > .col3 { margin-left:".$half_width."%; }\n";
	$output .= "}\n";	
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100%; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col3 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col3', 'col3_shortcode');



// ##############################
// ##### 2-COLUMN SHORTCODE #####
// ##############################
function col2_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoint - the screen width at which to switch to 1-column mode
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 2 column gap, value2 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '767',
		'gap' => '5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_1col = $break;
	$gap_arr = explode(",", $gap);
	$gap_2col = $gap_arr[0];
	$gap_1col = $gap_arr[1];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "col2_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 2 columns
	$gap = $gap_2col;
	$width_2col = (100 - $gap) / 2;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_2col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; }\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100%; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col2', 'col2_shortcode');



// ############################################
// ##### TWO-THIRDS / ONE-THIRD SHORTCODE #####
// ############################################
function twothird_onethird_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoint - the screen width at which to switch to 1-column mode
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 2 column gap, value2 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '767',
		'gap' => '5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_1col = $break;
	$gap_arr = explode(",", $gap);
	$gap_2col = $gap_arr[0];
	$gap_1col = $gap_arr[1];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "thirds_2to1_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 2 columns
	$gap = $gap_2col;
	$width_2third = ((100 - $gap) / 3) * 2;
	$width_1third = ((100 - $gap) / 3) * 1;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_2col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; width:".$width_2third."%; }\n";
	$output .= "#".$id." > .col2 { width:".$width_1third."%; }\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100% !important; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('thirds_2to1', 'twothird_onethird_shortcode');



// ############################################
// ##### ONE-THIRD / TWO-THIRDS SHORTCODE #####
// ############################################
function onethird_twothird_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoint - the screen width at which to switch to 1-column mode
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 2 column gap, value2 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '767',
		'gap' => '5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_1col = $break;
	$gap_arr = explode(",", $gap);
	$gap_2col = $gap_arr[0];
	$gap_1col = $gap_arr[1];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "thirds_1to2_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 2 columns
	$gap = $gap_2col;
	$width_1third = ((100 - $gap) / 3) * 1;
	$width_2third = ((100 - $gap) / 3) * 2;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_2col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; width:".$width_1third."%; }\n";
	$output .= "#".$id." > .col2 { width:".$width_2third."%; }\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100% !important; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('thirds_1to2', 'onethird_twothird_shortcode');



// ##################################################
// ##### THREE-QUARTERS / ONE-QUARTER SHORTCODE #####
// ##################################################
function threequarters_onequarter_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoint - the screen width at which to switch to 1-column mode
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 2 column gap, value2 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '767',
		'gap' => '5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_1col = $break;
	$gap_arr = explode(",", $gap);
	$gap_2col = $gap_arr[0];
	$gap_1col = $gap_arr[1];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "quarters_3to1_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 2 columns
	$gap = $gap_2col;
	$width_3quarters = ((100 - $gap) / 4) * 3;
	$width_1quarter = ((100 - $gap) / 4) * 1;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_2col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; width:".$width_3quarters."%; }\n";
	$output .= "#".$id." > .col2 { width:".$width_1quarter."%; }\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100% !important; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('quarters_3to1', 'threequarters_onequarter_shortcode');



// ##################################################
// ##### ONE-QUARTER / THREE-QUARTERS SHORTCODE #####
// ##################################################
function onequarter_threequarters_shortcode($atts, $content = null) {
	// EXTRACT SHORTCODE ATTRIBUTES
	//		break			the responsive breakpoint - the screen width at which to switch to 1-column mode
	//		gap			the gap between each column (a percentage of total width) - comma separated
	//						(value1 = 2 column gap, value2 = 1 column gap)
	//		align			the text alignment of content within each column (left, center or right)
	//		valign		the vertical alignment of content within each column (top, middle, bottom)
	//		strip_tags	whether to strip '<p>' and '<br/>' tags from column content
	//		wrap_padd	the wrapper padding top/bottom and left/right (a percentage of total width)
	//		wrap_id		the CSS ID for the wrapper
	extract(shortcode_atts(array(
		'break' => '767',
		'gap' => '5,8',
		'align' => 'left',
		'valign' => 'top',
		'strip_tags' => 'n',
		'wrap_padd' => '0,0',
		'wrap_id' => '',
	), $atts));
	$break_1col = $break;
	$gap_arr = explode(",", $gap);
	$gap_2col = $gap_arr[0];
	$gap_1col = $gap_arr[1];
	$wrap_padd_arr = explode(",", $wrap_padd);
	$padd_vert = $wrap_padd_arr[0];
	$padd_hori = $wrap_padd_arr[1];
	
	// VALIDATE SHORTCODE ATTRIBUTES
	if (!is_int($break_1col)) { $break_1col == '767'; }
	if (!is_int($gap_2col)) { $gap_2col == '5'; }
	if (!is_int($gap_1col)) { $gap_1col == '8'; }
	if (($align != 'left') && ($align != 'center') && ($align != 'right')) {
		$align != 'left';
	}
	if (($valign != 'top') && ($valign != 'middle') && ($valign != 'bottom')) {
		$valign != 'top';
	}
	if (($strip_tags != 'y') && ($strip_tags != 'Y') && ($strip_tags != 'n') && ($strip_tags != 'N')) {
		$strip_tags != 'y';
	}
	if (!is_int($padd_vert)) { $padd_vert == '0'; }
	if (!is_int($padd_hori)) { $padd_hori == '0'; }
	
	// GENERATE A RANDOM ID FOR THE DIV CONTAINER
	if ($wrap_id == '') {
		$id = "quarters_1to3_".randomString(16);
	} else {
		$id = $wrap_id;
	}
	
	// OUTPUT THE CONTENT OF SHORTCODE COLUMNS
	$output =  "<div id='".$id."'>\n";
	$col_output = do_shortcode($content);
	// strip '<p>' and '<br/>' tags
	if (($strip_tags == 'y') || ($strip_tags == 'Y')) {
		$col_output = strip_p_br_tags($col_output);
	}
	// set the class for each column
	$col_output = set_class_for_each_column($col_output);
	$output .= $col_output;
	$output .= "</div>\n";
	
	// GENERATE STYLESHEET SPECIFIC TO THE COLUMNS WITHIN THIS SHORTCODE
	$output .= "<style>\n";
	// 2 columns
	$gap = $gap_2col;
	$width_1quarter = ((100 - $gap) / 4) * 1;
	$width_3quarters = ((100 - $gap) / 4) * 3;
	$output .= "#".$id." { width:100%; font-size:0px; height:auto; padding:".$padd_vert."% ".$padd_hori."% !important; }\n";
	$output .= "#".$id." > div { display:inline-block; width:".$width_2col."%; margin-left:".$gap."%; margin-bottom:0px; font-size:initial; ";
	$output .= "text-align:".$align."; vertical-align:".$valign."; }\n";
	$output .= "#".$id." > .col1 { margin-left:0px; width:".$width_1quarter."%; }\n";
	$output .= "#".$id." > .col2 { width:".$width_3quarters."%; }\n";
	// 1 column
	$gap = $gap_1col;
	$output .= "@media only screen and (max-width:".$break_1col."px) {\n";
	$output .= "#".$id." > div { display:block; width:100% !important; margin:0px 0px ".$gap."% !important; }\n";
	$output .= "#".$id." > .col2 { margin-bottom:0px !important; }\n";
	$output .= "}\n";
	$output .= "</style>\n";

	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('quarters_1to3', 'onequarter_threequarters_shortcode');



// ### OUTPUT THE CONTENT OF "<col>" SHORTCODES SURROUNDING OUTPUT WITH "<div>" AND "</div>" ###
function col_shortcode($atts, $content = null) {
	$output =  "<div>".$content."</div>\n";
	// Return the HTML created as the shortcode output
	return $output;
}
add_shortcode('col', 'col_shortcode');



// ### STRIP ALL THE '<p>' AND '<br/>' TAGS FROM A SUPPLIED STRING ###
function strip_p_br_tags($content) {
	$content = str_replace("<p>", "", $content);
	$content = str_replace("</p>", "", $content);
	$content = str_replace("<br/>", "", $content);
	$content = str_replace("<br />", "", $content);
	return $content;
}



// ### SET THE CLASS NAME FOR EACH COLUMN <div> ###
function set_class_for_each_column($content) {
	$pattern = '/<div>/';
	$count = 1;
	$content = preg_replace_callback(
		$pattern,
		function($match) use (&$count) {
			$str = "<div class='col".$count."'>";
			$count++;
			return $str;
		},
		$content
	);
	return $content;
}



// ### CREATE A RANDOM STRING ###
// This function returns a random string of the specified length
// This string is used to create the CSS ID for the DIV containers for each column layout
// parameter $length - the length of the string to create
function randomString($length = 6) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
?>