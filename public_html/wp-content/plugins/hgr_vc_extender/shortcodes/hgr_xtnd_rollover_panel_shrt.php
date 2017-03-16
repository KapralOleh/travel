<?php
/*
	Shortcode: Rollover Panel
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_rollover_panel', 'hgr_rolloverpanel_shortcode');
function hgr_rolloverpanel_shortcode($atts) {
			/*
				 Empty vars declaration
			*/
			$output = $hgr_rollover_id = $front_bg = $front_bd = $back_bg = $back_bd = $height = $border_roundness = $rollover_icon = $link_prefix = $link_sufix = $link_style = $icon_type = $icon = $icon_size = $icon_color = $icon_img = $img_width = $hgr_rollover_img_array = $title_front = $title_front_size = $title_front_color = $front_background_type = $front_background_color = $front_border_type = $front_border_width = $front_border_color = $title_back = $title_back_size = $title_back_color = $description_back = $description_back_size = $description_back_color = $back_background_type = $back_background_color = $back_border_type = $back_border_width = $back_border_color = $custom_link_back = $link_text = $link_url = $link_size = $link_color = $box_roundness = $box_reflection = $height_type = $box_height = $box_extra_class = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'							=>	'',
				'icon'								=>	'',
				'icon_size'							=>	'',
				'icon_color'						=>	'',
				'icon_img'							=>	'',
				'img_width'							=>	'',
				'title_front'						=>	'',
				'title_front_size'					=>	'',
				'title_front_color'					=>	'',
				'front_background_type'				=>	'',
				'front_background_color'			=>	'',
				'front_border_type'					=>	'',
				'front_border_width'				=>	'',
				'front_border_color'				=>	'',
				'title_back'						=>	'',
				'title_back_size'					=>	'',
				'title_back_color'					=>	'',
				'description_back'					=>	'',
				'description_back_size'				=>	'',
				'description_back_color'			=>	'',
				'back_background_type'				=>	'',
				'back_background_color'				=>	'',
				'back_border_type'					=>	'',
				'back_border_width'					=>	'',
				'back_border_color'					=>	'',
				'custom_link_back'					=>	'',
				'link_text'							=>	'',
				'link_url'							=>	'',
				'link_size'							=>	'',
				'link_color'						=>	'',
				'box_roundness'						=>	'',
				'box_reflection'					=>	'',
				'height_type'						=>	'',
				'box_height'						=>	'',
				'box_extra_class'					=>	'',
			),$atts));
			
			/*
				Icon shortcode exec
			*/
			if( $icon_type == 'selector' && !empty($icon) ) {
				$rollover_icon = '<div class="front-side-icon" style="color:'.$icon_color.'">'.do_shortcode('[icon name="icon '.$icon.'" size="'.$icon_size.'px"]').'</div>';
			}
			elseif($icon_type == 'custom-icon' && !empty($icon_img)){
				$hgr_rollover_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$rollover_icon = '<div class="rollover-tab"><div class="rollover-cel"><div class="hgr-rollover-customimg" style="width:'.$img_width.'px;">'.$hgr_rollover_img_array['thumbnail'].'</div></div></div>';
			}
			
			$hgr_rollover_id = "hgr-rollover-".uniqid();
			
			if ( $box_roundness !== '0') {
			$border_roundness .= 'border-radius:'.$box_roundness.'px;-moz-border-radius:'.$box_roundness.'px;-webkit-border-radius:'.$box_roundness.'px;-o-border-radius:'.$box_roundness.'px;';
			}
			
			switch($front_background_type){
				case 'none':
					$front_bg = 'none';
				break;
				
				case 'custom-front-color':
					$front_bg = $front_background_color;
				break;
			}
			
			switch($front_border_type){
				case 'none':
					$front_bd = '0px';
				break;
				
				case 'custom-front-border':
					$front_bd = $front_border_width.'px solid '.$front_border_color;
				break;
			}
			
			switch($back_background_type){
				case 'none':
					$back_bg = 'none';
				break;
				
				case 'custom-back-color':
					$back_bg = $back_background_color;
				break;
			}
			
			switch($back_border_type){
				case 'none':
					$back_bd = '0px';
				break;
				
				case 'custom-back-border':
					$back_bd = $back_border_width.'px solid '.$back_border_color;
				break;
			}
			
			if($height_type == "custom") {
				$height = 'height:'.$box_height.'px;';
			}
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#'.$hgr_rollover_id.'").find(".front-side").css("background","'.$front_bg.'").css("border","'.$front_bd.'");
							jQuery("#'.$hgr_rollover_id.'").mouseenter(function() {
								jQuery(this).find(".front-side").css("background","'.$back_bg.'");
								jQuery(this).addClass("hgr-scale-fix");
							}).mouseleave(function() {
								jQuery(this).find(".front-side").css("background","'.$front_bg.'");
								jQuery(this).removeClass("hgr-scale-fix");
							});
							jQuery("#'.$hgr_rollover_id.'").bind({
								click: function() {
									jQuery(this).find(".front-side").addClass("rollclick");
									jQuery(this).find(".back-side").addClass("rollclick");
								},
								mouseleave: function() {
									jQuery(this).find(".front-side").removeClass("rollclick");
									jQuery(this).find(".back-side").removeClass("rollclick");
								}
							});
						});
					</script>';
			
			$output .= '<div id="'.$hgr_rollover_id.'" class="hgr-rollover-panel '.$box_extra_class.'">';
				$output .= '<div class="rollover-container" style="'.$height.'">';
					$output .= '<div class="front-side" style="'.$border_roundness.'">';
						if($box_reflection == 'yes') {
							$output .= '<div class="reflection"></div>';
						}
						if(!empty($title_front)) {
							$output .='<span class="front-side-title" style="font-size:'.$title_front_size.'px;color:'.$title_front_color.';">'.$title_front.'</span>';
						}
						$output .= $rollover_icon;
					$output .= '</div>';
					$output .= '<div class="back-side" style="background:'.$back_bg.'; border:'.$back_bd.';'.$border_roundness.'">';
						if($box_reflection == 'yes') {
							$output .= '<div class="reflection"></div>';
						}
						if(!empty($title_back)) {
							$output .= '<span class="rollover-back-title" style="font-size:'.$title_back_size.'px;color:'.$title_back_color.';">'.$title_back.'</span>';
							$output .= '<span class="rollover-back-bar"></span>';
						}
						if(!empty($description_back)) {
							$output .='<span class="rollover-back-description" style="font-size:'.$description_back_size.'px;color:'.$description_back_color.';">'.$description_back.'</span>';
						}
						if($link_url !== '' && $custom_link_back !== ''){
							$link_prefix = '<span class="rollover-back-link">';
								if($link_size !== '' && $link_color !== '')
									$link_style = 'style="font-size:'.$link_size.'px; color:'.$link_color.';"';
										if($link_url !== ''){								
											$href = vc_build_link($link_url);
												if($href['url'] !== "") {
													$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
													$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
												}
											$link_prefix .= '<a href = "'.$href['url'].'"'.$link_target.$link_title.' '.$link_style.'>';
											$link_sufix .= '</a>';
										}
							$link_sufix .= '</span>';
							$output .= $link_prefix.'&raquo;'.$link_text.$link_sufix;
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			/*
				Return the output
			*/
			return $output;		
		}
?>