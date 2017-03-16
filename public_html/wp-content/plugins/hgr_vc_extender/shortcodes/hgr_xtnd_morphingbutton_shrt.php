<?php
/*
	Shortcode: Morphing Button
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_morphingbutton', 'hgr_morphingbutton' );
function hgr_morphingbutton ($atts) {
			
			/*
				Include MailChimp API
			*/
			require_once( plugin_dir_path( dirname(__FILE__) ).'includes/apis/MCAPI.class.php');
			
			/*
				 Include necessary JS and CSS
			*/
			wp_enqueue_style('hgr-vc-morphbtn-general-css');
			
			/*
				 Empty vars declaration
			*/
			$output = 
			// MORPH BTN TYPE (Info, Info Overlay, Subscribe, Share, Video Player)
			$hgr_morphbtn_btn_type = 
			
			// GENERAL BTN STYLE
			$hgr_morphbtn_btn_text = $hgr_morphbtn_btn_text_size = $hgr_morphbtn_btn_text_color = $hgr_morphbtn_btn_text_hover_color = $hgr_morphbtn_btn_color = $hgr_morphbtn_btn_hover_color = $hgr_morphbtn_btn_width = 
			$hgr_morphbtn_btn_width_units = $hgr_morphbtn_btn_height = $hgr_morphbtn_btn_height_units = $hgr_morphbtn_btn_border_weight = $hgr_morphbtn_btn_border_color = $hgr_morphbtn_btn_border_hover_color = $hgr_morphbtn_btn_roundness = 
			
			// INFO BTN SPECIFIC
			$hgr_morphbtn_info_bg_color = $hgr_morphbtn_info_title = $hgr_morphbtn_info_title_color = $hgr_morphbtn_info_description = $hgr_morphbtn_info_description_color = 
			$hgr_morphbtn_info_custom_link = $hgr_morphbtn_info_address_link = $hgr_morphbtn_info_link_text = $hgr_morphbtn_info_link_color = 
			
			// INFO OVERLAY SPECIFIC
			$hgr_morphbtn_infooverlay_bgcolor = $hgr_morphbtn_infooverlay_title = $hgr_morphbtn_infooverlay_title_color = $hgr_morphbtn_infooverlay_description = $hgr_morphbtn_infooverlay_description_color = 
			
			// SUBSCRIBE SPECIFIC
			$hgr_morphbtn_subscribe_bgcolor = $hgr_morphbtn_subscribe_label = $hgr_morphbtn_subscribe_label_color = $hgr_morphbtn_subscribe_spam = $hgr_morphbtn_subscribe_spam_color = $hgr_morphbtn_subscribe_btn_text = 
			$hgr_morphbtn_subscribe_btn_text_size = $hgr_morphbtn_subscribe_btn_text_color = $hgr_morphbtn_subscribe_btn_text_hover_color = $hgr_morphbtn_subscribe_btn_color = $hgr_morphbtn_subscribe_btn_hover_color = 
			$hgr_morphbtn_subscribe_mc_apikey = $hgr_morphbtn_subscribe_mc_listid = 
			
			// SHARE SPECIFIC
			$hgr_morphbtn_share_bgcolor = $hgr_morphbtn_share_links_color = $hgr_morphbtn_share_links_hover_color = $hgr_morphbtn_share_fbk = $hgr_morphbtn_share_fbk_appid = $hgr_morphbtn_share_twtr = $hgr_morphbtn_share_twtr_via = $hgr_morphbtn_share_gglpls = 
			
			// VIDEO SPECIFIC
			$hgr_morphbtn_video_type = $hgr_morphbtn_video_url = 
			
			// EXTRA CLASS
			$hgr_morphbtn_extra_class = $morph_btn_link = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'hgr_morphbtn_btn_type'							=> '',
				'hgr_morphbtn_btn_text'							=> '',
				
				'hgr_morphbtn_btn_text_size'					=> '',
				'hgr_morphbtn_btn_text_color'					=> '',
				'hgr_morphbtn_btn_text_hover_color'				=> '',
				'hgr_morphbtn_btn_color'						=> '',
				'hgr_morphbtn_btn_hover_color'					=> '',
				'hgr_morphbtn_btn_width'						=> '',
				'hgr_morphbtn_btn_height'						=> '',
				'hgr_morphbtn_btn_border_weight'				=> '0',
				'hgr_morphbtn_btn_border_color'					=> '',
				'hgr_morphbtn_btn_border_hover_color'			=> '',
				'hgr_morphbtn_btn_roundness'					=> '',
				
				'hgr_morphbtn_info_bg_color'					=> '',
				'hgr_morphbtn_info_title'						=> '',
				'hgr_morphbtn_info_title_color'					=> '',
				'hgr_morphbtn_info_description'					=> '',
				'hgr_morphbtn_info_description_color'			=> '',
				'hgr_morphbtn_info_custom_link'					=> '',
				'hgr_morphbtn_info_address_link'				=> '',
				'hgr_morphbtn_info_link_text'					=> '',
				'hgr_morphbtn_info_link_color'					=> '',
				
				'hgr_morphbtn_infooverlay_bgcolor'				=> '',
				'hgr_morphbtn_infooverlay_title'				=> '',
				'hgr_morphbtn_infooverlay_title_color'			=> '',
				'hgr_morphbtn_infooverlay_description'			=> '',
				'hgr_morphbtn_infooverlay_description_color'	=> '',
				
				'hgr_morphbtn_subscribe_bgcolor'				=> '',
				'hgr_morphbtn_subscribe_label'					=> '',
				'hgr_morphbtn_subscribe_label_color'			=> '',
				'hgr_morphbtn_subscribe_spam'					=> '',
				'hgr_morphbtn_subscribe_spam_color'				=> '',
				'hgr_morphbtn_subscribe_btn_text'				=> '',
				'hgr_morphbtn_subscribe_btn_text_size'			=> '',
				'hgr_morphbtn_subscribe_btn_text_color'			=> '',
				'hgr_morphbtn_subscribe_btn_text_hover_color'	=> '',
				'hgr_morphbtn_subscribe_btn_color'				=> '',
				'hgr_morphbtn_subscribe_btn_hover_color'		=> '',
				'hgr_morphbtn_subscribe_mc_apikey'				=> '',
				'hgr_morphbtn_subscribe_mc_listid'				=> '',
				
				'hgr_morphbtn_share_bgcolor'					=> '',
				'hgr_morphbtn_share_links_color'				=> '',
				'hgr_morphbtn_share_links_hover_color'			=> '',
				'hgr_morphbtn_share_fbk'						=> '',
				'hgr_morphbtn_share_fbk_appid'					=> '',
				'hgr_morphbtn_share_twtr'						=> '',
				'hgr_morphbtn_share_twtr_via'					=> '',
				'hgr_morphbtn_share_gglpls'						=> '',
				
				'hgr_morphbtn_video_type'						=> '',
				'hgr_morphbtn_video_url'						=> '',
				
				'hgr_morphbtn_extra_class'						=> '',
			), $atts));
			
			
			$hgr_morphbtn_btn_style = 'background-color:'.$hgr_morphbtn_btn_color.'; width:'.$hgr_morphbtn_btn_width.'px; height:'.$hgr_morphbtn_btn_height.'px; color:'.$hgr_morphbtn_btn_text_color.';';
			

			/*
				Font size...
			*/
			if( !empty($hgr_morphbtn_btn_text_size) && $hgr_morphbtn_btn_text_size > 0 ){
				$hgr_morphbtn_btn_style .= 'font-size:'.$hgr_morphbtn_btn_text_size.'px;';
			}
			/*
				Rounded corners?
			*/
			if( !empty($hgr_morphbtn_btn_roundness) && $hgr_morphbtn_btn_roundness > 0 ){
				$hgr_morphbtn_btn_style .= 'border-radius:'.$hgr_morphbtn_btn_roundness.'px; -moz-border-radius:'.$hgr_morphbtn_btn_roundness.'px; -webkit-border-radius:'.$hgr_morphbtn_btn_roundness.'px;';
			}
			/*
				Any border?
			*/
			if( !empty($hgr_morphbtn_btn_border_weight) && $hgr_morphbtn_btn_border_weight > 0 ){
				$hgr_morphbtn_btn_style .= 'border:'.$hgr_morphbtn_btn_border_weight.'px solid '.$hgr_morphbtn_btn_border_color.';';
			} else {
				$hgr_morphbtn_btn_style .= 'border:none;';
			}
			
			$hgr_morphbtn_id = "hgr-morphbtn".uniqid();
			
			
			// Output depends on the selected "Button Type"... So...
			switch($hgr_morphbtn_btn_type){
				
				// INFO BTN SPECIFIC
				case 'hgr_morphbtn_info':
					wp_enqueue_style('hgr-vc-morphbtn-info-css');
					
					if($hgr_morphbtn_info_custom_link == 'custom-link-on') {
						$href = vc_build_link($hgr_morphbtn_info_address_link);
						if($href['url'] !== '') {
							$link_target = (isset($href['target'])) ? ' target="'.$href['target'].'"' : '';
							$link_title = (isset($href['title'])) ? ' title="'.$href['title'].'"' : '';
							
							$morph_btn_link = '<a style="color:'.$hgr_morphbtn_info_link_color.';" href="'.$href['url'].'" '.$link_target.' '.$link_title.'>'.$hgr_morphbtn_info_link_text.'</a>';
						}
					}
					
					
					
					
					$output .= '
					<style>
					.'.$hgr_morphbtn_id.', .'.$hgr_morphbtn_id.' .morph-content {
							width: '.$hgr_morphbtn_btn_width.'px;
							height: '.$hgr_morphbtn_btn_height.'px;
						}
					.content-style-text p {
						color:'.$hgr_morphbtn_info_description_color.';
					}
					</style>
					
					
					<script type="text/javascript">
						jQuery(document).ready(function() {
							
							var docElem = window.document.documentElement, didScroll, scrollPosition;
			
							// trick to prevent scrolling when opening/closing button
							function noScrollFn() {
								window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
							}
			
							function noScroll() {
								window.removeEventListener( "scroll", scrollHandler );
								window.addEventListener( "scroll", noScrollFn );
							}
			
							function scrollFn() {
								window.addEventListener( "scroll", scrollHandler );
							}
			
							function canScroll() {
								window.removeEventListener( "scroll", noScrollFn );
								scrollFn();
							}
			
							function scrollHandler() {
								if( !didScroll ) {
									didScroll = true;
									setTimeout( function() { scrollPage(); }, 60 );
								}
							};
			
							function scrollPage() {
								scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
								didScroll = false;
							};
			
							scrollFn();
							
							var UIBtnn = new UIMorphingButton( document.querySelector( ".'.$hgr_morphbtn_id.'" ), {
								closeEl : ".fa-times",
								onBeforeOpen : function() {
									// don\'t allow to scroll
									noScroll();
								},
								onAfterOpen : function() {
									// can scroll again
									noScroll();
								},
								onBeforeClose : function() {
									// don\'t allow to scroll
									noScroll();
								},
								onAfterClose : function() {
									// can scroll again
									canScroll();
								}
							});
							

							jQuery(".'.$hgr_morphbtn_id.'").mouseenter(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_hover_color.'");
							}).mouseleave(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_color.'");
							});
						});
					</script>
					';
					
					$output .= '<div class="morph-button morph-button-modal morph-button-modal-1 morph-button-fixed '.$hgr_morphbtn_id.' '.$hgr_morphbtn_extra_class.'">
						<button type="button" style="'.$hgr_morphbtn_btn_style.'">'.$hgr_morphbtn_btn_text.'</button>
						<div style="background-color:'.$hgr_morphbtn_info_bg_color.';" class="morph-content">
							<div>
								<div class="content-style-text">
									<span class="fa fa-times" style="color:'.$hgr_morphbtn_info_title_color.';">Close the dialog</span>
									<h2 style="color:'.$hgr_morphbtn_info_title_color.';">'.$hgr_morphbtn_info_title.'</h2>
									'.wpb_js_remove_wpautop($hgr_morphbtn_info_description, true).'
									'.$morph_btn_link.'
								</div>
							</div>
						</div>
					</div><!-- HGR Info MorphBTN -->';
					break;
				
				
				// INFO OVERLAY SPECIFIC
				case 'hgr_morphbtn_infooverlay':
					wp_enqueue_style('hgr-vc-morphbtn-info-css');
					
					
					$output .= '
					<style>
					.'.$hgr_morphbtn_id.', .'.$hgr_morphbtn_id.' .morph-content {
							width: '.$hgr_morphbtn_btn_width.'px;
							height: '.$hgr_morphbtn_btn_height.'px;
						}
					</style>
					
					
					<script type="text/javascript">
						jQuery(document).ready(function() {
							
							var docElem = window.document.documentElement, didScroll, scrollPosition;
			
							// trick to prevent scrolling when opening/closing button
							function noScrollFn() {
								window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
							}
			
							function noScroll() {
								window.removeEventListener( "scroll", scrollHandler );
								window.addEventListener( "scroll", noScrollFn );
							}
			
							function scrollFn() {
								window.addEventListener( "scroll", scrollHandler );
							}
			
							function canScroll() {
								window.removeEventListener( "scroll", noScrollFn );
								scrollFn();
							}
			
							function scrollHandler() {
								if( !didScroll ) {
									didScroll = true;
									setTimeout( function() { scrollPage(); }, 60 );
								}
							};
			
							function scrollPage() {
								scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
								didScroll = false;
							};
			
							scrollFn();
							
							var UIBtnn = new UIMorphingButton( document.querySelector( ".'.$hgr_morphbtn_id.'" ), {
								closeEl : ".fa-times",
								onBeforeOpen : function() {
									// don\'t allow to scroll
									noScroll();
								},
								onAfterOpen : function() {
									// can scroll again
									noScroll();
								},
								onBeforeClose : function() {
									// don\'t allow to scroll
									noScroll();
								},
								onAfterClose : function() {
									// can scroll again
									canScroll();
								}
							});
							
							jQuery(".'.$hgr_morphbtn_id.' .content-style-overlay p" ).css("color", "'.$hgr_morphbtn_infooverlay_description_color.'");
							
							jQuery(".'.$hgr_morphbtn_id.'").mouseenter(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_hover_color.'");
							}).mouseleave(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_color.'");
							});
						});
					</script>
					';
					
					$output .= '<div class="morph-button morph-button-overlay morph-button-fixed '.$hgr_morphbtn_id.' '.$hgr_morphbtn_extra_class.'">
						<button type="button" style="'.$hgr_morphbtn_btn_style.'">'.$hgr_morphbtn_btn_text.'</button>
						<div style="background-color:'.$hgr_morphbtn_infooverlay_bgcolor.';" class="morph-content">
							<div>
								<div class="content-style-overlay">
									<span class="fa fa-times" style="color:'.$hgr_morphbtn_infooverlay_title_color.';">Close the dialog</span>
									<h2 style="color:'.$hgr_morphbtn_infooverlay_title_color.';">'.$hgr_morphbtn_infooverlay_title.'</h2>
									'.wpb_js_remove_wpautop($hgr_morphbtn_infooverlay_description, true).'
								</div>
							</div>
						</div>
					</div><!-- HGR Info MorphBTN -->';
					break;
				
				
				// SUBSCRIBE SPECIFIC
				case 'hgr_morphbtn_subscribe':
					if( empty($hgr_morphbtn_subscribe_mc_apikey) ) {return 'Please insert your MailChimp API Key!';}	
					if( empty($hgr_morphbtn_subscribe_mc_listid) ) {return 'Please insert your MailChimp list ID!';}
			
					wp_enqueue_style('hgr-vc-morphbtn-info-css');
						
						$hgr_morphbtn_btn_height_recalculated = $hgr_morphbtn_btn_height + $hgr_morphbtn_btn_border_weight*2;
						$output .= '
						<style>
						.'.$hgr_morphbtn_id.', .'.$hgr_morphbtn_id.' .morph-content {
							width: '.$hgr_morphbtn_btn_width.'px;
						}
						.'.$hgr_morphbtn_id.'.morph-button-inflow {
							height: '.$hgr_morphbtn_btn_height_recalculated.'px;
						}
						
						.'.$hgr_morphbtn_id.', .'.$hgr_morphbtn_id.'.open .morph-content {
							background-color:'.$hgr_morphbtn_subscribe_bgcolor.';
						}
						.morph-button-inflow > button {
							line-height:'.$hgr_morphbtn_btn_height.'px;
						}
						.morph-button-inflow .morph-content .morph-clone {
							font-size: '.$hgr_morphbtn_btn_text_size.'px;
							line-height:'.$hgr_morphbtn_btn_height.'px;
						}
						.morph-button-inflow-1 .morph-content .morph-clone {
							color: '.$hgr_morphbtn_subscribe_btn_text_color.';
							background: none repeat scroll 0% 0% '.$hgr_morphbtn_btn_color.';
							border: '.$hgr_morphbtn_btn_border_weight.'px solid '.$hgr_morphbtn_btn_border_color.';
						}
						.content-style-form label, .content-style-form-4 form {
							color: '.$hgr_morphbtn_subscribe_label_color.';
						}
						.'.$hgr_morphbtn_id.' .content-style-form button.sbcrb_form_btn {
							background-color: '.$hgr_morphbtn_subscribe_btn_color.';
						}
						</style>
						
						
						<script type="text/javascript">
							jQuery(document).ready(function() {
	
								new UIMorphingButtonInflow( document.querySelector( ".'.$hgr_morphbtn_id.'" ) );
								
								//jQuery(".'.$hgr_morphbtn_id.' .content-style-form p" ).css("color", "'.$hgr_morphbtn_infooverlay_description_color.'");
								
								
								jQuery(".'.$hgr_morphbtn_id.'").mouseenter(function() {
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("background-color", "'.$hgr_morphbtn_btn_hover_color.'");
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("color", "'.$hgr_morphbtn_btn_text_hover_color.'");
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("border-color", "'.$hgr_morphbtn_btn_border_hover_color.'");
								}).mouseleave(function() {
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("background-color", "'.$hgr_morphbtn_btn_color.'");
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("color", "'.$hgr_morphbtn_btn_text_color.'");
									jQuery(".'.$hgr_morphbtn_id.' .morph-clone").css("border-color", "'.$hgr_morphbtn_btn_border_color.'");
								});
								
								jQuery(".'.$hgr_morphbtn_id.'  button.sbcrb_form_btn").mouseenter(function() {
									jQuery(".'.$hgr_morphbtn_id.'  button.sbcrb_form_btn").css("background-color", "'.$hgr_morphbtn_subscribe_btn_hover_color.'");
									jQuery(".'.$hgr_morphbtn_id.'  button.sbcrb_form_btn").css("color", "'.$hgr_morphbtn_subscribe_btn_text_hover_color.'");
								}).mouseleave(function() {
									jQuery(".'.$hgr_morphbtn_id.'  button.sbcrb_form_btn").css("background-color", "'.$hgr_morphbtn_subscribe_btn_color.'");
									jQuery(".'.$hgr_morphbtn_id.'  button.sbcrb_form_btn").css("color", "'.$hgr_morphbtn_subscribe_btn_text_color.'");
								});
							});
						</script>
						';
						
						
						if(isset($_GET['submit'])) { 
								
								$mc_response = do_subscribe($hgr_morphbtn_subscribe_mc_apikey,$hgr_morphbtn_subscribe_mc_listid,$name='',$lastname='' );
								
								if($mc_response == 'ok'){
									$hgr_morphbtn_btn_text = 'Succes!';
									$hgr_morphbtn_btn_long_text = 'Please check your email address to confirm your subscribtion!';
								} else {
									$hgr_morphbtn_btn_text = 'Error';
									$hgr_morphbtn_btn_long_text = 'We were unable to subscribe you! Please contact us!';
								}
								
								$output .= '<div class="morph-button morph-button-inflow morph-button-inflow-1 '.$hgr_morphbtn_id.' '.$hgr_morphbtn_extra_class.'" id="'.$hgr_morphbtn_id.'">
								<button type="button" style="'.$hgr_morphbtn_btn_style.'"><span>'.$hgr_morphbtn_btn_text.'</span></button>
								<div class="morph-content">
									<div>
										<div class="content-style-form content-style-form-4">
											<h2 class="morph-clone">'.$hgr_morphbtn_btn_text.'</h2>
											<form>
												<p><label>'.$hgr_morphbtn_btn_text.'</label><span>'.$hgr_morphbtn_btn_long_text.'</span></p>
											</form>
										</div>
									</div>
								</div>
							</div> <!--morph-button -->';
						}
						else {
							$output .= '<div class="morph-button morph-button-inflow morph-button-inflow-1 '.$hgr_morphbtn_id.' '.$hgr_morphbtn_extra_class.'" id="'.$hgr_morphbtn_id.'">
								<button type="button" style="'.$hgr_morphbtn_btn_style.'"><span>'.$hgr_morphbtn_btn_text.'</span></button>
								<div class="morph-content">
									<div>
										<div class="content-style-form content-style-form-4">
											<h2 class="morph-clone">'.$hgr_morphbtn_btn_text.'</h2>
											<form id="hgr_morphbtn_sbscrb_'.$hgr_morphbtn_subscribe_mc_listid.'" action="#" method="get">
												<p><label>'.$hgr_morphbtn_subscribe_label.'</label><input type="text" name="hgr_morph_sbscrb_email_address" id="hgr_morph_sbscrb_email_address"><span>'.$hgr_morphbtn_subscribe_spam.'</span></p>
												<input type="hidden" name="submit">
												<p><button class="sbcrb_form_btn" style="font-size:'.$hgr_morphbtn_subscribe_btn_text_size.'px">'.$hgr_morphbtn_subscribe_btn_text.'</button></p>
											</form>
										</div>
									</div>
								</div>
							</div> <!--morph-button -->';
						}
					break;
				
				
				// SHARE SPECIFIC
				case 'hgr_morphbtn_share':
					wp_enqueue_style('hgr-vc-morphbtn-info-css');					
					
					$output .= '
					<style>
					.'.$hgr_morphbtn_id.', .'.$hgr_morphbtn_id.' .morph-content {
							width: '.$hgr_morphbtn_btn_width.'px;
							height: '.$hgr_morphbtn_btn_height.'px;
							background-color: '.$hgr_morphbtn_share_bgcolor.';
						}
					.'.$hgr_morphbtn_id.' .content-style-social a{
						color: '.$hgr_morphbtn_share_links_color.';
					}
					
					.'.$hgr_morphbtn_id.' .content-style-social a{
						color: '.$hgr_morphbtn_share_links_color.';
					}
					
					.'.$hgr_morphbtn_id.' .content-style-social a:hover {
						color: '.$hgr_morphbtn_share_links_hover_color.';
					}
					
					.'.$hgr_morphbtn_id.' .content-style-social a:hover svg path {
						fill: '.$hgr_morphbtn_share_links_hover_color.';
					}
					</style>
					
					
					<script type="text/javascript">
						jQuery(document).ready(function() {
							new UIMorphingButtonInflow( document.querySelector( ".'.$hgr_morphbtn_id.'" ) );
							
							jQuery(".'.$hgr_morphbtn_id.'").mouseenter(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_hover_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_hover_color.'");
							}).mouseleave(function() {
								jQuery(".'.$hgr_morphbtn_id.' button").css("background-color", "'.$hgr_morphbtn_btn_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("color", "'.$hgr_morphbtn_btn_text_color.'");
								jQuery(".'.$hgr_morphbtn_id.' button").css("border-color", "'.$hgr_morphbtn_btn_border_color.'");
							});
						});
					</script>
					';
					
					$output .= '<div class="morph-button morph-button-inflow morph-button-inflow-2 '.$hgr_morphbtn_id.' '.$hgr_morphbtn_extra_class.'">
							<button type="button" style="'.$hgr_morphbtn_btn_style.' z-index:100"><span>'.$hgr_morphbtn_btn_text.'</span></button>
							<div class="morph-content">
								<div>
									<div class="content-style-social">
										<a class="twitter" data-via="'.$hgr_morphbtn_share_twtr_via.'" data-count="none" target="_blank" href="https://twitter.com/share"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path d="M26.667 0h-21.333c-2.934 0-5.334 2.4-5.334 5.334v21.332c0 2.936 2.4 5.334 5.334 5.334h21.333c2.934 0 5.333-2.398 5.333-5.334v-21.332c0-2.934-2.399-5.334-5.333-5.334zM26.189 10.682c0.010 0.229 0.015 0.46 0.015 0.692 0 7.069-5.288 15.221-14.958 15.221-2.969 0-5.732-0.886-8.059-2.404 0.411 0.050 0.83 0.075 1.254 0.075 2.463 0 4.73-0.855 6.529-2.29-2.3-0.043-4.242-1.59-4.911-3.715 0.321 0.063 0.65 0.096 0.989 0.096 0.479 0 0.944-0.066 1.385-0.188-2.405-0.492-4.217-2.654-4.217-5.245 0-0.023 0-0.045 0-0.067 0.709 0.401 1.519 0.641 2.381 0.669-1.411-0.959-2.339-2.597-2.339-4.453 0-0.98 0.259-1.899 0.712-2.689 2.593 3.237 6.467 5.366 10.836 5.589-0.090-0.392-0.136-0.8-0.136-1.219 0-2.954 2.354-5.349 5.257-5.349 1.512 0 2.879 0.65 3.838 1.689 1.198-0.24 2.323-0.685 3.338-1.298-0.393 1.249-1.226 2.298-2.311 2.96 1.063-0.129 2.077-0.417 3.019-0.842-0.705 1.073-1.596 2.015-2.623 2.769z" fill="'.$hgr_morphbtn_share_links_color.'"></path></svg><span>Share on Twitter</span></a>
										
										<a class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?app_id='.$hgr_morphbtn_share_fbk_appid.'&u='.get_permalink( $post->ID ).'&display=popup&ref=plugin"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path d="M26.667 0h-21.333c-2.933 0-5.334 2.4-5.334 5.334v21.332c0 2.936 2.4 5.334 5.334 5.334l21.333-0c2.934 0 5.333-2.398 5.333-5.334v-21.332c0-2.934-2.399-5.334-5.333-5.334zM27.206 16h-5.206v14h-6v-14h-2.891v-4.58h2.891v-2.975c0-4.042 1.744-6.445 6.496-6.445h5.476v4.955h-4.473c-1.328-0.002-1.492 0.692-1.492 1.985l-0.007 2.48h6l-0.794 4.58z" fill="'.$hgr_morphbtn_share_links_color.'"></path></svg><span>Share on Facebook</span></a>
										<a class="googleplus" target="_blank" href="https://plus.google.com/share?url='.get_permalink( $post->ID ).'"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><path d="M0.025 27.177c-0.008-0.079-0.014-0.158-0.018-0.238 0.004 0.080 0.011 0.159 0.018 0.238zM7.372 17.661c2.875 0.086 4.804-2.897 4.308-6.662-0.497-3.765-3.231-6.787-6.106-6.873-2.876-0.085-4.804 2.796-4.308 6.562 0.496 3.765 3.23 6.887 6.106 6.973zM32 8v-2.666c0-2.934-2.399-5.334-5.333-5.334h-21.333c-2.884 0-5.25 2.32-5.33 5.185 1.824-1.606 4.354-2.947 6.965-2.947 2.791 0 11.164 0 11.164 0l-2.498 2.113h-3.54c2.348 0.9 3.599 3.629 3.599 6.429 0 2.351-1.307 4.374-3.153 5.812-1.801 1.403-2.143 1.991-2.143 3.184 0 1.018 1.93 2.75 2.938 3.462 2.949 2.079 3.904 4.010 3.904 7.233 0 0.513-0.064 1.026-0.19 1.53h9.617c2.934 0 5.333-2.398 5.333-5.334v-16.666h-6v6h-2v-6h-6v-2h6v-6h2v6h6zM5.809 23.936c0.675 0 1.294-0.018 1.936-0.018-0.848-0.823-1.52-1.831-1.52-3.074 0-0.738 0.236-1.448 0.567-2.079-0.337 0.024-0.681 0.031-1.035 0.031-2.324 0-4.297-0.752-5.756-1.995v2.101l0 6.304c1.67-0.793 3.653-1.269 5.809-1.269zM0.107 27.727c-0.035-0.171-0.061-0.344-0.079-0.52 0.018 0.176 0.045 0.349 0.079 0.52zM14.233 29.776c-0.471-1.838-2.139-2.749-4.465-4.361-0.846-0.273-1.778-0.434-2.778-0.444-2.801-0.030-5.41 1.092-6.882 2.762 0.498 2.428 2.657 4.267 5.226 4.267h8.951c0.057-0.348 0.084-0.707 0.084-1.076 0-0.392-0.048-0.775-0.137-1.148z" fill="'.$hgr_morphbtn_share_links_color.'"></path></svg><span>Share on Google+</span></a>
									</div>
								</div>
							</div>
						</div><!-- morph-button -->';
					break;
				
				
				// VIDEO SPECIFIC
				case 'hgr_morphbtn_videoplayer':
					break;
			}
						
			/*
				Return the output
			*/		
			return $output;
		}
	
	
 function do_subscribe($your_apikey,$my_list_unique_id, $name, $surname){
	
	/*
		Validation
	*/
	if(!$_GET['hgr_morph_sbscrb_email_address']){ return "No email address provided"; } 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['hgr_morph_sbscrb_email_address'])) {
		return "Email address is invalid"; 
	}

	/*
		Grab an API Key from http://admin.mailchimp.com/account/api/
	*/
	$api = new MCAPI($your_apikey);
	
	/*
		Grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
		Click the "settings" link for the list - the Unique Id is at the bottom of that page.
	*/ 
	
	$merge_vars = array('FNAME'=>$name, 'LNAME'=>$surname);
	
	/*
		Return the succes or error message
	*/
	if($api->listSubscribe($my_list_unique_id, $_GET['hgr_morph_sbscrb_email_address'], $merge_vars) === true) {
		/*
			It worked!
		*/
		return "ok";
	}else{
		/*
			An error ocurred, return error message	
		*/
		return "ko";
	}
	}
?>