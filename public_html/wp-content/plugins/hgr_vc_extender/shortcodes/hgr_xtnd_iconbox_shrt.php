<?php
/*
	Shortcode: IconBox element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_icon_box', 'hgr_iconbox');
function hgr_iconbox($atts) {
		
			/*
				 Empty vars declaration
			*/
			$output = $normal_style = $normal_bg = $normal_bd = $hover_bg = $hover_bd = $border_roundness =$icon_type = $icon = $icon_size = $icon_img = $img_width = $title_text = $subheading_text = $its_normal_color = $normal_background_type = $normal_background_color = $normal_border_type = $normal_border_width = $normal_border_color = $its_hover_color = $hover_background_type = $hover_background_color = $hover_border_type = $hover_border_width = $hover_border_color = $ib_border_roundness = $custom_link = $iconbox_link = $ib_extra_class = $hgr_iconbox_img_array = '';
			
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'					=>	'',
				'icon'						=>	'',
				'icon_size'					=>	'',
				'icon_img'					=>	'',
				'img_width'					=>	'',
				'title_text'				=>	'',
				'subheading_text'			=>	'',
				'its_normal_color'			=>	'',
				'normal_background_type'	=>	'',
				'normal_background_color'	=>	'',
				'normal_border_type'		=>	'',
				'normal_border_width'		=>	'',
				'normal_border_color'		=>	'',
				'its_hover_color'			=>	'',
				'hover_background_type'		=>	'',
				'hover_background_color'	=>	'',
				'hover_border_type'			=>	'',
				'hover_border_width'		=>	'',
				'hover_border_color'		=>	'',
				'ib_border_roundness'		=>	'',
				'custom_link'				=>	'',
				'iconbox_link'				=>	'',
				'ib_extra_class'			=>	'',
			),$atts));
			
			/*
				Do the icon
			*/
			
			if( $icon_type == 'selector' && !empty($icon) ) {
				$content_icon = do_shortcode('[icon name="icon '.$icon.'" size="'.$icon_size.'px"]');
			}
			elseif($icon_type == 'custom' && !empty($icon_img)){
				$hgr_iconbox_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$content_icon = '<div class="hgr-iconbox-customimg" style="width:'.$img_width.'px;margin:auto;">'.$hgr_iconbox_img_array['thumbnail'].'</div>';
			}
			
			if ($ib_border_roundness !== '0') {
				$border_roundness .= 'style="border-radius:'.$ib_border_roundness.'px;-moz-border-radius:'.$ib_border_roundness.'px;-webkit-border-radius:'.$ib_border_roundness.'px;-o-border-radius:'.$ib_border_roundness.'px;"';
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
					$normal_bd = '0px;';
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
			
			$iconbox_id = "hgr-icnbox-".uniqid();
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery(".'.$iconbox_id.'").css("background","'.$normal_bg.'").css("border","'.$normal_bd.'");
							jQuery(".'.$iconbox_id.' a").css("color","'.$its_normal_color.'");
							jQuery(".'.$iconbox_id.' span").css("color","'.$its_normal_color.'");
							jQuery(".'.$iconbox_id.' .hgr-iconbox-title").css("color","'.$its_normal_color.'");
							jQuery(".'.$iconbox_id.' .hgr-iconbox-bar").css("background","'.$its_normal_color.'");
							
							
							jQuery(".'.$iconbox_id.'").mouseenter(function() {
								jQuery(this).css("background","'.$hover_bg.'").css("border","'.$hover_bd.'");
								jQuery(this).find("a").css("color","'.$its_hover_color.'");
								jQuery(this).find("span").css("color","'.$its_hover_color.'");
								jQuery(this).find(".hgr-iconbox-title").css("color","'.$its_hover_color.'");
								jQuery(this).find(".hgr-iconbox-bar").css("background","'.$its_hover_color.'");
							}).mouseleave(function() {
								jQuery(this).css("background","'.$normal_bg.'").css("border","'.$normal_bd.'");
								jQuery(this).find("a").css("color","'.$its_normal_color.'");
								jQuery(this).find("span").css("color","'.$its_normal_color.'");
								jQuery(this).find(".hgr-iconbox-title").css("color","'.$its_normal_color.'");
								jQuery(this).find(".hgr-iconbox-bar").css("background","'.$its_normal_color.'");
							});
						});
				</script>';
			
			$output .= '<div class="hgr-iconbox '.$iconbox_id.' '.$ib_extra_class.'" '.$border_roundness.'>';
				if($custom_link !== '#'){
					$href = vc_build_link($iconbox_link);
					if($href['url'] !== "") {
						$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
						$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
					}
					$output .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.'>';
					if($icon !== '' || $icon_img !== '') {
						$output .='<div class="normal-icon-ib">'.$content_icon.'</div>';
					}
					$output .= '<span class="hgr-iconbox-bar"></span>';
					if(!empty($title_text)) {
						$output .='<h4 class="hgr-iconbox-title">'.$title_text.'</h4>';
					}
					if(!empty($subheading_text)) {
						$output .='<p class="hgr-iconbox-subheading">'.$subheading_text.'</p>';
					}
					$output .='</a>';
				}
				else {
					$output .= '<span>';
					if($icon !== '' || $icon_img !== '') {
						$output .='<div class="normal-icon-ib">'.$content_icon.'</div>';
					}
					$output .= '<span class="hgr-iconbox-bar"></span>';
					if(!empty($title_text)) {
						$output .='<h4 class="hgr-iconbox-title">'.$title_text.'</h4>';
					}
					if(!empty($subheading_text)) {
						$output .='<p class="hgr-iconbox-subheading">'.$subheading_text.'</p>';
					}
					$output .= '</span>';
				}
				
				
			$output .= '</div>';
			
			/*
				Return the output
			*/
			return $output;		
		}

?>