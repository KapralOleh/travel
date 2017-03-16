<?php
/*
	Shortcode: Team element
	Based on Bootstrap
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_team', 'hgr_team');
function hgr_team($atts, $content = null ) {
			
			/*
				Include required scripts
			*/
			wp_enqueue_script('hgr-vc-jquery-appear');
			
			/*
				Empty vars declaration
			*/
			$output = $team_nav_color = $team_nav_min_height = $team_nav_min_height = $hgr_team_contained = $extra_class = '';
			$navs=array();
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'team_nav_color'		=>	'#e2e1dc',
				'team_dominant_color'	=>	'#80c8ac', 
				'team_nav_min_height'	=>	'80',
				'hgr_team_iconsize'	=>	'24',
				'hgr_team_contained'	=>	'',
				'extra_class'			=>	''
			), $atts));
			
			$GLOBALS['hgr_team_tdc'] = $team_dominant_color;
			$GLOBALS['hgr_team_iconsize'] = $hgr_team_iconsize;
			
			/*
				Tab navigation
			*/
			preg_match_all( '/hgr_team_member member_name="([^\"]+)" member_position="([^\"]+)"{0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
			$tab_titles = array();
			if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
			$tabs_nav = '';
			$tabs_nav .= '<ul class="nav nav-tabs" id="teamTab">';
			
			foreach ( $tab_titles as $tab ) {
				preg_match('/hgr_team_member member_name="([^\"]+)" member_position="([^\"]+)"{0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
				if(isset($tab_matches[1][0])) {
					$tabs_nav .= '<li><a href="#tab-'. (isset($tab_matches[3][0]) ? strtolower(str_replace(' ','',$tab_matches[3][0])) : strtolower(str_replace(' ','', $tab_matches[1][0] )) ) .'" data-toggle="tab">' . $tab_matches[1][0] . '</a> <small>' . $tab_matches[2][0] . '</small></li>';
				}
			}
			$tabs_nav .= '</ul>'."\n";
			
			
			$output .= '<div class="hgr_team_wrap '.(!empty($extra_class) ? $extra_class : '').'">';
				$output .= '<div class="'.($hgr_team_contained == 'yes' ? 'container': '').' hgr_team_members tab-content">';
						$output .= do_shortcode($content);
				$output .= '</div>';
					$output .='<div class="team_nav" style="background-color:'.$team_nav_color.'; min-height:'.$team_nav_min_height.'px;">';
					if($hgr_team_contained == 'yes'){ $output .='<div class="container">'; }
							$output .= $tabs_nav;
					if($hgr_team_contained == 'yes'){ $output .='</div>'; }
					$output .='</div>';
			$output .= '</div>';
			
			$output .='<script type="text/javascript">
						jQuery(document).ready(function() {
							
							// Tabs navigation next prev
							var $tabs = jQuery("#teamTab li");
							jQuery(".team_left").on("click", function() {
								$tabs.filter(".active").prev("li").find("a[data-toggle=\"tab\"]").tab("show");
							});
							jQuery(".team_right").on("click", function() {
								$tabs.filter(".active").next("li").find("a[data-toggle=\"tab\"]").tab("show");
							});	
							
							// reset bars before tab shown
							jQuery("#teamTab a[data-toggle=\"tab\"]").on("show.bs.tab", function (e) {
							  jQuery(e.target).each(function() {
								 jQuery(".skillfill").each(function() {
									var fill = jQuery(this).attr("data-value");
									jQuery(this).animate({
										"width": "0%"
									}, 1, function() {
									});
									jQuery(this).css("overflow","visible");
									jQuery(this).css("background-color","'.$team_dominant_color.'");
								});
							  });
							});
							
							// on tab shown, animate the bars
							jQuery("#teamTab a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
							  jQuery(e.target).each(function() {
								 jQuery(".skillfill").each(function() {
									var fill = jQuery(this).attr("data-value");					
									jQuery(this).animate({
										width: fill+"%"
									}, { duration: 1500, queue: false });
								});
							  });
							});
							
							if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
								jQuery("#teamTab a:first").tab("show");
								jQuery(".hgr_team_members div:first").addClass("in").addClass("active");
								jQuery(".hgr_team_members div:first").addClass("in").addClass("active");
								
								jQuery(".skillfill").each(function() {
									var fill = jQuery(this).attr("data-value");					
									jQuery(this).animate({
										width: fill+"%"
									}, { duration: 1500, queue: false });
								});
								
							} else {			
								jQuery("#teamTab a:first").appear(function() {
									jQuery(this).tab("show");
									jQuery(".hgr_team_members div:first").addClass("in").addClass("active");
									jQuery(".hgr_team_members div:first").addClass("in").addClass("active");
								});
							}

						});
						</script>';
			/*
				Return the output
			*/
			return $output;
		}
		
