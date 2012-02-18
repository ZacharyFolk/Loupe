<?php
/**
 * The template for displaying Category Travel pages.
 *
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 1.0
 */

get_header(); ?>

	<div class="lightTable">
		<div class="floater">
	
		
<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'category' );

 ?>

				</div>
			</div>
<?php get_footer(); ?>

