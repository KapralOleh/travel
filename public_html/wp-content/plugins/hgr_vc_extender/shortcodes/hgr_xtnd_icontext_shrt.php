<?php
/*
	Shortcode: IconText element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_icontext', 'hgr_icontext');
function hgr_icontext($atts) {
		
			/*
				 Empty vars declaration
			*/
			$output = $link_style = $link_prefix = $link_sufix = $content_icon = $content_customimg = $icon_type = $icon = $icon_size = $icon_img = 
			$img_width = $icon_color = $icon_background_type = $icon_background_color = $icon_background_size = $icon_background_roundness = 
			$icon_background_border_width = $icon_border_color = $contb_icon_position = $content_title = $content_title_color = $content_description = $content_desc_color = $custom_link = 
			$address_link = $link_text = $link_color = $contb_extra_class = '';
			
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'						=>	'',
				'icon'								=>	'',
				'icon_size'						=>	'',
				'icon_img'							=>	'',
				'img_width'						=>	'',
				'icon_color'						=>	'',
				'icon_background_type'			=>	'',
				'icon_background_color'			=>	'',
				'icon_background_size'			=>	'',
				'icon_background_roundness'		=>	'',
				'icon_background_border_width'	=>	'',
				'icon_border_color'				=>	'',
				'contb_icon_position'				=>	'',
				'content_title'					=>	'',
				'content_title_color'				=>	'',
				'content_description'				=>	'',
				'content_desc_color'				=>	'',
				'custom_link'						=>	'',
				'address_link'						=>	'',
				'link_text'						=>	'',
				'link_color'						=>	'',
				'contb_extra_class'				=>	'',
			),$atts));
			

			/*
				Do the icon, font or image...
			*/
			if( $icon_type == 'selector' && !empty($icon) ) {
				$content_icon .= do_shortcode('[icon name="icon '.$icon.' normal-icon-cb" size="'.$icon_size.'px"]');
			}
			/* Image icon... */
			elseif($icon_type == 'custom' && !empty($icon_img)){
				$hgr_icontext_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$content_customimg .= $hgr_icontext_img_array['thumbnail'];
			}
			
			/* Icon background border */
			if( $icon_background_border_width >= 1 && !empty($icon_border_color) ) {
				$icon_border_width_style = ' border: '.$icon_background_border_width.'px solid '.$icon_border_color.'; ';
			} else { $icon_border_width_style = ''; }
				
			switch($contb_icon_position){
				/* 
					Icon position top
				*/
				case 'contb-icon-top':
					$output .= '<div class="hgr-content-block-tb '.$contb_extra_class.'" style="margin-bottom:2em;text-align:center;">';
						if($icon_type == 'selector' && $icon_background_type == 'none') {
							$output .= '<div class="hgr-contblock-icon-tb" style="color:'.$icon_color.';margin-bottom:1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
						}
						if($icon_type == 'selector' && $icon_background_type == 'icon-background-select') {
							$output .= '<div class="hgr-contblock-icon-tb" style="color:'.$icon_color.';background:'.$icon_background_color.';width:'.$icon_background_size.'px;height:'.$icon_background_size.'px;line-height:'.$icon_background_size.'px;border-radius:'.$icon_background_roundness.'px;-moz-border-radius:'.$icon_background_roundness.'px;-webkit-border-radius:'.$icon_background_roundness.'px;-o-border-radius:'.$icon_background_roundness.'px;margin-bottom:1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
						}
						if($icon_type == 'custom' && $icon_img !== '') {
							$output .= '<div class="hgr-icontext-customimg" style="width:'.$img_width.'px; margin-bottom: 10px;">'.$content_customimg.'</div>';
						}
						$output .= '<div class="hgr-content-tb">';
							if(!empty($content_title)) {
								$output .='<h4 style="color:'.$content_title_color.'">'.$content_title.'</h4>';
							}
							
							if(!empty($content_description)) {
								$output .='<p style="color:'.$content_desc_color.'">'.$content_description.'</p>';
							}
							
							if($custom_link == 'custom-link-on'){
								if($link_text !== '')
									$link_style = 'style="color:'.$link_color.';"';
										if($address_link !== ''){								
											$href = vc_build_link($address_link);
											if($href['url'] !== "") {
												$link_target = (isset($href['target'])) ? 'target="'.$href['target'].'"' : '';
												$link_title = (isset($href['title'])) ? 'title="'.$href['title'].'"' : '';
											}
											$link_prefix .= '<a class="hgr-contb-link morelink-white" href="'.$href['url'].'" '.$link_target.' '.$link_title.'>';
											$link_sufix .= '</a>';
										}
								$output .=$link_prefix.$link_text.$link_sufix;
							}
						$output .= '</div>';
					$output .= '</div>';
				break;
				
				/*
					Icon position bottom
				*/
				case 'contb-icon-bottom':
					$output .= '<div class="hgr-content-block-tb '.$contb_extra_class.'" style="margin-bottom:2em;text-align:center;">';
						$output .= '<div class="hgr-content-tb">';
							if(!empty($content_title)) {
								$output .='<h4 style="color:'.$content_title_color.'">'.$content_title.'</h4>';
							}
							if(!empty($content_description)) {
								$output .='<p style="color:'.$content_desc_color.'">'.$content_description.'</p>';
							}
						$output .= '</div>';
						if($icon_type == 'selector' && $icon_background_type == 'none') {
							$output .= '<div class="hgr-contblock-icon-tb" style="color:'.$icon_color.'; margin-top: 1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
						}
						if($icon_type == 'selector' && $icon_background_type == 'icon-background-select') {
							$output .= '<div class="hgr-contblock-icon-tb" style="color:'.$icon_color.';background:'.$icon_background_color.';width:'.$icon_background_size.'px;height:'.$icon_background_size.'px;line-height:'.$icon_background_size.'px;border-radius:'.$icon_background_roundness.'px;-moz-border-radius:'.$icon_background_roundness.'px;-webkit-border-radius:'.$icon_background_roundness.'px;-o-border-radius:'.$icon_background_roundness.'px;margin-top:1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
						}
						if($icon_type == 'custom' && $icon_img !== '') {
							$output .= '<div class="hgr-icontext-customimg" style="width:'.$img_width.'px; margin-top: 10px;">'.$content_customimg.'</div>';
						}
					$output .= '</div>';
				break;
				
				/*
					Icon position left
				*/
				case 'contb-icon-left':
					$output .= '<div class="hgr-content-block '.$contb_extra_class.'" style="margin-bottom:2em;">';
						$output .= '<div class="hgr-contb-row">';
							if($icon_type == 'selector' && $icon_background_type == 'none') {
								$output .= '<div class="hgr-contblock-icon" style="color:'.$icon_color.'; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
							}
							if($icon_type == 'selector' && $icon_background_type == 'icon-background-select') {
								$output .= '<div class="hgr-contblock-icon" style="color:'.$icon_color.';">';
									$output .= '<div class="hgr-contblock-icon-bg" style="margin-top:8px;background:'.$icon_background_color.';width:'.$icon_background_size.'px;height:'.$icon_background_size.'px;line-height:'.$icon_background_size.'px;border-radius:'.$icon_background_roundness.'px;-moz-border-radius:'.$icon_background_roundness.'px;-webkit-border-radius:'.$icon_background_roundness.'px;-o-border-radius:'.$icon_background_roundness.'px;margin-bottom:1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
								$output .= '</div>';
							}
							if($icon_type == 'custom' && $icon_img !== '') {
								$output .= '<div class="hgr-icontext-customimg" style="width:'.$img_width.'px;">'.$content_customimg.'</div>';
							}
							$output .= '<div class="hgr-content" style="padding-left:1em;">';
								if(!empty($content_title)) {
									$output .='<h4 style="color:'.$content_title_color.'">'.$content_title.'</h4>';
								}
								
								if(!empty($content_description)) {
									$output .='<p style="color:'.$content_desc_color.'">'.$content_description.'</p>';
								}
								
								if($custom_link == 'custom-link-on'){
									if($link_text !== '')
										$link_style = 'style="color:'.$link_color.';"';
											if($address_link !== ''){								
												$href = vc_build_link($address_link);
												if($href['url'] !== "") {
													$link_target = (isset($href['target'])) ? 'target="'.$href['target'].'"' : '';
													$link_title = (isset($href['title'])) ? 'title="'.$href['title'].'"' : '';
												}
												$link_prefix .= '<a class="hgr-contb-link morelink-white" href="'.$href['url'].'" '.$link_target.' '.$link_title.'>';
												$link_sufix .= '</a>';
											}
									$output .=$link_prefix.$link_text.$link_sufix;
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				break;
				
				/* 
					Icon position right
				*/
				case 'contb-icon-right':
					$output .= '<div class="hgr-content-block '.$contb_extra_class.'" style="margin-bottom:2em;">';
						$output .= '<div class="hgr-contb-row">';
							$output .= '<div class="hgr-content" style="padding-right:1em;text-align:right;">';
								if(!empty($content_title)) {
									$output .='<h4 style="color:'.$content_title_color.'">'.$content_title.'</h4>';
								}
								
								if(!empty($content_description)) {
									$output .='<p style="color:'.$content_desc_color.'">'.$content_description.'</p>';
								}
								
								if($custom_link == 'custom-link-on'){
									if($link_text !== '')
										$link_style = 'style="color:'.$link_color.';"';
											if($address_link !== ''){								
												$href = vc_build_link($address_link);				
												if($href['url'] !== "") {
													$link_target = (isset($href['target'])) ? 'target="'.$href['target'].'"' : '';
													$link_title = (isset($href['title'])) ? 'title="'.$href['title'].'"' : '';
												}
												$link_prefix .= '<a class="hgr-contb-link morelink-white" href="'.$href['url'].'" '.$link_target.' '.$link_title.'>';
												$link_sufix .= '</a>';
											}
									$output .=$link_prefix.$link_text.$link_sufix;
								}
							$output .= '</div>';
							if($icon_type == 'selector' && $icon_background_type == 'none') {
								$output .= '<div class="hgr-contblock-icon" style="color:'.$icon_color.'; float:right; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
							}
							if($icon_type == 'selector' && $icon_background_type == 'icon-background-select') {
								$output .= '<div class="hgr-contblock-icon" style="color:'.$icon_color.';float:right;">';
									$output .= '<div class="hgr-contblock-icon-bg" style="margin-top:8px;background:'.$icon_background_color.';width:'.$icon_background_size.'px;height:'.$icon_background_size.'px;line-height:'.$icon_background_size.'px;border-radius:'.$icon_background_roundness.'px;-moz-border-radius:'.$icon_background_roundness.'px;-webkit-border-radius:'.$icon_background_roundness.'px;-o-border-radius:'.$icon_background_roundness.'px;margin-bottom:1em; '.$icon_border_width_style.' ">'.$content_icon.'</div>';
								$output .= '</div>';
							}
							if($icon_type == 'custom' && $icon_img !== '') {
								$output .= '<div class="hgr-icontext-customimg" style="width:'.$img_width.'px;">'.$content_customimg.'</div>';
							}
						$output .= '</div>';
					$output .= '</div>';
				break;
			}
			/*
				Return the output
			*/
			return $output;		
		}
?>