<?php
/**
 * Hatch Theme: Home page for site or blog
 * @package WordPress
 * @subpackage Hatch Theme
 * @since 1.0
 */
 
	get_header();
	
// Include framework options
 $hgr_options = get_option( 'redux_options' );
 
 // Get metaboxes values from database
 $this_page_id 			=	get_option('page_for_posts');
 $hgr_page_color_scheme	=	get_post_meta( $this_page_id, '_hgr_page_color_scheme', true );
 ?>
<!-- index.php -->

<!-- Header Image -->
<?php if (get_header_image() != '') : ?>

<div class="header_image_container"> <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="header image" class="header_image" />
  <div class="headerWelcome">
    <h1>
      <?php bloginfo('name'); ?>
    </h1>
    <h2><a href="#" class="readTheBlogBtn"><?php esc_html_e( 'Read the blog', 'hatch' );?></a></h2>
  </div>
</div>
<?php endif;?>
<!-- Header Image End --> 

<!-- blog content -->
<div class="row blogPosts <?php echo (isset($hgr_options['blog_color_scheme']) ? esc_attr($hgr_options['blog_color_scheme']) : '');?>" id="blogPosts">
  <div class="container"> 
    <!-- posts -->
    <div class="col-md-9">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php 
	  	$format = get_post_format();
	  ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
        <?php 
			if ( has_post_thumbnail() ) {
			  the_post_thumbnail('full', array('class' => 'img-responsive'));
			} 
		 ?>
        <?php if($format != 'aside') : ?>
        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
          <?php the_title(); ?>
          </a></h1>
        <?php endif;?>
        <small> <span class="highlight"><i class="icon blog-date"></i>
        <?php the_time('F jS, Y') ?>
        </span> <span class="highlight"><i class="icon blog-user"></i>
        <?php esc_html_e('Posted by ', 'hatch');?>
        <?php the_author_posts_link() ?>
        </span> <span class="highlight"><i class="icon blog-category"></i>
        <?php the_category(', '); ?>
        </span> <span class="highlight"><i class="icon blog-comments"></i>
        <?php
			$comments_number = get_comments_number();
			if ( 1 === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'hatch' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s comment on &ldquo;%2$s&rdquo;',
						'%1$s comments on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'hatch'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
		?>
        </span> </small>
        <div class="entry">
          <?php if(has_excerpt()) : ?>
          <?php the_excerpt(); ?>
          <?php else : ?>
          <?php the_content(); ?>
          <?php endif;?>
        </div>
        <div class="entry-meta">
          <?php the_tags(); ?>
        </div>
        <?php comments_template(); ?>
        <?php if(is_paged()) : ?>
        <?php paginate_comments_links(); ?>
        <?php endif;?>
      </div>
      <?php if(is_paged()) : ?>
      <div class="navigation">
        <div class="alignleft">
          <?php previous_posts_link( esc_html__('&larr; Previous', 'hatch') ) ?>
        </div>
        <div class="alignright">
          <?php next_posts_link( esc_html__('Next &rarr;', 'hatch'),'') ?>
        </div>
      </div>
      <?php endif;?>
      <?php endwhile; ?>
      <?php else: ?>
      <p>
        <?php esc_html_e('Sorry, no posts matched your criteria.', 'hatch'); ?>
      </p>
      <?php endif; ?>
      <?php wp_reset_postdata();?>
    </div>
    <!-- / posts --> 
    
    <!-- sidebar -->
    <div class="col-md-3">
      <?php 
		get_sidebar();
	 ?>
    </div>
    <!-- / sidebar --> 
  </div>
</div>
<!-- blog content end -->

<?php 
 	get_footer();
 ?>
