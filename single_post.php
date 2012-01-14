<?php include(TEMPLATEPATH.'/single-post-header.php'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="postContainer">
		<div class="leftContent">
				<nav id="nav-above" class="navigation">
					<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'loupe' ) . ' %title' ); ?>
					<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'loupe' ) . '' ); ?>
				</nav><!-- #nav-above -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="entry-meta">
						<?php loupe_posted_on(); ?>
					</div><!-- .entry-meta -->
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'loupe' ), 'after' => '' ) ); ?>
					</div><!-- .entry-content -->
<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<footer id="entry-author-info">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'loupe_author_bio_avatar_size', 60 ) ); ?>
						<h2><?php printf( esc_attr__( 'About %s', 'loupe' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php printf( __( 'View all posts by %s &rarr;', 'loupe' ), get_the_author() ); ?>
						</a>
					</footer><!-- #entry-author-info -->
<?php endif; ?>
					<footer class="entry-utility">
						<?php loupe_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'loupe' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'loupe' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'loupe' ) . '</span>' ); ?></div>
				</nav><!-- #nav-below -->
				<?php comments_template( '', true ); ?>
		</div>
	</div>
<?php endwhile; // end of the loop. ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
