<?php
/*
	Shortcode: Accordion element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_accordion', 'hgr_accordion');
function hgr_accordion($atts, $content = null ) {
			/*
				Include required JS and CSS files
			*/
			wp_enqueue_script('hgr-vc-jquery-appear');
			
			/*
				 Empty vars declaration
			*/
			$output=$acc_panelheader_textcolor = $acc_panel_color = $acc_panelbody_color = $acc_panelbody_textcolor = $acc_panel_header_height = $acc_panel_header_roundness = $acc_unique_id = $extra_class = '';
			$navs=array();
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'acc_panelheader_textcolor'			=>	'#80c8ac',
				'acc_panel_color'				=>	'',
				'acc_panelbody_color'			=>	'transparent',
				'acc_panelbody_textcolor'		=>	'',
				'acc_panel_header_height'		=>	'',
				'acc_panel_header_roundness'	=>	'0',
				'acc_unique_id'				=>	'accid'.mt_rand(999, 9999999),
				'extra_class'					=>	'',
			), $atts));
			
			$GLOBALS['acc_unique_id'] = $acc_unique_id;
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							
							// activate first tab
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .panel").first().find(".panel-collapse").addClass("in");
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .panel").first().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
							
							// style the panel
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .panel").css("border-radius","'.$acc_panel_header_roundness.'").css("background-color","'.$acc_panelbody_color.'");
							
							// style the panel header
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-heading").css("border-top-right-radius","'.$acc_panel_header_roundness.'").css("border-top-left-radius","'.$acc_panel_header_roundness.'");
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-heading").css("background-color","'.$acc_panel_color.'").css("height","'.$acc_panel_header_height.'");
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-heading").css("padding-left","10px").css("padding-right","10px").css("padding-top","0px").css("padding-bottom","0px");
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-title a").css("color","'.$acc_panelheader_textcolor.'");
							
							// style the panel title
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-title").css("line-height","'.$acc_panel_header_height.'px");
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-title a").css("display","block");
							
							// style the panel title icon
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-title .icon").css("margin-right","10px").css("line-height","inherit");
							
							// style the panel body
							jQuery("'.(!empty($acc_unique_id) ? '#'.$acc_unique_id : '.hgr_accordion').' .hgracc-body").css("background-color","'.$acc_panelbody_color.'").css("color","'.$acc_panelbody_textcolor.'");
							
							jQuery(".panel-collapse").on("shown.bs.collapse", function () {
							   jQuery(this).parent().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
							});
							
							jQuery(".panel-collapse").on("hidden.bs.collapse", function () {
							   jQuery(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
							});

						});
						</script>';
			
			$output .= '<div class="hgr_accordion panel-group '.(!empty($extra_class) ? $extra_class : '').'" id="'.(!empty($acc_unique_id) ? $acc_unique_id : '').'">';
				$output .= do_shortcode($content);
			$output .= '</div>';
						
			return $output;
		}
		
/*
	Accordion sub-element
*/
add_shortcode( 'hgr_accordion_element', 'hgr_accordion_element');
function hgr_accordion_element($atts, $content = null) {
			$output = $hgr_accordion_icontype = $hgr_accordion_icon = $acc_icon_color = $hgr_accordion_icnsize = $hgr_accordion_img = $panel_title = $panel_body = '';
		
			extract(shortcode_atts(array(
				'hgr_accordion_icontype'=>	'',
				'hgr_accordion_icon'	=>	'',
				'acc_icon_color'		=>	'',
				'hgr_accordion_icnsize'	=>	'',
				'hgr_accordion_img'		=>	'',
				'panel_title'			=>	'',
				'panel_body'				=>	'',
			), $atts));
			
			
			
			if( $hgr_accordion_icontype == 'selector' && !empty($hgr_accordion_icon) ) {
				$do_icon = do_shortcode('[icon name="'.$hgr_accordion_icon.'" size="'.$hgr_accordion_icnsize.'px" height="'.$hgr_accordion_icnsize.'px" color="'.$acc_icon_color.'"]');
			}
			elseif($hgr_accordion_icontype == 'custom' && !empty($hgr_accordion_img)){
				// image type icon TO DO
				$hgr_accordion_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $hgr_accordion_img, 'thumb_size' => 'full', 'class' => "hgr_accordion_imgicon" ) );
				$do_icon = $hgr_accordion_img_array['thumbnail'];
			}

			$output .='<div class="panel">
						<div class="hgracc-heading">
						  <h4 class="hgracc-title">
							<a data-toggle="collapse" data-parent="#'.$GLOBALS['acc_unique_id'].'" href="#tabid'.strtolower(md5($panel_title)).'">'.$do_icon.$panel_title.' <i class="icon collapseicon fa fa-plus" style="float:right;"></i></a>
						  </h4>
						</div>
						<div id="tabid'.strtolower(md5($panel_title)).'" class="panel-collapse collapse">
						  <div class="hgracc-body" style="padding:10px;">';
						  $output .= wpb_js_remove_wpautop($content, true);
						  $output .= '</div>
						</div>
					  </div>';
			
			return $output;
		}
if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_hgr_accordion extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_hgr_hgr_accordion_element extends WPBakeryShortCode {}
}
?>