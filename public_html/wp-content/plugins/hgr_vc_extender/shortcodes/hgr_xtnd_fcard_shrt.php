<?php
/*
	Shortcode: Flip Card
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_flip_card', 'hgr_flipcard_shortcode');
function hgr_flipcard_shortcode($atts) {
			/*
				 Empty vars declaration
			*/
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_size = $icon_background_type = $icon_background_color = $icon_background_size = $icon_background_roundness = $icon_front_place = $icon_type_back = $icon_img_back = $img_width_back = $icon_back = $icon_color_back = $icon_size_back = $bpicon_background_type = $bpicon_background_color = $bpicon_background_size = $bpicon_background_roundness = $icon_back_place = $title_front = $front_title_color = $desc_front = $front_desc_color = $front_background_type = $front_background_color = $front_border_type = $front_border_width = $front_border_color = $front_border_roundness = $title_back = $back_title_color = $desc_back = $back_desc_color = $back_background_color = $back_border_type = $back_border_width = $back_border_color = $back_border_roundness = $button_text = $button_link = $animation = $font_size_icon = $custom_link = $button_bg = $button_txt = $custom_link_back = $back_icon_link = $height_type = $box_height = $flip_card_style = $fb_extra_class = $output = $link_style = $front_style = $front_bg = $front_icon_display = $front_title_display = $front_desc_display = $back_icon_display = $back_icon_display_notext = $back_title_display = $back_desc_display = $back_style = $back_bg = $height ='';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'						=>	'',
				'icon'								=>	'',
				'icon_img'							=>	'',
				'img_width'						=>	'',
				'icon_size'						=>	'',				
				'icon_color'						=>	'',
				'icon_background_type'			=>	'',
				'icon_background_color'			=>	'',
				'icon_background_size'			=>	'',
				'icon_background_roundness'		=>	'',
				'icon_front_place'					=>	'',
				'icon_type_back'					=>	'',
				'icon_back'						=>	'',
				'icon_img_back'					=>	'',
				'img_width_back'					=>	'',
				'icon_size_back'					=>	'',				
				'icon_color_back'					=>	'',
				'bpicon_background_type'			=>	'',
				'bpicon_background_color'			=>	'',
				'bpicon_background_size'			=>	'',
				'bpicon_background_roundness'	=>	'',
				'icon_back_place'					=>	'',
				'title_front'						=>	'',
				'front_style'						=>	'',
				'front_title_color'				=>	'',
				'desc_front'						=>	'',
				'front_desc_color'					=>	'',
				'front_background_type'			=>	'',
				'front_background_color'			=>	'',
				'front_border_type'				=>	'',
				'front_border_width'				=>	'',
				'front_border_color'				=>	'',
				'front_border_roundness'			=>	'',
				'title_back'						=>	'',
				'back_title_color'					=>	'',
				'desc_back'						=>	'',
				'back_desc_color'					=>	'',
				'back_background_type'			=>	'',
				'back_background_color'			=>	'',
				'back_border_type'					=>	'',
				'back_border_width'				=>	'',
				'back_border_color'				=>	'',
				'back_border_roundness'			=>	'',
				'custom_link'						=>	'',
				'button_text'						=>	'',
				'button_link'						=>	'',
				'button_bg'						=>	'',
				'button_txt'						=>	'',
				'custom_link_back'					=>	'',
				'back_icon_link'					=>	'',
				'height_type'						=>	'',
				'box_height'						=>	'',
				'flip_card_style'					=>	'',
				'fb_extra_class'					=>	'',
			),$atts));
			
			/*
				Icon shortcode exec
			*/
			$flip_icon = do_shortcode('[icon name="icon '.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" size="'.$icon_size.'px " color="'.$icon_color.'"]');
			$flip_icon_back = do_shortcode('[icon name="icon '.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width_back.'" size="'.$icon_size_back.'px " color="'.$icon_color_back.'"]');
			$css_trans = $icon_border = $box_border = '';
			
			switch($front_background_type){
				case 'none':
					$front_bg = 'background:none;';
				break;
				
				case 'custom-front-color':
					$front_bg = 'background:'.$front_background_color.';';
				break;
			}
			
			switch($front_border_type){
				case 'none':
					$front_bd = 'border:0px;';
				break;
				
				case 'custom-front-border':
					$front_bd = 'border:'.$front_border_width.'px solid '.$front_border_color.';border-radius:'.$front_border_roundness.'px;-moz-border-radius:'.$front_border_roundness.'px;-webkit-border-radius:'.$front_border_roundness.'px;-o-border-radius:'.$front_border_roundness.'px;';
				break;
			}
			
			if($front_title_color !== '') {
				$front_tc = 'color:'.$front_title_color.';';
			}
			
			$front_style = $front_bg.$front_bd;
			
			switch($back_background_type) {
				case 'none':
					$back_bg = 'background:none;';
				break;
				
				case 'custom-back-color':
					$back_bg = 'background:'.$back_background_color.';';
				break;
			}
			
			switch($back_border_type) {
				case 'none':
					$back_bd = 'border:0px;';
				break;
				
				case 'custom-back-border':
					$back_bd = 'border:'.$back_border_width.'px solid '.$back_border_color.';border-radius:'.$back_border_roundness.'px;-moz-border-radius:'.$back_border_roundness.'px;-webkit-border-radius:'.$back_border_roundness.'px;-o-border-radius:'.$back_border_roundness.'px;';
				break;
			}

			if($back_title_color !== '') {
				$back_tc = 'color:'.$back_title_color.';';
			}
			
			$back_style = $back_bg.$back_bd;
			
			if($height_type == "custom") {
				$height = 'height:'.$box_height.'px;';
			}
			
			$output .= '<div class="hgr-flipcard '.$fb_extra_class.'">';
				$output .= '<div class="flipper" style="'.$height.'">';
					$output .= '<div class="front-fb" style="'.$front_style.'">';
						if($icon !== '' && $icon_background_type == 'none') {
							$front_icon_display .='<div class="f-front-icon-fb">'.$flip_icon.'</div>';
							}
						if($icon !== '' && $icon_background_type == 'icon-background-select') {
							$front_icon_display .='<div class="f-front-icon-fb" style="background:'.$icon_background_color.';width:'.$icon_background_size.'px;height:'.$icon_background_size.'px;line-height:'.$icon_background_size.'px;border-radius:'.$icon_background_roundness.'px;-moz-border-radius:'.$icon_background_roundness.'px;-webkit-border-radius:'.$icon_background_roundness.'px;-o-border-radius:'.$icon_background_roundness.'px;">'.$flip_icon.'</div>';
							}
						if(!empty($title_front)) {
							$front_title_display .='<h4 style="'.$front_tc.'">'.$title_front.'</h4>';
							}
						if(!empty($desc_front)) {
							$front_desc_display .='<p style="color:'.$front_desc_color.'">'.$desc_front.'</p>';
							}
						switch($icon_front_place){
							case 'icon_front_top':
								$output .= $front_icon_display.$front_title_display.$front_desc_display;
							break;
							
							case 'icon_front_bottom':
								$output .= $front_title_display.$front_desc_display.$front_icon_display;
							break;
							
							case 'icon_front_notext':
								$output .='<div class="f-front-icon-notext">'.$flip_icon.'</div>';
							break;
						}	
					$output .='</div>';
					$output.='<div class="back-fb" style="'.$back_style.'">';
					
					if($icon !== '' && $bpicon_background_type == 'none') {
						$back_icon_display .='<div class="f-back-icon-fb">'.$flip_icon_back.'</div>';
					}
					if($icon !== '' && $bpicon_background_type == 'bpicon-background-select') {
						$back_icon_display .='<div class="f-back-icon-fb" style="background:'.$bpicon_background_color.';width:'.$bpicon_background_size.'px;height:'.$bpicon_background_size.'px;line-height:'.$bpicon_background_size.'px;border-radius:'.$bpicon_background_roundness.'px;-moz-border-radius:'.$bpicon_background_roundness.'px;-webkit-border-radius:'.$bpicon_background_roundness.'px;-o-border-radius:'.$bpicon_background_roundness.'px;">'.$flip_icon_back.'</div>';
					}
					
					if($icon !== '' || $icon_img !== '') {
						if(!empty($custom_link_back)) {
							$href_back = vc_build_link($back_icon_link);
							if($href_back['url'] !== '') {
								$link_target_back = (isset($href_back['target'])) ? ' target="'.$href_back['target'].'"' : '';
								$link_title_back = (isset($href_back['title'])) ? ' title="'.$href_back['title'].'"' : '';
							}
							$back_icon_display_notext .='<a href="'.$href_back['url'].'"'.$link_target_back.''.$link_title_back.' class="f-back-icon-notext">'.$flip_icon_back.'</a>';
						}
						else {
							$back_icon_display_notext .='<div class="f-back-icon-notext">'.$flip_icon_back.'</div>';
						}
					}
					if(!empty($title_back)) {
						$back_title_display .='<h4 style="'.$back_tc.'">'.$title_back.'</h4>';
					}
					if(!empty($desc_back)) {
						$back_desc_display .='<p style="color:'.$back_desc_color.'">'.$desc_back.'</p>';
					}

					switch($icon_type_back){
							case 'top_icon_back':
								$output .= $back_icon_display.$back_title_display.$back_desc_display;
							break;
							
							case 'bottom_icon_back':
								$output .= $back_title_display.$back_desc_display.$back_icon_display;
							break;
							
							case 'notext_icon_back':
								$output .= $back_icon_display_notext;
							break;
							
							case 'no_icon_back':
								$output .= $back_title_display.$back_desc_display;
							break;
						}
							
					if($button_text !== '' && $custom_link){
						$link_prefix = '<div class="back-button">';
							if($button_bg !== '' && $button_txt !== '')
								$link_style = 'style="background-color:'.$button_bg.'; color:'.$button_txt.';"';
									if($button_link !== ''){								
										$href = vc_build_link($button_link);
										if($href['url'] !== '') {
											$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
											$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
										}
										$link_prefix .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.' '.$link_style.'>';
										$link_sufix .= '</a>';
									}
						$link_sufix .= '</div>';
						$output .=$link_prefix.$button_text.$link_sufix;
					}
					$output .='</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			/*
				Return the output
			*/
			return $output;		
		}
?>