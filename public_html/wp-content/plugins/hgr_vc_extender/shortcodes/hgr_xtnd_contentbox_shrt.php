<?php
/*
	Shortcode: Content Box
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_content_box', 'hgr_contentbox');
function hgr_contentbox($atts) {
		
			/*
				 Empty vars declaration
			*/
			$output = $normal_style = $normal_bg = $normal_bd = $hover_bg = $hover_bd = $border_roundness = $hgr_contbox_id = $icon_type = $icon = $icon_img = $img_width = $icon_size = $icon_color = $icon_color_hover = $title_normal = $normal_title_color = $hover_title_color = $desc_normal = $normal_desc_color = $hover_desc_color = $normal_background_type = $normal_background_color = $normal_border_type = $normal_border_width = $normal_border_color = $hover_background_type = $hover_background_color = $hover_border_type = $hover_border_width = $hover_border_color = $nh_border_roundness = $custom_link = $contentbox_link = $cb_extra_class = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'				=>	'', 
				'icon'						=>	'', 
				'icon_img'					=>	'', 
				'img_width'				=>	'', 
				'icon_size'				=>	'', 
				'icon_color'				=>	'', 
				'icon_color_hover'			=>	'', 
				'title_normal'				=>	'', 
				'normal_title_color'		=>	'', 
				'hover_title_color'		=>	'', 
				'desc_normal'				=>	'', 
				'normal_desc_color'		=>	'', 
				'hover_desc_color'			=>	'', 
				'normal_background_type'	=>	'', 
				'normal_background_color'	=>	'', 
				'normal_border_type'		=>	'', 
				'normal_border_width'		=>	'', 
				'normal_border_color'		=>	'', 
				'hover_background_type'	=>	'', 
				'hover_background_color'	=>	'', 
				'hover_border_type'		=>	'', 
				'hover_border_width'		=>	'', 
				'hover_border_color'		=>	'', 
				'nh_border_roundness'		=>	'', 
				'custom_link'				=>	'', 
				'contentbox_link'			=>	'', 
				'cb_extra_class'			=>	'', 
			),$atts));
			

			
			if ( $nh_border_roundness !== '0') {
			$border_roundness .= 'style="border-radius:'.$nh_border_roundness.'px;-moz-border-radius:'.$nh_border_roundness.'px;-webkit-border-radius:'.$nh_border_roundness.'px;-o-border-radius:'.$nh_border_roundness.'px;"';
			}
			
			if( $icon_type == 'selector' && !empty($icon) ) {
				$content_icon = do_shortcode('[icon name="icon '.$icon.' normal-icon-cb" size="'.$icon_size.'px"]');
			}
			elseif($icon_type == 'custom' && !empty($icon_img)){
				$hgr_contentbox_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$content_icon = '<div class="hgr-contbox-customimg" style="width:'.$img_width.'px;">'.$hgr_contentbox_img_array['thumbnail'].'</div>';
			}
			
			switch($normal_background_type){
				case 'none':
					$normal_bg = 'none';
				break;
				
				case 'custom-normal-color':
					$normal_bg = $normal_background_color;
				break;
				
				default:
			}
			
			switch($normal_border_type){
				case 'none':
					$normal_bd = '0px';
				break;
				
				case 'custom-normal-border':
					$normal_bd = $normal_border_width.'px solid '.$normal_border_color;
				break;
				
				default:
			}
			
			switch($hover_background_type){
				case 'none':
					$hover_bg = 'none';
				break;
				
				case 'custom-hover-color':
					$hover_bg = $hover_background_color;
				break;
				
				default:
			}
			
			switch($hover_border_type){
				case 'none':
					$hover_bd = '0px';
				break;
				
				case 'custom-hover-border':
					$hover_bd = $hover_border_width.'px solid '.$hover_border_color;
				break;
				
				default:
			}
			
			$hgr_contbox_id = "hgr-contbox-".uniqid();
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery(".'.$hgr_contbox_id.'").css("background","'.$normal_bg.'").css("border","'.$normal_bd.'");
							jQuery(".'.$hgr_contbox_id.' .normal-icon-cb").css("color","'.$icon_color.'");
							jQuery(".'.$hgr_contbox_id.' h4").css("color","'.$normal_title_color.'");
							jQuery(".'.$hgr_contbox_id.' p").css("color","'.$normal_desc_color.'");
							
							
							jQuery(".'.$hgr_contbox_id.'").mouseenter(function() {
								jQuery(this).css("background","'.$hover_bg.'").css("border","'.$hover_bd.'");
							}).mouseleave(function() {
								jQuery(this).css("background","'.$normal_bg.'").css("border","'.$normal_bd.'");
							});
							
							jQuery(".'.$hgr_contbox_id.'").mouseenter(function(){
								jQuery(this).find(".normal-icon-cb").css("color","'.$icon_color_hover.'");
							}).mouseleave(function(){
								jQuery(this).find(".normal-icon-cb").css("color","'.$icon_color.'");
							});
							
							jQuery(".'.$hgr_contbox_id.'").mouseenter(function(){
								jQuery(this).find("h4").css("color","'.$hover_title_color.'");
								
							}).mouseleave(function(){
								jQuery(this).find("h4").css("color","'.$normal_title_color.'");
							});
							
							jQuery(".'.$hgr_contbox_id.'").mouseenter(function(){
								jQuery(this).find("p").css("color","'.$hover_desc_color.'");
								
							}).mouseleave(function(){
								jQuery(this).find("p").css("color","'.$normal_desc_color.'");
							});
						});
				</script>';
			
			$output .= '<div class="hgr-content-box '.$hgr_contbox_id.' '.$cb_extra_class.'" '.$border_roundness.'>';
				if($custom_link == '1'){
					$href = vc_build_link($contentbox_link);
					if($href['url'] !== '') {
						$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
						$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
					}
					$output .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.'>';
						if($icon !== '' || $icon_img !== '') {
							$output .= $content_icon;
						}
						if(!empty($title_normal)) {
							$output .='<h4>'.$title_normal.'</h4>';
						}
						if(!empty($desc_normal)) {
							$output .='<p>'.$desc_normal.'</p>';
						}
					$output .= '</a>';
				} elseif ($custom_link == '#') {
					$output .= '<span>';
						if($icon !== '' || $icon_img !== '') {
							$output .= $content_icon;
						}
						if(!empty($title_normal)) {
							$output .='<h4>'.$title_normal.'</h4>';
						}
						if(!empty($desc_normal)) {
							$output .='<p>'.$desc_normal.'</p>';
						}
					$output .= '</span>';
				}
			$output .= '<div class="clear"></div> </div>';
			
			/*
				Return the output
			*/
			return $output;		
		}
?>