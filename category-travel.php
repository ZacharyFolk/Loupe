<?php
/**
 * The template for displaying Category Travel pages.
 *
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 1.0
 */

get_header(); ?>    
<style type="text/css">
      html, body, #travel_map {
        margin: 0;
        padding: 0;
        height: 100%;   
      }
 </style>
 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBw1DpJdlyFiMUhy9yu1zThIK9AFa5zGac&sensor=true">
</script>
<div id="travel_map" ></div>		
<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'map' );

 ?>
<script type="text/javascript">
jQuery(document).ready(function(){initialize(); });
</script>
<?php get_footer(); ?>