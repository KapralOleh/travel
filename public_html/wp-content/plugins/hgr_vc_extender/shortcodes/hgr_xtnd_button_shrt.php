<?php
/*
	Shortcode: Button
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_button', 'hgr_button' );
function hgr_button ($atts) {
			/*
				 Include necessary JS and CSS
			*/
			wp_enqueue_script('hgr-vc-jquery-appear');
			
			/*
				 Empty vars declaration
			*/
			$output = $do_icon = $hgr_buttontext = $hgr_buttontextsize = $hgr_buttontextcolor = $hgr_buttontexthovercolor = 
			$hgr_buttoncolor = $hgr_buttoncolorhover = $hgr_buttonwidth = $hgr_buttonwidthunits = $hgr_buttonheight = 
			$hgr_buttonheightunits = $hgr_buttonborderweight = $hgr_buttonbodercolor = $hgr_buttonbordercolorhover = 
			$hgr_buttonroundness = $hgr_buttonurl = $hgr_hasicon = $hgr_iconposition = $hgr_button_icontype = 
			$hgr_button_icon = $hgr_button_img = $hgr_button_iconanimation = $hgr_button_iconanimationon = $hgr_button_iconsize = 
			$hgr_button_extraclass = $hgr_button_animation = $link_target = $link_title = $hgr_button_id = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'hgr_buttontext'				=> '',
				'hgr_buttontextsize'			=> '',
				'hgr_buttontextcolor'			=> '',
				'hgr_buttontexthovercolor'		=> '',
				'hgr_buttoncolor'				=> '',
				'hgr_buttoncolorhover'			=> '',
				'hgr_buttonwidth'				=> '',
				'hgr_buttonwidthunits'			=> '',
				'hgr_buttonheight'				=> '',
				'hgr_buttonheightunits'			=> '',
				'hgr_buttonborderweight'		=> '',
				'hgr_buttonbodercolor'			=> '',
				'hgr_buttonbordercolorhover'	=> '',
				'hgr_buttonroundness'			=> '',
				'hgr_buttonurl'					=> '',
				'hgr_hasicon'					=> '',
				'hgr_iconposition'				=> '',
				'hgr_button_icontype'			=> '',
				'hgr_button_icon'				=> '',
				'hgr_button_img'				=> '',
				'hgr_button_iconanimation'		=> '',
				'hgr_button_iconanimationon'	=> '',
				'hgr_button_iconsize'			=> '',
				'hgr_button_extraclass'			=> '',
				'hgr_button_animation'			=> ''
			), $atts));
			
			/*
				Font icon or image icon?
			*/
			if( $hgr_button_icontype == 'selector' && !empty($hgr_button_icon) ) {
				$do_icon = do_shortcode('[icon name="'.$hgr_button_icon.'" size="'.$hgr_button_iconsize.'px" ]');
			}
			elseif($hgr_button_icontype == 'custom' && !empty($hgr_button_img)){
				// image icon...
				$hgr_button_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $hgr_button_img, 'thumb_size' => 'full', 'class' => "hgr_button_imgicon" ) );
				$do_icon = $hgr_button_img_array['thumbnail'];
			}
			
			$hgr_button_style = 'width:'.$hgr_buttonwidth.$hgr_buttonwidthunits.';height:'.$hgr_buttonheight.$hgr_buttonheightunits.';line-height:'.$hgr_buttonheight.$hgr_buttonheightunits.';';
			

			/*
				Font size...
			*/
			if( !empty($hgr_buttontextsize) && $hgr_buttontextsize > 0 ){
				$hgr_button_style .= 'font-size:'.$hgr_buttontextsize.'px;';
			}
			/*
				Rounded corners?
			*/
			if( !empty($hgr_buttonroundness) && $hgr_buttonroundness > 0 ){
				$hgr_button_style .= 'border-radius:'.$hgr_buttonroundness.'px; -moz-border-radius:'.$hgr_buttonroundness.'px; -webkit-border-radius:'.$hgr_buttonroundness.'px;';
			}
			
			$hgr_button_id = "hgr-button-".uniqid();
			
			
				$output .='<script type="text/javascript">
						jQuery(document).ready(function() { ';
							$output .= 'jQuery(".'.$hgr_button_id.'.hgr_button").css("background-color","'.$hgr_buttoncolor.'");';
							$output .= 'jQuery(".'.$hgr_button_id.'.hgr_button").css("color","'.$hgr_buttontextcolor.'");';
							if( !empty($hgr_buttonborderweight) && $hgr_buttonborderweight > 0 ) {
								$output .= 'jQuery(".'.$hgr_button_id.'.hgr_button").css("border","'.$hgr_buttonborderweight.'px solid '.$hgr_buttonbodercolor.'");';
							}
							$output .='jQuery(".'.$hgr_button_id.'.hgr_button").mouseenter(function() {';
								if( $hgr_button_iconanimationon == 'onhover') {				
									$output .='jQuery(this).find("i").addClass("'.str_replace('hgr_','',$hgr_button_iconanimation).'");
												jQuery(this).find("i").css("width","'.$hgr_button_iconsize.'px");
												jQuery(this).find("i").css("height","'.$hgr_button_iconsize.'px");';
								} elseif( $hgr_button_iconanimationon == 'always') {
									$output .='
										jQuery(".'.$hgr_button_id.'.hgr_button i").addClass(" '.str_replace('hgr_','',$hgr_button_iconanimation).' ");
										jQuery(".'.$hgr_button_id.'.hgr_button i").css("width","'.$hgr_button_iconsize.'px");
										jQuery(".'.$hgr_button_id.'.hgr_button i").css("height","'.$hgr_button_iconsize.'px");';
								}
								
								// Button border on hover
								if($hgr_buttonborderweight>0){
									$output .='jQuery(this).css("border","'.$hgr_buttonborderweight.'px solid '.$hgr_buttonbordercolorhover.'");';
								}
								// Button BG color on hover
								$output .='jQuery(this).css("background-color","'.$hgr_buttoncolorhover.'");';
								
								// Text color on hover
								$output .='jQuery(this).css("color","'.$hgr_buttontexthovercolor.'");';
								
								$output .='}).mouseleave(function() {';
									
									// Button BG color on normal state
									$output .='jQuery(this).css("background-color","'.$hgr_buttoncolor.'");';
									
									// Text color normal state
									$output .='jQuery(this).css("color","'.$hgr_buttontextcolor.'");';
									
									if( $hgr_button_iconanimationon == 'onhover') {	
										$output .='jQuery(this).find("i").removeClass("'.str_replace('hgr_','',$hgr_button_iconanimation).'");';
									}
									if( !empty($hgr_buttonborderweight) && $hgr_buttonborderweight > 0 ) {
								$output .= 'jQuery(this).css("border","'.$hgr_buttonborderweight.'px solid '.$hgr_buttonbodercolor.'");';
							}
									$output .='});';
				$output .='});</script>';
			
			$href = vc_build_link($hgr_buttonurl);
				if($href['url'] !== '') {
					$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
					$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
				}
			$output .= '<a href="'.$href['url'].'"'.$link_target.''.$link_title.' class="hgr_button '.$hgr_button_id.' '.$hgr_button_extraclass.' '.$hgr_button_animation.'" style="'.$hgr_button_style.'">';
				// NO ICON
				if( $hgr_hasicon == 'noicon' ){
					$output .= $hgr_buttontext;
				} else {
					// LEFT ICON
					if( $hgr_iconposition == 'left' ){
						$output .= $do_icon.' &nbsp;&nbsp; '.$hgr_buttontext;
					}
					// RIGHT ICON
					elseif( $hgr_iconposition == 'right' ){
						$output .= $hgr_buttontext.' &nbsp;&nbsp; '.$do_icon;
					}
				}		
			$output .='</a>';
			
			/*
				Return the output
			*/		
			return $output;
		}
?>