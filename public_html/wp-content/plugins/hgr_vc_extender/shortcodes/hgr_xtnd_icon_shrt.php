<?php
/*
	Shortcode: Icon element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_icon', 'hgr_icon' );
function hgr_icon ($atts) {
			
	/*
		 Empty vars declaration
	*/
	$output = $icntxt_icon = $icntxt_iconcolor = $icntxt_icnsize = $icontxt_img = $icontxt_img_width = $icon_background_type = $icntxt_icnbackcolor = $icntxt_icnbacksize = $icntxt_icnbackroundness = $icon_border_type = $icntxt_icnbordercolor = $icntxt_icnbordercolor_hover = $icntxt_icnbordersize = $icntxt_iconcolor_hover = $icntxt_icnbackcolor_hover = $custom_link = $icntxt_link = $icntxt_extraclass = $hgr_icon_img_array = $content_icon = $normal_bd = $hover_bd = '';
	
	/*
		WordPress function to extract shortcodes attributes
		Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
	*/
	extract(shortcode_atts(array(
		'icon_type'						=> '',
		'icntxt_icon'					=> '',
		'icntxt_iconcolor'				=> '',
		'icntxt_icnsize'				=> '',
		'icontxt_img'					=> '',
		'icontxt_img_width'				=> '',
		'icon_background_type'			=> '',
		'icntxt_icnbackcolor'			=> '',
		'icntxt_icnbacksize'			=> '',
		'icntxt_icnbackroundness'		=> '',
		'icon_border_type'				=> '',
		'icntxt_icnbordercolor'			=> '',
		'icntxt_icnbordercolor_hover'	=> '',
		'icntxt_icnbordersize'			=> '',
		'icntxt_iconcolor_hover'		=> '',
		'icntxt_icnbackcolor_hover'		=> '',
		'custom_link'		            => '',
		'icntxt_link'		            => '',
		'icntxt_extraclass'				=> '',
	), $atts));
	
	
	
	/*
		Font icon or Image icon?
	*/
	
	if( $icon_type == 'selector' && !empty($icntxt_icon) ) {
		$content_icon = do_shortcode('[icon name="'.$icntxt_icon.'" size="'.$icntxt_icnsize.'px" height="'.$icntxt_icnsize.'px" color="'.$icntxt_iconcolor.'"]');
	}
	elseif($icon_type == 'custom' && !empty($icontxt_img)){
		$hgr_icon_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $icontxt_img, 'thumb_size' => 'full', 'class' => "" ) );
		$content_icon = '<div style="display:table;width:100%;height:100%;"><div style="display:table-cell;"><div style="width:'.$icontxt_img_width.'px; height:'.$icontxt_img_width.'px; margin: auto; vertical-align: text-top;">'.$hgr_icon_img_array['thumbnail'].'</div></div></div>';
	}
	
	
	switch($icon_border_type){
		case 'none':
			$normal_bd = '0px';
		break;
		
		case 'icon-border-select':
			$normal_bd = $icntxt_icnbordersize.'px solid '.$icntxt_icnbordercolor;
			$hover_bd = $icntxt_icnbordersize.'px solid '.$icntxt_icnbordercolor_hover;
		break;
		
		default:
	}
	
	$icon_id = "hgr-onlyicon-".uniqid();


	if($icntxt_icon !== '' && $icon_background_type == 'none') {
		
		if ($icntxt_iconcolor_hover !== '') {
	
			$output .='<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(".'.$icon_id.' .icon").css("color","'.$icntxt_iconcolor.'");
					
					jQuery(".'.$icon_id.' .icon").mouseenter(function() {
							jQuery(this).css("color","'.$icntxt_iconcolor_hover.'");
						}).mouseleave(function() {
							jQuery(this).css("color","'.$icntxt_iconcolor.'");
						});
				});
			</script>';
		}
		$output .= '<div class="hgr-icontxt '.$icon_id.' '.$icntxt_extraclass.'">';
		if($custom_link !== 'no-link'){
			$href = vc_build_link($icntxt_link);
			if($href['url'] !== '') {
				$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
				$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
			}
			$output .= '<a href="'.$href['url'].'"'.$link_target.$link_title.'>';
			$output .= $content_icon;
			$output .= '</a>';
		}
		else {
			$output .= $content_icon;
		}
		$output .= '</div>';
	}
	
	if($icntxt_icon !== '' && $icon_background_type == 'icon-background-select') {
		if ($icntxt_iconcolor_hover !== '' || $icntxt_icnbackcolor_hover !== '') {
			$output .='<script type="text/javascript">';
			
				$output .='jQuery(document).ready(function() {';
				if ($icntxt_iconcolor_hover !== '') {
					$output .= 'jQuery(".'.$icon_id.' .icon").css("color","'.$icntxt_iconcolor.'");
					jQuery(".'.$icon_id.'").mouseenter(function() {
							jQuery(this).find(".icon").css("color","'.$icntxt_iconcolor_hover.'");
						}).mouseleave(function() {
							jQuery(this).find(".icon").css("color","'.$icntxt_iconcolor.'");
						});';
				}
				
				/* Add border color */
				
				$output .= 'jQuery(".'.$icon_id.'").css("border","'.$normal_bd.'");';
				if ($icntxt_icnbordercolor_hover !== '') {
				$output .= 'jQuery(".'.$icon_id.'").mouseenter(function() {
						jQuery(this).css("border","'.$hover_bd.'");
					}).mouseleave(function() {
						jQuery(this).css("border","'.$normal_bd.'");
					});';
				}
				
				if ($icntxt_icnbackcolor_hover !== '') {
					$output .= 'jQuery(".'.$icon_id.'").css("background","'.$icntxt_icnbackcolor.'");
					jQuery(".'.$icon_id.'").mouseenter(function() {
							jQuery(this).css("background","'.$icntxt_icnbackcolor_hover.'");
						}).mouseleave(function() {
							jQuery(this).css("background","'.$icntxt_icnbackcolor.'");
						});';
				}
				$output .= '});';
			$output .='</script>';
		}
		$output .= '<div class="hgr-icontxt '.$icon_id.' '.(!empty($icntxt_extraclass) ? $icntxt_extraclass : '').'" style="background-color:'.$icntxt_icnbackcolor.';width:'.$icntxt_icnbacksize.'px;height:'.$icntxt_icnbacksize.'px;line-height:'.$icntxt_icnbacksize.'px;border-radius:'.$icntxt_icnbackroundness.'px;-moz-border-radius:'.$icntxt_icnbackroundness.'px;-webkit-border-radius:'.$icntxt_icnbackroundness.'px;-o-border-radius:'.$icntxt_icnbackroundness.'px;">';
		if($custom_link == 'yes-link'){
			$href = vc_build_link($icntxt_link);
			if($href['url'] !== '') {
				$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
				$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
			}
			$output .= '<a href="'.$href['url'].'"'.$link_target.$link_title.'>';
			$output .= $content_icon;
			$output .= '</a>';
		}
		else {
			$output .= $content_icon;
		}
		$output .= '</div>';
	}
	
	/*
		Return the output
	*/
	return $output;
}
?>