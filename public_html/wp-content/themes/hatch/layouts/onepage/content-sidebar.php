<?php
/**
 * The template for displaying all onepages having layout: content/sidebar.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Hatch Theme
 */
 ?>

 <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
  	wp_reset_postdata();
	$homePageID = get_the_ID();
 	$args = array(	'post_type'			=> 'page',
					'posts_per_page'	=> -1,
					'post_parent'		=> $homePageID ,
					'post__not_in'		=> array($homePageID),
					'order'				=> 'ASC',
					'orderby'			=> 'menu_order'
				 );
 	$parent = new WP_Query( $args );
	
 ?>
 <?php
	if ( $parent->have_posts() ) : 
 ?>
 <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
 <?php $page_template = str_replace('page_','',str_replace('.php','',basename( get_page_template() ))); ?>
 <?php if($page_template && $page_template !='page') : ?>
 <?php get_template_part( $page_template, get_post_format() ); ?>
 <?php wp_reset_postdata(); ?>
 <?php else : ?>
 <?php get_template_part( 'loop', get_post_format() ); ?>
 <?php wp_reset_postdata(); ?>
 <?php endif;?>
 <?php endwhile; ?>
 <?php 
 	endif; 
	wp_reset_postdata(); 
 ?>

    </main><!-- #main -->
 </div><!-- #primary -->

 <?php 
 get_sidebar();
 ?>