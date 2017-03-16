<?php
/*
	Shortcode: Pricing Tables element
	Based on Bootstrap
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_pricing_tables', 'hgr_pricing_tables' );
function hgr_pricing_tables($atts, $content = null ) {
			
			/*
				Empty vars declaration
			*/
			$output = $pt_header_text_color = $pt_body_text_color = $extra_class = '';
			
			/*
				How many tables do we have?!
			*/
			$number_of_tables = substr_count($content,'[hgr_pricing_table');
			
			/*
				Set table width
			*/
			$table_width = 99 / $number_of_tables;
			
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'pt_header_text_color'		=>	'#7e7e7e',
				'pt_body_text_color'		=>	'#7e7e7e', 
				'extra_class'				=>	'',
			), $atts));
			
			$GLOBALS['hgr_pricing_table_width'] = $table_width;
			$GLOBALS['hgr_pricing_table_ptbtc'] = $pt_body_text_color;
			$GLOBALS['hgr_pricing_table_pthtc'] = $pt_header_text_color;
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery(".hgr_pricing_table ul").each(function() {
								jQuery(this).addClass("hgr_price-group");
							});
							jQuery(".hgr_pricing_table li").each(function() {
								jQuery(this).addClass("hgr_price-group-item");
							});
						});
				</script>';
			
			
			
			$output .= '<div class="hgr_pricing_table_pack '.(!empty($extra_class) ? $extra_class : '').'">';
				$output .= do_shortcode($content);
			$output .= '</div>';
			
			/*
				Return the output
			*/	
			return $output;
		}
		


