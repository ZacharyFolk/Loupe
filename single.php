<?php $post = $wp_query->post;
if (in_category('24')){
	include(TEMPLATEPATH.'/single_two_up.php');
	} else {
	include(TEMPLATEPATH.'/single_post.php');
} ?>