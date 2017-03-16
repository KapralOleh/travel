<?php
/*
	Shortcode: HGR CountDown
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_countdown', 'hgr_countdown' );
function hgr_countdown ($atts) {
			/*
				Include required JS and CSS files
			*/
			wp_enqueue_script('hgr-countdown_plugin');
			wp_enqueue_script('hgr-countdown');
			
			/*
				 Empty vars declaration
			*/
			$output = $countdown_day = $countdown_month = $countdown_year = $countdown_hour = $countdown_minute = $counter_font_tag = $counter_font_color = $label_font_tag = $label_font_color = $extra_class = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'countdown_day'		=>	'01',
				'countdown_month'	=>	'January',
				'countdown_year'	=>	'2016',
				'countdown_hour'	=>	'10',
				'countdown_minute'	=>	'10',
				'counter_font_tag'	=>	'h4',
				'counter_font_color'=>	'#ff0000',
				'label_font_tag'	=>	'h3',
				'label_font_color'	=>	'#ff0000',
				'extra_class'		=>	'',
				'css'				=>	'',
			), $atts));
			
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $settings['base'], $atts );
			
			$layout = '<div class=\"vc_row wpb_row vc_row-fluid\"><div class=\"wpb_column vc_column_container vc_col-sm-3\"><div class=\"wpb_wrapper\"><'.$counter_font_tag.' style=\"color:'.$counter_font_color.'\">{dn}</'.$counter_font_tag.'> <'.$label_font_tag.' style=\"color:'.$label_font_color.'\">{dl}</'.$label_font_tag.'></div></div><div class=\"wpb_column vc_column_container vc_col-sm-3\"><div class=\"wpb_wrapper\"><'.$counter_font_tag.' style=\"color:'.$counter_font_color.'\">{hn}</'.$counter_font_tag.'> <'.$label_font_tag.' style=\"color:'.$label_font_color.'\">{hl}</'.$label_font_tag.'></div></div><div class=\"wpb_column vc_column_container vc_col-sm-3\"><div class=\"wpb_wrapper\"><'.$counter_font_tag.' style=\"color:'.$counter_font_color.'\">{mn}</'.$counter_font_tag.'> <'.$label_font_tag.' style=\"color:'.$label_font_color.'\">{ml}</'.$label_font_tag.'></div></div><div class=\"wpb_column vc_column_container vc_col-sm-3\"><div class=\"wpb_wrapper\"><'.$counter_font_tag.' style=\"color:'.$counter_font_color.'\">{sn}</'.$counter_font_tag.'> <'.$label_font_tag.' style=\"color:'.$label_font_color.'\">{sl}</'.$label_font_tag.'></div></div></div>';
			
			$output .=	'<script>
			jQuery(function ($) {
				var austDay = new Date("'.$countdown_month.' '.$countdown_day.', '.$countdown_year.' '.$countdown_hour.':'.$countdown_minute.':00");
				$("#defaultCountdown").countdown({until: austDay, format: "DHMS", layout: "'.$layout.'"});
				$("#year").text(austDay.getFullYear());
			});
			</script>';
			
			$output	.=	'<div class="hgr_countdown '.esc_attr( $css_class ).' '.$extra_class.'" style="text-align:center;">';
			$output	.=	'<div id="defaultCountdown"></div>';
			$output	.=	'</div>';
						
			return $output;
		}
?>