add_shortcode( 'hgr_pricing_table', 'hgr_pricing_table' );
function hgr_pricing_table($atts, $content = null) {
		
		/*
			Empty vars declaration
		*/
		$output = $package_name = $recommended_package = $package_short_text = $package_price = $cost_is_per = $cost_per = 
		$table_border = $custom_per_cost = $pt_currency = $custom_currency = $price_color = $header_color = $header_sec_color = 
		$body_bg_color = $package_bg_color = $pt_content = $buy_btn_text = $btn_url = $buy_btn_position = $buy_btn_color = 
		$buy_btn_border_color = $buy_btn_border_width = $buy_btn_border_roundness = $buy_btn_size = $table_margins = 
		$table_border_thickness = $table_border_color = $table_extra_class = '';
		
		
		
		/*
			WordPress function to extract shortcodes attributes
			Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
		*/
		extract(shortcode_atts(array(
			'package_name'					=>	'',
			'recommended_package'			=>	'',
			'package_short_text'			=>	'',
			'package_price'					=>	'',
			'cost_is_per'					=>	'',
			'custom_per_cost'				=>	'',
			'pt_currency'					=>	'',
			'custom_currency'				=>	'',
			'price_color'					=>	'',
			'header_color'					=>	'',
			'header_sec_color'				=>	'',
			'body_bg_color'					=>	'',
			'package_bg_color'				=>	'',
			'pt_content'						=>	'',
			'buy_btn_text'					=>	'',
			'btn_url'						=>	'',
			'buy_btn_position'				=>	'',
			'buy_btn_color'					=>	'',
			'buy_btn_border_color'			=>	'',
			'buy_btn_border_width'			=>	'',
			'buy_btn_border_roundness'		=>	'',
			'buy_btn_size'					=>	'',
			'table_margins'					=>	'',
			'table_border_thickness'		=>	'',
			'table_border_color'			=>	'',
			'table_extra_class'				=>	'',
		), $atts));
		
		/*
			Button color styles
		*/
		
		$output .='<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery(".btn-hgr").css("color","'.$GLOBALS['hgr_pricing_table_pthtc'].'");
						
						jQuery(".btn-hgr").mouseenter(function() {
							jQuery(this).css("color","'.$GLOBALS['hgr_pricing_table_ptbtc'].'");
						}).mouseleave(function() {
							jQuery(this).css("color","'.$GLOBALS['hgr_pricing_table_pthtc'].'");
						});
					});
			</script>';
		
		/*
			End Button color styles
		*/
		
		if($pt_currency == 'custom') {$pt_currency = $custom_currency;}
		
		if($cost_is_per == 'custom') {
			$cost_per .= $custom_per_cost;
		}
		else {
			$cost_per .= $cost_is_per;
		}
		
		/*
			Does the table have margins?
		*/
		if(!empty($table_margins)){
			//$GLOBALS['hgr_pricing_table_width'] = $GLOBALS['hgr_pricing_table_width'] - $table_margins;
			$table_margins = ' margin-left:'.$table_margins.'px; margin-right:'.$table_margins.'px; ';
		}
		
		/*
			Does the table has border?
		*/
		if(!empty($table_border_thickness) && !empty($table_border_color) ){
			$table_border = ' border:'.$table_border_thickness.'px solid '.$table_border_color.'; ';
		}
		
		/*
			Does the table has background color?
		*/
		if(!empty($package_bg_color) ){
			$package_bg_color = ' background-color:'.$package_bg_color.'; ';
		}

		$output .= '<div class="hgr_pricing_table '.(!empty($table_extra_class) ? $table_extra_class : '').'" style="width:'.$GLOBALS['hgr_pricing_table_width'].'%; '.$table_margins.' '.$table_border.' '.$package_bg_color.'">';
			$output .= '<div class="panel-heading" style="background-color:'.$header_color.';"><h4 style="color:'.$GLOBALS['hgr_pricing_table_pthtc'].';">'.$package_name.'</h4></div>';
			$output .= '<div class="panel-body" style="background-color:'.$body_bg_color.';">';
			$output .= ($recommended_package == "true" ? '<div class="recommended"></div>' : '');
			$output .= '<h1 style="color:'.$price_color.';"><sup>'.$pt_currency.'</sup><span class="hgr_package_price">'.$package_price.'</span><sub>/'.$cost_per.'</sub></h1>';
			$output .= '<p style="color:'.$GLOBALS['hgr_pricing_table_ptbtc'].';">'.$package_short_text.'</p>';
			// header buy button
			if( $buy_btn_position == 'header' ){ $output .='<a href="'.$btn_url.'" class="hgr_buy_btn"><span class="btn btn-hgr '.$buy_btn_size.'" style="
																									'.(!empty($buy_btn_border_width) ? 'border:'.$buy_btn_border_width.'px solid '.$buy_btn_border_color.';' : 'border:none;' ).' 
																									'.(!empty($buy_btn_color) ? 'background-color:'.$buy_btn_color.';' : 'background-color:transparent;' ).'
																									'.(!empty($buy_btn_border_roundness) ? 'border-radius:'.$buy_btn_border_roundness.'px;' : 'border-radius:0;' ).'">'.$buy_btn_text.'</span></a>'; }
			$output .= '</div>';
				//$output .= $pt_content;
				$output .= wpb_js_remove_wpautop($content, true);
			// footer buy button
			if( $buy_btn_position == 'footer' ){ $output .='<div class="panel-footer" style="'.(!empty($buy_btn_border_roundness) ? ' border-bottom-right-radius:'.$buy_btn_border_roundness.'px;border-bottom-left-radius:'.$buy_btn_border_roundness.'px;' : 'border-radius:0;' ).
																									' background-color:'.$header_sec_color.';border:none;">
																									<a href="'.$btn_url.'" class="hgr_buy_btn">
																									<span class="btn btn-hgr '.$buy_btn_size.'" style="
																									'.(!empty($buy_btn_border_width) ? 'border:'.$buy_btn_border_width.'px solid '.$buy_btn_border_color.';' : 'border:none;' ).' 
																									'.(!empty($buy_btn_color) ? 'background-color:'.$buy_btn_color.';' : 'background-color:transparent;' ).'
																									'.(!empty($buy_btn_border_roundness) ? 'border-radius:'.$buy_btn_border_roundness.'px;' : 'border-radius:0;' ).'">'.$buy_btn_text.'</span>
																									</a></div>'; }
		$output .= '</div>';
		
		
		
		/*
			Return the output
		*/
		return $output;
	}

if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_hgr_pricing_tables extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_hgr_pricing_table extends WPBakeryShortCode {}
}
?>