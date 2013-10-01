<?php
/**
 * Template Name: Categories
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

//get_header(); ?>

<?php $gallery = get_terms('gallery', 'hide_empty=1'); ?>
  <ul>
    <?php foreach( $gallery as $theme ) : ?>
      <li>
        <a href="<?php echo get_term_link( $theme->slug, 'gallery' ); ?>">
          <?php echo $theme->name; ?>
        </a>
        <ul>
          <?php 
            $wpq = array(
            'numberposts' => 1,
            'orderby' => 'rand', 
            'post_type' => 'photo', 
            'taxonomy' => 'gallery', 
            'term' => $theme->slug );
            
            $theme_posts = new WP_Query ($wpq);
          ?>
          <?php foreach( $theme_posts->posts as $post ) : ?>
            <li>
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <?php echo $post->post_title; ?>
                <img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80&s=1" alt="<?php the_title(); ?>" />
              </a>
            </li>
          <?php endforeach ?>
        </ul>
      </li>
    <?php endforeach ?>
  </ul>
  
<?php 

echo "==================================== \r\n \n";


$query = new WP_Query( array( 'gallery' => 'travel' ) );
while ($query->have_posts()) : $query->the_post();
?>
<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80&s=1" alt="<?php the_title(); ?>" />

<?php // } 
					endwhile;
					
					echo "==================================== \r\n \n";
					
					 
wp_list_categories( 'taxonomy=gallery' );
echo "==================================== \r\n \n";
 ?>
		<div id="container" class="one-column">
			<div id="content" role="main">

<?php
	$args = array(
					'post_type' => 'photo',
					'orderby' => 'rand',
					'posts_per_page' => -1); // display all	
													 
					$the_query = new WP_Query($args);
					while ($the_query->have_posts()) : $the_query->the_post();
					
 $galVar = get_the_terms($post->ID, 'gallery');
		if($galVar){
			foreach ($galVar as $gal => $galitem):
				echo  $galitem->name;
				echo get_post_meta($post->ID, 'single_photo', true);
				endforeach;
		}?>
				

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