add_shortcode( 'hgr_team_member', 'hgr_team_member');
function hgr_team_member($atts,$content = null) {
			
			
			/*
				Empty vars declaration
			*/
			$output = $hgr_tm_img_style = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'member_name'			=>	'',
				'member_position'		=>	'',
				'member_image'			=>	'',
				'image_style'			=>	'',
				'member_skills'		=>	'',
				'member_dribbble'		=>	'',
				'member_twitter'		=>	'',
				'member_facebook'		=>	'',
				'member_skype'			=>	'',
				'member_linkedin'		=>	'',
				'member_vimeo'			=>	'',
				'member_yahoo'			=>	'',
				'member_youtube'		=>	'',
				'member_picasa'		=>	'',
				'member_deviantart'	=>	'',
				'member_pinterest'		=>	'',
				'member_soundcloud'	=>	'',
				'member_behance'		=>	'',
				'member_instagram'		=>	'',
				'member_googleplus'	=>	'',
			), $atts));
			
			/*
				Team member image
			*/
			$member_image_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $member_image, 'thumb_size' => 'full', 'class' => "" ) );

			$output .= '<div class="hgr_team_member tab-pane fade " id="tab-'.strtolower(str_replace(' ','',$member_name)).'">';
			
				switch($image_style){
					case 'img-full':
						$hgr_tm_img_style .='team_member_image';
					break;
					
					case 'img-rounded':
						$hgr_tm_img_style .='team_member_image_rounded';
					break;
					
					case 'img-circle':
						$hgr_tm_img_style .='team_member_image_circle';
					break;
				}
				$output .= '<div class="vc_col-sm-3 wpb_column column_container '.$hgr_tm_img_style.'">';				
				$output .= $member_image_array['thumbnail'];
				$output .= '</div>';
				$output .= '<div class="vc_col-sm-1 wpb_column column_container">&nbsp;</div>';
				$output .= '<div class="vc_col-sm-8 wpb_column column_container">';
					$output .= '<div class="team_nav_small"><div class="team_btn team_left" style="background-color: '.$GLOBALS["hgr_team_tdc"].';"><i class="icon fa fa-angle-left"></i></div> <div class="team_btn team_right" style="background: '.$GLOBALS["hgr_team_tdc"].'"><i class="icon fa fa-angle-right"></i></div> </div><div class="clearfix"></div>';
					$output .= '<h3>'.$member_name.'</h3>';
					$output .= '<small>'.$member_position.'</small>';
				$output .= '<div class="team_member_socials">';
					if($member_dribbble) { $output .= '<a href="'.$member_dribbble.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-dribbble" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_twitter) {$output .= '<a href="'.$member_twitter.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-twitter" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_facebook) {$output .= '<a href="'.$member_facebook.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-facebook" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_skype) {$output .= '<a href="'.$member_skype.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-skype" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_linkedin) {$output .= '<a href="'.$member_linkedin.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-linkedin" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_vimeo) {$output .= '<a href="'.$member_vimeo.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-vimeo" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_yahoo) {$output .= '<a href="'.$member_yahoo.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-yahoo" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_youtube) {$output .= '<a href="'.$member_youtube.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-youtube" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_picasa) {$output .= '<a href="'.$member_picasa.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-picasa" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_deviantart) {$output .= '<a href="'.$member_deviantart.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-deviantart" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_pinterest) {$output .= '<a href="'.$member_pinterest.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-pinterest" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_soundcloud) {$output .= '<a href="'.$member_soundcloud.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-soundcloud" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_behance) {$output .= '<a href="'.$member_behance.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-behance" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_instagram) {$output .= '<a href="'.$member_instagram.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-instagram" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
					if($member_googleplus) {$output .= '<a href="'.$member_googleplus.'" style="color: '.$GLOBALS["hgr_team_tdc"].'" target="_blank"><i class="icon social-google-plus" style="font-size:'.$GLOBALS['hgr_team_iconsize'].'px!important;"></i></a>';}
				$output .='</div>';
				$output .= wpb_js_remove_wpautop($content, true);
					if(!empty($member_skills)) {
						$output .= '<div class="skills_pack">';
							$each_skill = explode('|',$member_skills);
							foreach($each_skill as $skill) {
								$output .= '<div class="hgr_skill">';
									$skill_parts = explode(',', $skill, 2);
									// output each skill
									$output .= '<h4>'.strtoupper($skill_parts[0]).'</h4>';
									$output .='';
									$output .= '<div class="hgr_skillfull"><span class="skillfill " data-value="'.$skill_parts[1].'"><span class="valuemarker">'.$skill_parts[1].'%</span></span></div>';
								$output .= '</div>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '<div class="clearfix"></div></div>';
			
			/*
				Return the output
			*/
			return $output;
		}
		
if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_hgr_team extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_hgr_team_member extends WPBakeryShortCode {}
}
?>