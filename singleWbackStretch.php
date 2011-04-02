<?php
get_header(); ?>


		<div id="container">
			<div class="lightTable">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/backStretch.js"></script>	

<script type="text/javascript">
jQuery(document).ready(function($){
$.backstretch("<?php echo catch_that_image() ?>", {speed: 150}
	);
});	

</script>
	
			

				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>


<script>
   Galleria.loadTheme('wp-content/themes/theLoupe/scripts/themes/classic/galleria.classic.js');
   jQuery('#gallery-1').galleria({
   debug: true
    });
</script>

</div><!-- #content -->
</div><!-- #container -->
	</div><!-- /lightTable -->
</div><!-- #container -->
</div><!--- /main -->
</div><!-- /wrap -->
<?php get_footer(); ?>
