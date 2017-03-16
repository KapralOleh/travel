<?php
/*
	Shortcode: mailChimp Collector element
	Based on Rendro Easy Pie Chart: https://github.com/rendro/easy-pie-chart
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_pie_chart', 'hgr_pie' );
function hgr_pie ($atts) {
			/*
				Include required JS on front-end
			*/
			wp_enqueue_script('hgr-vc-jquery-appear');
			wp_enqueue_script('hgr-vc-jquery-easing');
			wp_enqueue_script('hgr-vc-jquery-easypiechart');
			
			/*
				Empty vars declaration
			*/
			$output = $pie_title = $pie_text = $gotourl = $pie_percent = $scale_color = $pie_size = $hgr_pie_percent_size = $bar_width = 
			$back_style = $icon_color = $back_line_color = $front_line_color = $icon_type = $icon = $icon_img = $hgr_pie_icnsize = $hgr_pie_extraclass = '';
			
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'pie_title'					=>	'',
				'pie_text'					=>	'', 
				'gotourl'					=>	'', 
				'pie_percent'				=>	'80', // %
				'hgr_pie_percent_size'		=>	'',
				'scale_color'				=>	'#808080',
				'pie_size'					=>	'80', // px
				'bar_width'					=>	'4', //px
				'back_style'				=>	'dashed',
				'back_line_color'			=>	'#e2e1dc',
				'front_line_color'			=>	'#80c8ac',
				'icon_type'					=>	'',
				'icon'						=>	'',
				'icon_img'					=>	'',
				'icon_color'				=>	'',
				'hgr_pie_icnsize'			=>	'',
				'hgr_pie_extraclass'		=>	'',
			), $atts));
			
			/*
				Do the icon, font or custom image
			*/
			if( $icon_type == 'selector' && !empty($icon) ) {
				$do_icon = do_shortcode('[icon name="'.$icon.'" size="'.$hgr_pie_icnsize.'px" height="'.$hgr_pie_icnsize.'px" color="'.$icon_color.'"]');
			}
			elseif($icon_type == 'custom' && !empty($icon_img)){
				/* Image icon... */
				$hgr_piechart_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icon_img, 'thumb_size' => 'full', 'class' => "hgr_piechart_imgicon" ) );
				$do_icon = $hgr_piechart_img_array['thumbnail'];
			}
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							
							jQuery("'.(!empty($hgr_pie_extraclass) ? '.'.$hgr_pie_extraclass : '').'.hgr_pie_chart i").css("color","'.$icon_color.'");
							jQuery("'.(!empty($hgr_pie_extraclass) ? '.'.$hgr_pie_extraclass : '').'.hgr_pie_chart span.percent").css("font-size","'.$hgr_pie_percent_size.'px");
							
							jQuery("'.(!empty($hgr_pie_extraclass) ? '.'.$hgr_pie_extraclass : '').'.hgr_pie_chart").appear(function() {
							  jQuery("'.(!empty($hgr_pie_extraclass) ? '.'.$hgr_pie_extraclass : '').'.hgr_pie_chart .chart").easyPieChart({
									easing: "easeOutBounce",
									barColor:"'.$front_line_color.'",
									trackColor:"'.$back_line_color.'",
									scaleColor:"'.$scale_color.'",
									animate: 3500,
									size:"'.$pie_size.'",
									lineWidth:"'.$bar_width.'",
									onStep: function(from, to, percent) {
										jQuery(this.el).find(".percent").text(Math.round(percent));
									}
								});
								var chart = window.chart = jQuery("'.(!empty($hgr_pie_extraclass) ? '.'.$hgr_pie_extraclass : '').'.hgr_pie_chart .chart").data("easyPieChart");
							});
						});
				</script>';
			
			$output .= '<div class="hgr_pie_chart '.$hgr_pie_extraclass.'">';
				$output .='<span class="chart" data-percent="'.$pie_percent.'">';
					if(!empty($icon)) { $output .= '<span style="color:'.$back_line_color.'">'.$do_icon.'</span>'; }
					$output .='<span class="percent" style="color:'.$front_line_color.'"></span>';
				$output .='</span>';
				if(!empty($pie_title)) { $output .='<h4>'.$pie_title.'</h4>'; }
				if(!empty($pie_text)) { $output .='<p>'.$pie_text.'</p>'; }
				$href = vc_build_link($gotourl);
				if($href['url'] !== '') {
					$link_target = (isset($href['target'])) ? 'target="'.$href['target'].'"' : '';
					$link_title = (isset($href['title'])) ? 'title="'.$href['title'].'"' : '';
				}
				if(!empty($href['url'])) { $output .='<p><a href="'.$href['url'].'" '.$link_target.' '.$link_title.' class="morelink-white">READ MORE</a></p>'; }
			$output .= '</div>';
			
			/*
				Return the output
			*/	
			return $output;
		}
?>