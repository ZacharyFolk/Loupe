<?php $post = $wp_query->post;
if (in_category('1')) {
	include(TEMPLATEPATH.'/single_zoom.php');
} elseif (in_category('events')) {
	include(TEMPLATEPATH.'/single_no_zoom.php');
} elseif (in_category('24')){
	include(TEMPLATEPATH.'/single_two_up.php');
	} else {
	include(TEMPLATEPATH.'/single_zoom.php');
} ?>