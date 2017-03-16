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
<div class="row blog blogPosts <?php echo (isset($hgr_options['blog_color_scheme']) ? $hgr_options['blog_color_scheme'] : '');?>" id="blogPosts">
  <div class="container"> 
    <!-- posts -->
    <div class="col-md-12">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div <?php post_class('post'); ?>>
       
        <?php 
           foreach((get_the_category()) as $category) { 
             $category = $category->cat_name; 
             $category = trim($category);
           }
          if ($category === "news") {
        ?>
        <div class="vc_row wpb_row vc_row-fluid page-header">
            <img src="<?php the_field('inner_image'); ?>">
       </div>
        <!-- Display the Post's content from category careers. -->
        <div class="entry">
        <h1 style="text-align: center;"><?php the_title(); ?></h1>
      
          <div class="row post-content">
          <?php the_field('full_descriptiom'); ?>
          </div>
        </div>
        <?php 
          } else if ($category === "relax") {
        ?>
        <div class="vc_row wpb_row vc_row-fluid page-header">
          <img src="<?php the_field('inner_image'); ?>">
        </div>
        <!-- Display the Post's content from category insights. -->

        <div class="entry">
          <h1 style="text-align: center;"><?php the_title(); ?></h1>
          <div class="row post-content">
            <div class="col-sm-12"><?php the_field('full_description'); ?></div>
          </div>
        </div>
        <?php 
          } else if ($category === "guestbook") {
        ?>
         <div class="vc_row wpb_row vc_row-fluid page-header">
          <img src="<?php the_field('inner_image'); ?>">
        </div>
        <!-- Display the Post's content from category insights. -->
        <div class="entry">
          <h1 style="text-align: center;"><?php the_title(); ?></h1>
          <div class="row post-content">
            <div class="col-sm-12"><?php the_field('full_description'); ?></div>
          </div>
         <div class="row subscribe">
         <?php echo do_shortcode( '[contact-form-7 id="183" title="Contact form guestbook"]' ); ?>
        </div>
        </div>
        <?php
          } else {
            echo '<h1>Wrong Categery</h1>';
          }
        ?>
        <?php // Paginated post
						$args = array(
							'before'           => '<ul class="pagination">',
							'after'            => '</ul>',
							'link_before'      => '',
							'link_after'       => '',
							'next_or_number'   => 'number',
							'separator'        => ' ',
							'nextpagelink'     => esc_html__( 'Next page','hatch' ),
							'previouspagelink' => esc_html__( 'Previous page','hatch' ),
							'pagelink'         => '%',
							'echo'             => 1
						);
						wp_link_pages( $args );
					 ?>
        <div class="clear"></div>
     
        <!-- Display a comma separated list of the Post's Categories. --> 
        
      </div>
      <!-- closes the first div box --> 
      
      <!-- comments-->
      <?php if(is_paged()) : ?>
      <?php endif;?>
      <?php if(is_paged()) : ?>
      <?php endif;?>
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