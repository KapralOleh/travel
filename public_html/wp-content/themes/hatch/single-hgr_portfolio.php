<?php
/**
 * Hatch Theme: Blog page, single post display
 * @package WordPress
 * @subpackage Hatch Theme
 * @since 1.0
 */
 ?>
<?php 
	get_header();
 ?>
<?php
	$hgr_options = get_option( 'redux_options' );
 ?>

<!-- single.php -->
<div class="row blog <?php echo (isset($hgr_options['blog_color_scheme']) ? $hgr_options['blog_color_scheme'] : '');?>" id="blogPosts">
  <div class="container"> 
    <!-- posts -->
    <div class="col-md-12">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div <?php post_class('post'); ?>>

        <!-- Display the Post's content in a div box. -->
        <div class="portfolio_entry">
          <?php the_content(); ?>
        </div>

        <div class="clear"></div>

        
      </div>
      <!-- closes the first div box --> 
      
      <?php endwhile; else: ?>
      <p>
        <?php esc_html_e('Sorry, no posts matched your criteria.', 'hatch'); ?>
      </p>
      <?php endif; ?>
    </div>
    <!-- / posts --> 
    

  </div>
</div>
<?php 
 	get_footer();
 ?>