<?php
/*
	Shortcode: Counter
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_counter', 'hgr_counter');
function hgr_counter ($atts, $content = null) {
			/*
				Include required JS and CSS files
			*/
			wp_enqueue_script('hgr-vc-jquery-appear');
			wp_enqueue_script('hgr-vc-countto');
			
			/*
				 Empty vars declaration
			*/
			$output = $counter_id = $counter_bg = $counter_bd = $border_roundness = $hgr_counter_img_array = $icon_type = $icon = $icon_img = 
			$img_width = $counter_icon_size = $counter_icon_color = $counter_number = $counter_number_color = $counter_units = $counter_units_color = 
			$counter_speed = $counter_text = $counter_text_color = $counter_background_settings = $counter_background_color = $counter_border_settings = 
			$counter_border_width = $counter_border_color = $counter_border_corner = $extra_class = $do_icon = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'icon_type'							=>	'',
				'icon'								=>	'',
				'icon_img'							=>	'',
				'img_width'							=>	'',
				'counter_icon_size'					=>	'',
				'counter_icon_color'				=>	'',
				'counter_icon_position'				=>	'',
				'counter_number'					=>	'',
				'counter_number_color'				=>	'',
				'counter_units'						=>	'',
				'counter_units_color'				=>	'',
				'counter_speed'						=>	'',
				'counter_text'						=>	'',
				'counter_text_color'				=>	'',
				'counter_background_settings'		=>	'',
				'counter_background_color'			=>	'',
				'counter_border_settings'			=>	'',
				'counter_border_width'				=>	'',
				'counter_border_color'				=>	'',
				'counter_border_corner'				=>	'',
				'extra_class'						=>	'',
			), $atts));
			
			
			
			/*
				Font icon or Image icon?
			*/
			if( $icon_type == 'selector' && !empty($icon) ) {
				
				$do_icon = do_shortcode('[icon name="icon '.$icon.'" color="'.$counter_icon_color.'" size="'.$counter_icon_size.'px"]');
			}
			/*
				Image icon
			*/
			elseif($icon_type == 'custom' && !empty($icon_img)){
				$hgr_counter_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$do_icon = '<div style="width:'.$img_width.'px;margin:auto;">'.$hgr_counter_img_array['thumbnail'].'</div>';
			}
			
			/*
				Border radius?
			*/
			if ( $counter_border_corner !== '0') {
			$border_roundness .= 'border-radius:'.$counter_border_corner.'px;-moz-border-radius:'.$counter_border_corner.'px;-webkit-border-radius:'.$counter_border_corner.'px;-o-border-radius:'.$counter_border_corner.'px;';
			}
			
			switch($counter_background_settings){
				case 'none':
					$counter_bg = 'background:none;';
				break;
				
				case 'custom-counter-background':
					$counter_bg = 'background-color:'.$counter_background_color.';';
				break;
				
				default:
			}
			
			switch($counter_border_settings){
				case 'none':
					$counter_bd = 'border:0px;';
				break;
				
				case 'custom-counter-border':
					$counter_bd = 'border:'.$counter_border_width.'px solid '.$counter_border_color.';';
				break;
				
				default:
			}
			
			$counter_id .= 'hgr-counter-'.uniqid();
			
			$js = '<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery(function($) {
								
								$(".'.$counter_id.'").appear(function() {
									$(this).countTo();
								});
							});
						});
					</script>';
				
			$output .= $js;
			
			switch($counter_icon_position){
			
				// Icon position left
				case 'icon-left':
					$output .= '<div class="hgr_counter '.(!empty($extra_class) ? $extra_class : '').'" style="'.$counter_bg.$counter_bd.$border_roundness.'">';
						$output .= '<div class="hgr_counter_row">';
							if(!empty($do_icon)) { 
								$output .= '<div class="hgr_counter_icon">';
								$output .= $do_icon; 
								$output .= '</div>';
							}
							$output .= '<div class="hgr_counter_content">';
								$output .= '<h5 class="hgr_counter_number">';
								$output .= '<span class="hgr_number_string '.$counter_id.'" style="color:'.$counter_number_color.'" data-from="0" data-to="'.$counter_number.'" data-speed="'.($counter_speed*1000).'" data-refresh-interval="50">0</span> <span class="hgr_counter_units" style="color:'.$counter_units_color.'">'.$counter_units.'</span>';
								$output .= '</h5>';
								$output .= '<div class="hgr_counter_text" style="color:'.$counter_text_color.'">'.$counter_text.'</div>';
							$output .= '</div>';
						$output .= '</div> <!-- END .hgr_counter_row -->';
					$output .= '</div>';
				break;
				
				// Icon position top
				case 'icon-top':
					$output .= '<div class="hgr_counter '.(!empty($extra_class) ? $extra_class : '').'" style="'.$counter_bg.$counter_bd.$border_roundness.'">';
						if(!empty($do_icon)) { 
							$output .= '<div class="hgr_counter_icon" style="padding-bottom:2em;">';
							$output .= $do_icon; 
							$output .= '</div>';
						}
						$output .= '<div class="hgr_counter_content">';
							$output .= '<h5 class="hgr_counter_number">';
							$output .= '<span class="hgr_number_string '.$counter_id.'" style="color:'.$counter_number_color.'" data-from="0" data-to="'.$counter_number.'" data-speed="'.($counter_speed*1000).'" data-refresh-interval="50">0</span> <span class="hgr_counter_units" style="color:'.$counter_units_color.'">'.$counter_units.'</span>';
							$output .= '</h5>';
							$output .= '<div class="hgr_counter_text" style="color:'.$counter_text_color.'">'.$counter_text.'</div>';
						$output .= '</div>';
					$output .= '</div>';
				break;
				
				// Icon position right
				case 'icon-right':
					$output .= '<div class="hgr_counter '.(!empty($extra_class) ? $extra_class : '').'" style="'.$counter_bg.$counter_bd.$border_roundness.'">';
						$output .= '<div class="hgr_counter_row">';
							$output .= '<div class="hgr_counter_content">';
								$output .= '<h5 class="hgr_counter_number">';
								$output .= '<span class="hgr_number_string '.$counter_id.'" style="color:'.$counter_number_color.'" data-from="0" data-to="'.$counter_number.'" data-speed="'.($counter_speed*1000).'" data-refresh-interval="50">0</span> <span class="hgr_counter_units" style="color:'.$counter_units_color.'">'.$counter_units.'</span>';
								$output .= '</h5>';
								$output .= '<div class="hgr_counter_text" style="color:'.$counter_text_color.'">'.$counter_text.'</div>';
							$output .= '</div>';
							if(!empty($do_icon)) { 
								$output .= '<div class="hgr_counter_icon">';
								$output .= $do_icon; 
								$output .= '</div>';
							}
						$output .= '</div> <!-- END .hgr_counter_row -->';
					$output .= '</div>';
				break;
				
				// Icon position bottom
				case 'icon-bottom':
					$output .= '<div class="hgr_counter '.(!empty($extra_class) ? $extra_class : '').'" style="'.$counter_bg.$counter_bd.$border_roundness.'">';
						$output .= '<div class="hgr_counter_content">';
							$output .= '<h5 class="hgr_counter_number">';
							$output .= '<span class="hgr_number_string '.$counter_id.'" style="color:'.$counter_number_color.'" data-from="0" data-to="'.$counter_number.'" data-speed="'.($counter_speed*1000).'" data-refresh-interval="50">0</span> <span class="hgr_counter_units" style="color:'.$counter_units_color.'">'.$counter_units.'</span>';
							$output .= '</h5>';
							$output .= '<div class="hgr_counter_text" style="color:'.$counter_text_color.'">'.$counter_text.'</div>';
						$output .= '</div>';
						if(!empty($icon)) { 
							$output .= '<div class="hgr_counter_icon" style="padding-top:2em;">';
							$output .= $do_icon; 
							$output .= '</div>';
						}
					$output .= '</div>';
				break;
				
				default:
				$output .= '<div class="hgr_counter '.(!empty($extra_class) ? $extra_class : '').'" style="'.$counter_bg.$counter_bd.$border_roundness.'">';
					$output .= '<div class="hgr_counter_row">';
						if(!empty($do_icon)) { 
							$output .= '<div class="hgr_counter_icon">';
							$output .= $do_icon; 
							$output .= '</div>';
						}
						$output .= '<div class="hgr_counter_content">';
							$output .= '<h5 class="hgr_counter_number">';
							$output .= '<span class="hgr_number_string '.$counter_id.'" style="color:'.$counter_number_color.'" data-from="0" data-to="'.$counter_number.'" data-speed="'.($counter_speed*1000).'" data-refresh-interval="50">0</span> <span class="hgr_counter_units" style="color:'.$counter_units_color.'">'.$counter_units.'</span>';
							$output .= '</h5>';
							$output .= '<div class="hgr_counter_text" style="color:'.$counter_text_color.'">'.$counter_text.'</div>';
						$output .= '</div>';
					$output .= '</div> <!-- END .hgr_counter_row -->';
				$output .= '</div>';
			}
			
			/*
				Return the output
			*/
			return $output;
		}
?>