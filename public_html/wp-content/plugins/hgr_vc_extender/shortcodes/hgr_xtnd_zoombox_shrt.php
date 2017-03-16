<?php
/*
	Shortcode: ZoomBox element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_zoom_box', 'hgr_zoombox');
function hgr_zoombox($atts) {
		
			/*
				Empty vars declaration
			*/
			$output = $icon_type = $icon = $icon_size = $icon_color = $icon_img = $img_width = $front_title = $front_title_color = $front_desc = 
			$front_desc_color = $front_background_type = $front_background_color = $front_background_opacity = 
			$front_border_type = $front_border_width = $front_border_color = $zoom_title = $zoom_title_color = $zoom_desc = 
			$zoom_desc_color = $zoom_background_type = $zoom_background_color = $zoom_border_type = $zoom_border_width = 
			$zoom_border_color = $zb_border_roundness = $custom_link = $zoombox_link = $zb_extra_class = $front_style = $front_bg = $front_bd = $zoom_style = 
			$zoom_bg = $zoom_bd = $border_roundness = $front_zoombox_icon = $hgr_zoombox_img_array = '';
			
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'icon_type'						=>	'',
				'icon'							=>	'',
				'icon_size'						=>	'',
				'icon_color'					=>	'',
				'icon_img'						=>	'',
				'img_width'						=>	'',
				'front_title'					=>	'',
				'front_title_color'				=>	'',
				'front_desc'					=>	'',
				'front_desc_color'				=>	'',
				'front_background_type'			=>	'',
				'front_background_color'		=>	'',
				'front_background_opacity'		=>	'',
				'front_border_type'				=>	'',
				'front_border_width'			=>	'',
				'front_border_color'			=>	'',
				'zoom_title'					=>	'',
				'zoom_title_color'				=>	'',
				'zoom_desc'						=>	'',
				'zoom_desc_color'				=>	'',
				'zoom_background_type'			=>	'',
				'zoom_background_color'			=>	'',
				'zoom_border_type'				=>	'',
				'zoom_border_width'				=>	'',
				'zoom_border_color'				=>	'',
				'zb_border_roundness'			=>	'',
				'custom_link'					=>	'',
				'zoombox_link'					=>	'',
				'zb_extra_class'				=>	'',
			),$atts));
			
			/*
				Do the icon
			*/
			if( $icon_type == 'selector' && !empty($icon) ) {
				$front_zoombox_icon = '<div style="color:'.$icon_color.'">'.do_shortcode('[icon name="'.$icon.' front-icon-zb" size="'.$icon_size.'px"]').'</div>';
			}
			elseif($icon_type == 'custom-icon' && !empty($icon_img)){
				$hgr_zoombox_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "" ) );
				$front_zoombox_icon = '<div class="hgr-zoombox-customimg" style="width:'.$img_width.'px;">'.$hgr_zoombox_img_array['thumbnail'].'</div>';
			}
			
			if ($zb_border_roundness !== '0') {
				$border_roundness .= 'border-radius:'.$zb_border_roundness.'px;-moz-border-radius:'.$zb_border_roundness.'px;-webkit-border-radius:'.$zb_border_roundness.'px;-o-border-radius:'.$zb_border_roundness.'px;';
			}
			
			switch($front_background_type){
				case 'none':
					$front_bg = 'background: none;';
				break;
				
				case 'custom-front-background':
					$front_bg = 'background-color:'.$front_background_color.'; opacity:'.$front_background_opacity.';';
				break;
			}
			
			switch($front_border_type){
				case 'none':
					$front_bd = 'border: 0px;';
				break;
				
				case 'custom-front-border':
					$front_bd = 'border:'.$front_border_width.'px solid '.$front_border_color.';';
				break;
			}
			
			$front_style .= $front_bg.$front_bd;
			
			switch($zoom_background_type){
				case 'none':
					$zoom_bg = 'background:none;';
				break;
				
				case 'custom-zoom-color':
					$zoom_bg = 'background-color:'.$zoom_background_color.';';
				break;
			}
			
			switch($zoom_border_type){
				case 'none':
					$zoom_bd = 'border:0px;';
				break;
				
				case 'custom-zoom-border':
					$zoom_bd = 'border:'.$zoom_border_width.'px solid '.$zoom_border_color.';';
				break;
			}
			
			$zoom_style .= $zoom_bg.$zoom_bd;
			
			$zoombox_icon = do_shortcode('[icon icon_type="'.$icon_type.'" name="icon '.$icon.'" size="'.$icon_size.'px" color="'.$icon_color.'"]');
			
			$output .= '<div class="hgr-zoombox '.$zb_extra_class.'">';
				$output .= '<div class="zoom-hover">';
					$output .= '<div class="hgr-zoom-front">';
						if($icon_type !== 'none') {
							$output .= $front_zoombox_icon;
						}
						if(!empty($front_title)) {
							$output .='<h4 style="color:'.$front_title_color.'">'.$front_title.'</h4>';
						}
						if(!empty($front_desc)) {
							$output .='<p style="color:'.$front_desc_color.'">'.$front_desc.'</p>';
						}
					$output .= '</div>';
					$output .= '<div class="hgr-zoom-front-mask" style="'.$front_style.$border_roundness.'"></div>';
					$output .= '<div class="hgr-zoom-back" style="'.$zoom_style.$border_roundness.'">';
						$output .= '<div class="hgr-zoom-back-middle">';
						if ($custom_link == 'no-link') {
							$output .= '<span>';
								if(!empty($zoom_title)) {
									$output .='<h4 style="color:'.$zoom_title_color.'">'.$zoom_title.'</h4>';
								}
								if(!empty($zoom_desc)) {
									$output .='<p style="color:'.$zoom_desc_color.'">'.$zoom_desc.'</p>';
								}
							$output .= '</span>';
						} elseif ($custom_link == 'set-link' && $zoombox_link !== '') {
							$href = vc_build_link($zoombox_link);
							if($href['url'] !== "") {
								$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
								$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
							}
							$output .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.'>';
								if(!empty($zoom_title)) {
									$output .='<h4 style="color:'.$zoom_title_color.'">'.$zoom_title.'</h4>';
								}
								if(!empty($zoom_desc)) {
									$output .='<p style="color:'.$zoom_desc_color.'">'.$zoom_desc.'</p>';
								}
							$output .= '</a>';
						}

						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			/*
				Return the output
			*/
			return $output;		
		}
?>