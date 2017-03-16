<?php
/*
	Shortcode: Advanced Image
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_advimage', 'hgr_advimage' );
function hgr_advimage ($atts) {
			/*
				Include required JS and CSS files
			*/
			wp_enqueue_script('hgr-vc-hoverdir');
			wp_enqueue_script('hgr-advimage');
			
			/*
				 Empty vars declaration
			*/
			$output = $hgr_advimage_image = $hgr_advimage_overlaycolor = $hgr_advimage_overlaycontent = $hgr_advimage_overlaylink = $hgr_advimage_overlaytextcolor = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'hgr_advimage_image'				=>	'',
				'hgr_advimage_overlaycolor'		=>	'#fff',
				'hgr_advimage_overlaycontent'	=>	'',
				'hgr_advimage_overlaylink'		=>	'',
				'hgr_advimage_overlaytextcolor'	=>	'',
			), $atts));
			
			$image_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $hgr_advimage_image, 'thumb_size' => 'full', 'class' => "" ) ); 
			// Use like: $image_array['thumbnail']
			
			
			
			$output	.=	'<div class="hgr_advimage">';
				if(!empty($hgr_advimage_overlaylink)) {
					$href = vc_build_link($hgr_advimage_overlaylink);
					$output .= '<a href="'.$href['url'].'" title="'.$href['title'].'" target="'.$href['target'].'" style="color:'.$hgr_advimage_overlaytextcolor.';">';
				}
				else {
					$output .=	'<a href="#" style="color:'.$hgr_advimage_overlaytextcolor.';">';
				}
				$output.=	$image_array['thumbnail'];
				$output.=	'<div class="hgr_advimage_overlay" style="background-color:'.$hgr_advimage_overlaycolor.';">
								<span>'.$hgr_advimage_overlaycontent.'</span>
							</div>';
			$output	.=	'</a></div>';
						
			return $output;
		}
?>