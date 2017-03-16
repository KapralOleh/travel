 <?php
 
 	// Loop Page
	$hgr_options = get_option( 'redux_options' );
 ?>
 <!-- Loop Page with ID: <?php the_ID(); ?> -->
 
 <?php
	// Get metaboxes values from database
	$hgr_page_bgcolor			=	get_post_meta( get_the_ID(), '_hgr_page_bgcolor', true );
	$hgr_page_top_padding		=	get_post_meta( get_the_ID(), '_hgr_page_top_padding', true );
	$hgr_page_btm_padding		=	get_post_meta( get_the_ID(), '_hgr_page_btm_padding', true );
	$hgr_page_color_scheme		=	get_post_meta( get_the_ID(), '_hgr_page_color_scheme', true );
	$hgr_page_height			=	get_post_meta( get_the_ID(), '_hgr_page_height', true );
	
	// Does this page have a featured image to be used as row background with paralax?!
 	$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array( 5600,1000 ), false, '' );

 	if( !empty($src[0]) ) {
		$parallaxImageUrl =	" background-image:url('".$src[0]."'); ";
		$parallaxClass		=	' parallax ';
		$backgroundColor	=	'';
	} elseif( !empty($hgr_page_bgcolor) ) {
		$parallaxImageUrl =	'';
		$parallaxClass		=	' ';
		$backgroundColor	=	' background-color:'.$hgr_page_bgcolor.'!important; ';
	}else {
		$parallaxImageUrl =	'';
		$parallaxClass		=	'';
		$backgroundColor	=	'';
	}
 ?>
 <div id="<?php echo esc_html($post->post_name);?>" class="pagesection row <?php echo esc_attr($parallaxClass);?> <?php echo esc_attr($hgr_page_color_scheme);?>"  style=" <?php echo esc_attr($parallaxImageUrl);?> <?php echo esc_attr($backgroundColor);?> <?php echo ( !empty($hgr_page_height) ? ' height:'.esc_attr($hgr_page_height).'px!important; ' : '');?> <?php echo ( !empty($hgr_page_top_padding) ? ' padding-top:'.esc_attr($hgr_page_top_padding).'px!important;' : '' );?> <?php echo ( !empty($hgr_page_btm_padding) ? ' padding-bottom:'.esc_attr($hgr_page_btm_padding).'px!important;' : '' );?> ">
  <div class="col-md-12" >
    <div class="container">
      <div class="slideContent gu12">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</div>
 <!-- / Page with ID: <?php the_ID(); ?> -->