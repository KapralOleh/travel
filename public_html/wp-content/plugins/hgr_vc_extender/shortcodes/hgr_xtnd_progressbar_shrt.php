<?php
/*
	Shortcode: Progress Bar element
	Based on Bootstrap
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_progressbar', 'hgr_progressbar' );
function hgr_progressbar ($atts) {
			
		/*
			Include required scripts
		*/
		wp_enqueue_script('hgr-vc-jquery-appear');
		wp_enqueue_script('hgr-vc-progressbar');
		
		
		/*
			Empty vars declaration
		*/
		$output = $do_icon = $hgr_progressbar_title = $hgr_progressbar_title_color = $hgr_progressbar_basecolor = $hgr_progressbar_color = 
		$hgr_progressbar_value = $hgr_progressbar_filltime = $hgr_progressbar_weight = $hgr_progressbar_type = $hgr_progressbar_icontype = 
		$hgr_progressbar_icon = $hgr_progressbar_img = $hgr_progressbar_imgwidth = $hgr_progressbar_icnsize = $hgr_progressbar_icncolor = 
		$hgr_progressbar_marker = $hgr_progressbar_extraclass = '';
		
		
		/*
			WordPress function to extract shortcodes attributes
			Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
		*/
		extract(shortcode_atts(array(
			'hgr_progressbar_title'		=> '',
			'hgr_progressbar_title_color'=> '',
			'hgr_progressbar_basecolor'	=> '',
			'hgr_progressbar_color'		=> '',
			'hgr_progressbar_value'		=> '',
			'hgr_progressbar_filltime'	=> '',
			'hgr_progressbar_weight'	=> '',
			'hgr_progressbar_type'		=> '',
			'hgr_progressbar_icontype'	=> '',
			'hgr_progressbar_icon'		=> '',
			'hgr_progressbar_img'		=> '',
			'hgr_progressbar_imgwidth'	=> '',
			'hgr_progressbar_icnsize'	=> '',
			'hgr_progressbar_icncolor'	=> '',
			'hgr_progressbar_marker'	=> '',
			'hgr_progressbar_extraclass'=> ''
		), $atts));
		
		/*
			Do the icon
			Font icon or image icon...
		*/
		if( $hgr_progressbar_icontype == 'selector' && !empty($hgr_progressbar_icon) ) {
			$do_icon = '<div class="hgr-progb-icon" style="width:'.$hgr_progressbar_icnsize.'px; height:'.$hgr_progressbar_icnsize.'px;">'.do_shortcode('[icon name="'.$hgr_progressbar_icon.'" size="'.$hgr_progressbar_icnsize.'px" height="'.$hgr_progressbar_icnsize.'px" color="'.$hgr_progressbar_icncolor.'"]').'</div>';
		}
		/* Image icon */
		elseif($hgr_progressbar_icontype == 'custom' && !empty($hgr_progressbar_img)){
			$hgr_progressbar_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $hgr_progressbar_img, 'thumb_size' => 'full', 'class' => "hgr_progressbar_imgicon" ) );
			$do_icon = '<div class="hgr-progb-icon" style="width:'.$hgr_progressbar_imgwidth.'px;"><div style="width:'.$hgr_progressbar_imgwidth.'px;">'.$hgr_progressbar_img_array['thumbnail'].'</div></div>';
		}
		
		$output .='<div class="hgr_progressbar '.$hgr_progressbar_extraclass.'">';
			$output .= '<div class="hgr-progb-icontext">';
				$output .= $do_icon;
				$output .= '<div class="hgr-progb-text"><h4 style="color:'.$hgr_progressbar_title_color.';">'.$hgr_progressbar_title.'</h4></div>';
			$output .= '</div>';
			$output .= '<div class="hgr_progressbarfull" style="height:'.$hgr_progressbar_weight.'px; background-color: '.$hgr_progressbar_basecolor.';">';
				$output .= '<div class="hgr_progressbarfill '.$hgr_progressbar_type.'" style="height: '.$hgr_progressbar_weight.'px; background-color: '.$hgr_progressbar_color.';" data-value="'.$hgr_progressbar_value.'" data-time="'.($hgr_progressbar_filltime*1000).'">';
					if($hgr_progressbar_marker !== 'yes') {
						$output .= '<span class="hgr_progressbarmarker">'.$hgr_progressbar_value.'%</span>';
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