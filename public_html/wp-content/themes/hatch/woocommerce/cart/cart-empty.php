<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$hgr_options		=	get_option( 'redux_options' );
	$custom_error_page	=	(isset($hgr_options['custom_empty_cart']) ? $hgr_options['custom_empty_cart'] : '');

?>


<?php
	// Get metaboxes values from database
	$hgr_page_bgcolor		=	get_post_meta( $custom_error_page, '_hgr_page_bgcolor', true );
	$hgr_page_top_padding	=	get_post_meta( $custom_error_page, '_hgr_page_top_padding', true );
	$hgr_page_btm_padding	=	get_post_meta( $custom_error_page, '_hgr_page_btm_padding', true );
	$hgr_page_color_scheme	=	get_post_meta( $custom_error_page, '_hgr_page_color_scheme', true );
	$hgr_page_height		=	get_post_meta( $custom_error_page, '_hgr_page_height', true );
	
	// Does this page have a featured image to be used as row background with paralax?!
 	$src 					=	wp_get_attachment_image_src( get_post_thumbnail_id($custom_error_page), array( 5600,1000 ), false, '' );

 	if( !empty($src[0]) ) {
		$parallaxImageUrl 	=	" background-image:url('".$src[0]."'); ";
		$parallaxClass		=	' parallax ';
		$backgroundColor	=	'';
	} elseif( !empty($hgr_page_bgcolor) ) {
		$parallaxImageUrl 	=	'';
		$parallaxClass		=	' ';
		$backgroundColor	=	' background-color:'.$hgr_page_bgcolor.'!important; ';
	} else {
		$parallaxImageUrl 	=	'';
		$parallaxClass		=	' ';
		$backgroundColor	=	' ';
	}
 ?>
 <script>
 jQuery(document).ready(function() {
 	//var windowHeight = jQuery(window).height(); //retrieve current window height
	//jQuery('.standAlonePage').css('min-height', windowHeight);
 })
 </script>


    <div id="<?php echo esc_html($post->post_name);?>" class="row standAlonePage <?php echo esc_attr($parallaxClass);?> <?php echo esc_attr($hgr_page_color_scheme);?>"  style=" <?php echo esc_attr($parallaxImageUrl); echo esc_attr($backgroundColor); echo ( !empty($hgr_page_height) ? ' height:'.esc_attr($hgr_page_height).'px!important; ' : ''); echo ( !empty($hgr_page_top_padding) ? ' padding-top:'.esc_attr($hgr_page_top_padding).'px!important;' : '' ); echo ( !empty($hgr_page_btm_padding) ? ' padding-bottom:'.esc_attr($hgr_page_btm_padding).'px!important;' : '' );?> ">
  <div class="container"> 
    <!-- posts -->
    <div class="col-md-12">
      <?php //wc_print_notices();?>
      <?php
      	if($custom_error_page){	
			$post = get_post($custom_error_page); 
			$content = apply_filters('the_content', $post->post_content); 
			echo $content;  
		} else {
      ?>
      
      <p class="cart-empty"><?php esc_html_e( 'Your cart is currently empty...', "hatch" ) ?></p>

		<?php do_action( 'woocommerce_cart_is_empty' ); ?>
		<p class="return-to-shop"><a class=" wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Return To Shop', "hatch" ) ?></a></p>
      <?php
		}
	  ?>
      
    </div>
    <!-- / posts --> 
    

  </div>
</div>

      