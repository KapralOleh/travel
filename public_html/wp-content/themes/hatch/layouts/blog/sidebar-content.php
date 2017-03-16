<?php
/**
 * The template for displaying all posts having layout: sidebar/content.
 *
 * @package Hatch Theme
 */
 ?>
 <!-- blog/sidebar-content.php -->
 <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'single' ); ?>

            <?php
                // If comments are open or we have at least one comment, load up the comment template
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
 </div><!-- #primary -->

 <?php 
 get_sidebar();
 ?>
