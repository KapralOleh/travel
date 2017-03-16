 <?php
/**
 * Hatch Theme: Blog page, posts by category
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

<div class="row blog blogPosts <?php echo (isset($hgr_options['blog_color_scheme']) ? $hgr_options['blog_color_scheme'] : '');?>">
  <div class="container"> 
    <!-- posts -->
    <div class="col-md-12">
      <?php 
      $i = 0;
	?> 
      <?php 

    foreach((get_the_category()) as $category) { 
      $category = $category->cat_name; 
      $category = trim($category);
    }
    if ($category === "countries") {
    ?>
      <h1>Країни</h1>
     <?php $posts = query_posts( $query_string . '&orderby=title&order=asc' ); ?>
    
    <?php
    } else if ($category === "guestbook") {
    ?>
      <h1>Відгуки</h1>
    <?php
    } else if ($category === "news") {
    ?>
      <h1>Новини</h1>
    <?php
    } else if ($category === "relax") {
    ?>
      <h1>Відпочивай з нами</h1>
    <?php
    } else {
      echo '<h1>Categery</h1>';
    }
?>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $i++;?>
        <?php 
          if ($category === "countries") {
        ?>
      <div class="post-layout countries>">
          
          <div class="wpb_column vc_column_container image-holder vc_col-sm-3">
            <a class="countries-link" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
              <?php 
                   if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                      the_post_thumbnail('full', array('class' => 'img-responsive'));
                   } 
              ?>
             </a>
          </div>
          
      
      </div>
      <?php
        } else if ($category === "guestbook") {
      ?>

        <div class="guestbook-posts wpb_column vc_column_container vc_col-sm-4">
          <?php 
               if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                  the_post_thumbnail('full', array('class' => 'img-responsive'));
               } 
          ?>
          <div class="entry">
             <!-- Display the Title as a link to the Post's permalink. -->
            <h2 >
                <?php the_title();?>
            </h2>
            <!-- Display the Post's content in a div box. -->
            <?php if(has_excerpt()) : ?>
            <?php the_excerpt(); ?>
            <?php else : ?>
            <?php the_content();?>
            <?php endif;?>
            <a class="news-link" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
              читати >
            </a>
          </div>
        </div>
      <?php
        } else if ($category === "news") {
      ?>
      <div class="news-posts vc_row vc_row-o-equal-height vc_row-o-content-middle vc_row-flex <?php if ($i%2 ==0) echo 'reverse'; ?>">
        <div class="wpb_column vc_column_container vc_col-sm-6">
          <?php 
               if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                  the_post_thumbnail('full', array('class' => 'img-responsive'));
               } 
          ?>
        </div>
        <div class="wpb_column vc_column_container vc_col-sm-6">
            <div class="entry">
              <!-- Display the Title as a link to the Post's permalink. -->
              <h2 >
                  <?php the_title();?>
              </h2>
              <!-- Display the Post's content in a div box. -->
                <?php if(has_excerpt()) : ?>
                <?php the_excerpt(); ?>
                <?php else : ?>
                <?php the_content();?>
                <?php endif;?>
                <a class="news-link" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                  читати >
                </a>
            </div>
          </div>
        </div>
        <?php
          } else if ($category === "relax") {
        ?>
        <ul class="tabs property-type-tabs">
          <li><a onclick="initMap('Europe',globalZoom, globalLatLng)" href="">Європа</a><span></span></li>
          <li><a onclick="initMap('Asia',globalZoom, globalLatLng)" href="">Азія</a><span></span></li>
          <li><a onclick="initMap('America',globalZoom, globalLatLng)" href="">Америка</a><span></span></li>
          <li><a onclick="initMap('All',globalZoom, globalLatLng)" href="">All PROPERTIES</a><span></span></li>
        </ul>
        <div style="height:500px;" id="relaxMap"></div>
      <?php
        } else {
          echo '<h1> Categery</h1>';
        }
      ?>
      <?php endwhile; ?>
     
      <?php else: ?>
     
      <?php endif; ?>
    </div>
    <!-- / posts --> 
    <!-- / sidebar --> 
  </div>
</div>
<?php 
 	get_footer();
 ?>