<?php
/**
 * Template Name: Tags
 *
{$tagLink}
 */

get_header(); ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div id="tagList">
	<?php $tagArgs = array(
						'orderby' => 'count',
						'post_type' => array ('post','portfolio'),
						'order' => 'DESC',
						'number' => 50,
						);
						$theTags = get_tags( $tagArgs );
						$tagListHTML = '<ul class="post_tags">';
							foreach ($theTags as $theTag){
							$tagLink = get_tag_link($theTag->term_id);		
							$tagListHTML .= "<li class='count-{$theTag->count}' id='{$theTag->slug}'><a href='#{$theTag->name}' title='{$theTag->name} Tag' class='{$theTag->slug}'>{$theTag->name}</a></li>";
								}
							$tagListHTML .= '</ul>';
							echo $tagListHTML;
	?>
	</div>
	<?php endwhile; ?>
<div id="container">
	<div id="tagTableOuter">

	<div id="singleTagContainer">
	</div>
	</div>



<script type="text/javaScript">
jQuery(document).ready(function($){
	$('#tagList li').each(function() {
		
        $(this).data('original-size', $(this).css('fontSize'));
		
        $(this).click(function() {
			var tagName = $(this).attr("id");
			var ajax_load = "loading";
			$('#singleTagContainer').html(ajax_load)
            $(this).animate({
                fontSize: "40px"
            }, 1000, function() {					
					$('#singleTagContainer').html(ajax_load).load('tag/'+ tagName + ' .tagTable')
					});

            $(this).siblings().each(function() {
				var originalSize = $(this).data('original-size');
                if ($(this).css('fontSize') != originalSize) {
                    $(this).animate({
                        fontSize: originalSize
                    }, 500);
                }
            });

        });
    });

	});

</script>
	<?php get_footer(); ?>
