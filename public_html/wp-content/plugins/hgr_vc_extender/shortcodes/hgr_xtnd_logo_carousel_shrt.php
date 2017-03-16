<?php
/*
	Shortcode: Logo carousel element
	Based on: www.owlgraphic.com/owlcarousel/
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

/*
	Parent element
*/
add_shortcode( 'hgr_logocarousel', 'hgr_logocarousel' );
function hgr_logocarousel($atts, $content = null ) {
		wp_enqueue_script('hgr-vc-logocarousel');
		
		/*
			 Empty vars declaration
		*/
		$output = $carousel_items_number_max = $carousel_items_number_desktop = $carousel_items_number_desktop_small = 
		$carousel_items_number_tablet = $carousel_autoplay = $carousel_extra_class = $carousel_ap = '';
		
		
		/*
			WordPress function to extract shortcodes attributes
			Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
		*/
		extract(shortcode_atts(array(
			'carousel_items_number_max'				=> '',
			'carousel_items_number_desktop'			=> '', 
			'carousel_items_number_desktop_small'	=> '',
			'carousel_items_number_tablet'			=> '',
			'carousel_autoplay'						=> '',
			'carousel_extra_class'					=> ''
		), $atts));
		
		
		/*
			Auto-play or not?!
		*/
		if($carousel_autoplay == 'yes') {
			$carousel_ap = 'true';
		}
		elseif($carousel_autoplay !== 'yes') {
			$carousel_ap = 'false';
		}
		
		$output .= '<script>
			jQuery(document).ready(function() {

				var hgr_logocarousel = jQuery("#hgr-logocarousel");
			 
				hgr_logocarousel.owlCarousel({
					items : '.$carousel_items_number_max.',
					itemsDesktop : [1199,'.$carousel_items_number_desktop.'],
					itemsDesktopSmall : [979,'.$carousel_items_number_desktop_small.'],
					itemsTablet: [768,'.$carousel_items_number_tablet.'],
					itemsMobile : [479,1],
					
					//Autoplay
					autoPlay : '.$carousel_ap.',
					stopOnHover : true,
				});
		 
			});
		</script>';
		
		$output .= '<div id="hgr-logocarousel" class="owl-carousel '.$carousel_extra_class.'" style="">';
			$output .= do_shortcode($content);
		$output .= '</div>';
		
		/*
			Return the output
		*/
		return $output;
	}
		
/*
	Child element
*/
add_shortcode( 'hgr_logocarousel_item', 'hgr_logocarousel_item' );
function hgr_logocarousel_item($atts,$content = null) {
		
		/*
			 Empty vars declaration
		*/
		$output = $item_image = $item_link_settings = $item_link = '';
		
		
		/*
			WordPress function to extract shortcodes attributes
			Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
		*/
		extract(shortcode_atts(array(
			'item_image'			=>	'',
			'item_link_settings'	=>	'', 
			'item_link'			=>	'',
		), $atts));
		
		/*
			Get the image...
		*/
		$logocarousel_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $item_image, 'thumb_size' => 'full', 'class' => "" ) );

		$output .= '<div class="hgr_carousel_item" style="text-align:center;">';
		switch($item_link_settings){
			case 'link-off':
				$output .= $logocarousel_img_array['thumbnail'];
			break;
			
			case 'link-on':
				$href = vc_build_link($item_link);
				if($href['url'] !== '') {
					$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
					$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
				}
				$output .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.' class="hoverzoom">';
				$output .= $logocarousel_img_array['thumbnail'];
				$output .= '</a>';
			break;
		}
		$output .= '</div>';
		
		/*
			Return the output
		*/
		return $output;
	}

if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_hgr_logocarousel extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_hgr_logocarousel_item extends WPBakeryShortCode {}
}
?>