<?php
/**
 * Template Name: Blog
 */
?>
<?php get_header(); ?>
<?php
$query = 'posts_per_page=10';
$queryObject = new WP_Query($query);
// The Loop...
if ($queryObject->have_posts()) {
	while ($queryObject->have_posts()) {
		$queryObject->the_post();
?>

<div class="leftContent">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="perm"><?php the_title(); ?></h1>
					<div class="entry-meta">
						<?php loupe_posted_on(); ?>
					</div><!-- .entry-meta -->
					<div class="entry-content">
						<?php the_excerpt(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'loupe' ), 'after' => '' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-utility">
						<?php loupe_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'loupe' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->
		</div>
	</div>
	<?php 	}
}
?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>