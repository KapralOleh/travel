<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

?>

<?php do_action( 'woocommerce_product_thumbnails' ); ?>

<?php if( is_plugin_active('hgr_woozoom/hgr_woozoom.php') ) : ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		"use strict";
		$("#woocommerce-main-image").imageLens({ lensSize: 300 });
	});
</script>
<?php endif;?>

<div class="hgr_main_image <?php echo ($attachment_ids ? 'has_thumbnails' : '');?>">

	<?php
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
			
			$fullImage      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fullsize' );
				
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'				=> $image_title,
				'alt'				=> $image_title,
				'id'					=> 'woocommerce-main-image',
				'data-imageSrc'		=> $fullImage[0],
				'width'				=> '400px',
				'height'				=> '400px',
				) );

			$attachment_count = count( $product->get_gallery_attachment_ids() );
				
				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}
			
			if( is_plugin_active('hgr_woozoom/hgr_woozoom.php') ) {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s">%s</a>', $image_link, $image_caption, $image ), $post->ID );
			} else {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
			}

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', "hatch" ) ), $post->ID );

		}
	?>
</div>