<?php
/**
 * Template Name: Tags
 *
TODO : Make tags specific to photo taxonomy or normal blog post type
 */

get_header(); 
$args = array(
	'smallest' => 12,
	'largest' => 32,
	'unit' => 'pt',
	'number' => 50,
	'format' => 'list', // can return as an array 
	'orderby' => 'name',
	'topic_count_text_callback' => tag_count_text,
	'taxonomy' => 'post_tag'
	
);
?>
<?php
wp_tag_cloud($args);
?>

<div class="tagTarget">
	
</div>
<script type="text/javascript">
    var $ = jQuery;
		$('.wp-tag-cloud a').click(function(e){
			e.preventDefault();
			$('.wp-tag-cloud a').addClass('activeTag').not(this).removeClass('activeTag').end();
			var tagPath = this.href + ' #theThumbs';
			$('.tagTarget').empty();
			$('.tagTarget').load(tagPath);
			});		
	 			
</script>
<?php
get_footer(); 