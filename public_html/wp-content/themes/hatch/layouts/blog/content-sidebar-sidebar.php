<?php
/**
 * The template for displaying all posts having layout like content/sidebar/sidebar.
 *
 * @package Hatch Theme
 */
 ?>

 <?php 
 get_sidebar('second');
 ?>
 
 <?php 
 get_sidebar();
 ?>

 <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', ( is_category() || is_home() || is_archive() || is_date() || is_tag() ? 'category' : 'single') ); ?>

            <?php
                // If comments are open or we have at least one comment, load up the comment template
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
 </div><!-- #primary -->
