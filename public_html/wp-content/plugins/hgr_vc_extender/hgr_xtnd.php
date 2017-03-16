<?php
/*
	Plugin Name: Highgrade Extender for Visual Composer
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 2.4
	Description: Custom made extender for Visual Composer
	Text Domain: hgr_lang
*/

/*
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_XTND')) {
	
	add_action('admin_init','initiate_hgr_extender');
	function initiate_hgr_extender() {
		/**
		 * Check if Visual Composer is installed and activated
		*/
		$vc_check = hgr_vc_dependency_check();
		if($vc_check) { echo $vc_check; }
	}
	
	
	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.2
	 */
	add_action( 'plugins_loaded', 'hgr_xtnd_load_textdomain' );
	function hgr_xtnd_load_textdomain() {
	  load_plugin_textdomain( 'hgr_lang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
	
	
	
	/**
	 * Function to check if Visual Composer is installed 
	 * and activated and has the minimum required version
	*/
	if(!function_exists('hgr_vc_dependency_check')){
		function hgr_vc_dependency_check() {
			if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
				/*
					Minimum Visual composer version check
				*/
				if( version_compare( '4.7', WPB_VC_VERSION, '>' ) ) {
					/*
						Deactivate the plugin as the conditions are not met
					*/
					if ( is_plugin_active('hgr_vc_extender/hgr_xtnd.php') ) {
						deactivate_plugins( '/hgr_vc_extender/hgr_xtnd.php', true );
					}
					return vc_installed_min_version_notice();
				}
			} else {
				/*
					Deactivate the plugin as the conditions are not met
				*/
				if ( is_plugin_active('hgr_vc_extender/hgr_xtnd.php') ) {
					deactivate_plugins( '/hgr_vc_extender/hgr_xtnd.php', true );
				}
				return vc_installed_min_version_notice();
			}
			return false;
		 }
	}
	
	
	
	
	function vc_installed_min_version_notice() {
		return '<div class="hgr_notice hgr_notice_error"><p><strong>HighGrade Extender is a add-on for Visual Composer plugin</strong>, therefore before activation of HighGrade Extender please install and activate Visual Composer - <strong>minimum version: 4.7</strong></p></div>';
	}
	
	
	
	/**
	 * Install function
	 * @since 1.0.2
	 */
	register_activation_hook( __FILE__, 'hgr_xtnd_install' );
	function hgr_xtnd_install(){
		update_option('hgr_xtnd_version', '2.4' );
	}
	
	
	/**
	 * Custom function SVG icon upload
	 * @since 1.0.3.9
	 */
	function hgr_svg_upload( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'hgr_svg_upload' );


	class HGR_XTND{
		var $elements_dir;
		var $shortcodes_dir;
		var $js_dir;
		var $css_dir;
		var $value;
		
		function __construct(){
			$this->elements_dir		=	plugin_dir_path( __FILE__ ).'elements/';
			$this->shortcodes_dir	=	plugin_dir_path( __FILE__ ).'shortcodes/';
			$this->js_dir			=	plugins_url('includes/js/',__FILE__);
			$this->css_dir			=	plugins_url('includes/css/',__FILE__);
			
			add_action('init',array($this,'hgr_xtnd_init'));
			add_action('admin_enqueue_scripts',array($this,'hgr_xtnd_admin_scripts'));
			add_action('wp_enqueue_scripts',array($this,'hgr_xtnd_front_scripts'));
			
			add_shortcode( 'icon', array($this,'hgr_icons_shortcode') );
			
			/*
				Param type "range"
				To include this param in one element, include the below lines in element construct function
			*/ 
			
			/*if ( function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('range' , array(HGR_XTND, 'make_range_input' ) );
			}*/
			
			
			/*
				Param type "number"
				To include this param in one element, include the below lines in element construct function
			*/ 
			
			/*if ( function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('number' , array(HGR_XTND, 'make_number_input' ) );
			}*/
			
			
			
			/*
				Param type "icon_browser"
				To include this param in one element, include the below lines in element construct function
			*/ 
			/*if(function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('icon_browser', array(HGR_XTND, 'icon_browser') );
			}*/
		}		
		
		
		
		
		
		function hgr_xtnd_init() {
			/* 
				Walk trough the shortcodes and add them to addon
			*/
			foreach(glob($this->shortcodes_dir."/*.php") as $shortcode) {
				require_once($shortcode);
			}
			/* 
				Walk trough the elements and add them to addon
			*/
			foreach(glob($this->elements_dir."/*.php") as $element) {
				require_once($element);
			}
		}
		
		
		
		
		
		/*
			Icon schortcode
		*/
		function hgr_icons_shortcode( $content = null ) {
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract( shortcode_atts( array(
						'name'		=>	'default',
						'color'		=>	'',
						'size'		=>	'',
						'height'	=>	'',
					), $content ) );
			
			if( !empty($color) ) {
				$addColor=' color:' . $color . '; ';
			}
			
			$addColor	=	( !empty($color) ? ' color:' . $color . '; ' : '' );
			$addSize	=	( !empty($size) ? ' font-size:' . $size . '!important; ' : '' );
			$addHeight	=	( !empty($height) ? ' line-height:' . $height . '!important; ' : '' );
			
			/*
				Output return
			*/
			return '<i class="icon ' . $name . '" style="'. $addColor . $addSize . $addHeight.'"></i>';
		}
		
		
				
		
		
		/*
			Generate range input fild
			Note: type="range" is not supported in Internet Explorer 9 and earlier versions.
			Visual Composer docs: http://kb.wpbakery.com/index.php?title=Visual_Composer_Tutorial_Create_New_Param
		*/ 
		public static function make_range_input($settings, $value){
			
			// Calculate dependencies
			if( function_exists('vc_generate_dependencies_attributes') ) {
				$dependency = vc_generate_dependencies_attributes($settings);
			} else { 
				$dependency = '';
			}
			
			if( isset($settings['param_name']) ){
				$param_name = $settings['param_name'];
			} else {
				$param_name = '';
			}
			
			if( isset($settings['type']) ){
				$type = $settings['type'];
			} else {
				$type = '';
			}
			
			if( isset($settings['min']) ){
				$min = $settings['min'];
			} else {
				$min = '0';
			}
			
			if( isset($settings['max']) ){
				$max = $settings['max'];
			} else {
				$max = '999999';
			}
			
			if( isset($settings['prefix']) ){
				$prefix = $settings['prefix'];
			} else {
				$prefix = 'pixels';
			}
			
			if( isset($settings['class']) ){
				$class = $settings['class'];
			} else {
				$class = '';
			}
			
			/*
				All vars are ok, build the output
			*/
			$output = '<span class="hgr_selected_value">Current value: <span class="selectedNewValue">'.$value.'</span> '.$prefix.'</span><br> '.$min.'<input type="'.$type.'" min="'.$min.'" max="'.$max.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" style="max-width:100px; margin-right: 10px;" ' . $dependency . ' />'.$max;
			
			/*
				Output return
			*/
			return $output;
		}
		
		
		
		
		/*
			Generate number input fild
			Note: type="number" is not supported in Internet Explorer 9 and earlier versions.
			Visual Composer docs: http://kb.wpbakery.com/index.php?title=Visual_Composer_Tutorial_Create_New_Param
		*/ 
		public static function make_number_input($settings, $value){
			// Calculate dependencies
			if( function_exists('vc_generate_dependencies_attributes') ) {
				$dependency = vc_generate_dependencies_attributes($settings);
			} else { 
				$dependency = '';
			}
			
			if( isset($settings['param_name']) ){
				$param_name = $settings['param_name'];
			} else {
				$param_name = '';
			}
			
			if( isset($settings['type']) ){
				$type = $settings['type'];
			} else {
				$type = '';
			}
			
			if( isset($settings['min']) ){
				$min = $settings['min'];
			} else {
				$min = '0';
			}
			
			if( isset($settings['max']) ){
				$max = $settings['max'];
			} else {
				$max = '999999';
			}
			
			if( isset($settings['suffix']) ){
				$suffix = $settings['suffix'];
			} else {
				$suffix = '';
			}
			
			if( isset($settings['class']) ){
				$class = $settings['class'];
			} else {
				$class = '';
			}
			
			/*
				All vars are ok, build the output
			*/
			$output = '<input type="number" min="'.$min.'" max="'.$max.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" style="max-width:100px; margin-right: 10px;" />'.$suffix;
			
			/*
				Output return
			*/
			return $output;
		}
		
		
		
		
		
		
		/*
			Time elapsed function
		*/
		public function hgr_xtnd_tes($datetime, $full = false) {
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);
		
			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;
		
			$string = array(
				'y' => esc_html__('year','hgr_lang'),
				'm' => esc_html__('month','hgr_lang'),
				'w' => esc_html__('week','hgr_lang'),
				'd' => esc_html__('day','hgr_lang'),
				'h' => esc_html__('hour','hgr_lang'),
				'i' => esc_html__('minute','hgr_lang'),
				's' => esc_html__('second','hgr_lang'),
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}
		
			if (!$full) $string = array_slice($string, 0, 1);
			/*
				Output return
			*/
			return $string ? '<abbr title="'.$datetime.'">'.implode(', ', $string) . esc_html__(' ago ','hgr_lang') . '</abbr>' : esc_html__(' just now ','hgr_lang');
		}
		
		
		
		
		
		public function make_links_clickable($text, $color){
			return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank" style="color:'.$color.';">$1</a>', $text);
		}
		
		
		
		/*
			Custom function for getting post content
		*/
		public function hgr_xtnd_getPostContent() {
			global $more; $more = 0;
        	$content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content('[...]')));
			/*
				Output return
			*/
        	return $content;
		}
		
		
		
		
		
		
		/*
			Custom function for getting post excerpt
		*/
		public function hgr_xtnd_getPostExcerpt() {
			$content = apply_filters('the_excerpt', get_the_excerpt());
			/*
				Output return
			*/
			return $content;
		}
		
		
		
		
		
		
		/*
			Icon Browser function
		*/
		public static function icon_browser($settings, $value=null) {
			
			// Visual Composer function to get dependencies
			$dependency = ( function_exists('vc_generate_dependencies_attributes') ? vc_generate_dependencies_attributes($settings) : '' );
			
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			
			$output = '<div class="hgr_param_'.$param_name.'">'
					 .'<input name="'.$param_name.'"
					  class="wpb_vc_param_value wpb-textinput '.$param_name.' 
					  '.$type.'_field" type="hidden" 
					  value="'.$value.'" ' . $dependency . '/>'
					 .'</div>';
			$output .= '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".iconpreview").html("<i class=\''.$value.'\'></i> <span>'.$value.'</span>");
					jQuery("div.listyle[data-icon=\''.$value.'\']").addClass("selected");
				});
				
				jQuery(".icons-display-screen div.listyle").click(function() {
					  jQuery(this).addClass("selected").siblings().removeClass("selected");
                    var icon = jQuery(this).attr("data-icon");
                    jQuery("input[name=\''.$param_name.'\']").val(icon);
                    jQuery(".iconpreview").html("<i class=\'"+icon+"\'></i> <span>"+icon+"</span>");
                });
				
				jQuery(".filterSets").on("change", function() {
                    var selectedSet = jQuery(this).find(":selected").val();
					  if(selectedSet == "showAllSets") {
						  jQuery("div.icons-display-screen").fadeIn();
					  } else {
					  	jQuery("div.icons-display-screen").fadeOut();
                    	jQuery("#"+selectedSet).fadeIn();
					  }
                });
				</script>';
			
			
			
			/*
				Include icons list
			*/
			@include(plugin_dir_path( __FILE__ ).'includes/fonts/icons.php');
			
			$output .= '<p><div class="iconpreview"><i class=""></i></div><input class="searchicon" type="text" placeholder="Search for the perfect icon..." />';
			
			$output .='<select class="filterSets"><option value="showAllSets">Show all icons sets</option>';
			foreach($icons_set as $icon_set => $icons) {
				switch($icon_set){
					case 'fa': $fontSetName = 'FontAwesome';
					break;
					case 'outline': $fontSetName = 'Outline';
					break;
					default: $fontSetName = $icon_set;
				}
				$output .='<option value="iconslist_'.$icon_set.'">'.$fontSetName.'</option>';
			}
			$output .='</select>';
			
			$output .='</p>';
			
			$output .= '<div id="hgr_xtnd_iconsearch">';
				foreach($icons_set as $icon_set => $icons) {
					$output .= '<div class="icons-display-screen" id="iconslist_'.$icon_set.'">';
						foreach($icons as $icon => $icondata){
							$output .= '<div class="listyle" title="'.$icon.'" data-icon="'.$icondata['class'].' '.$icon.'" data-icon-tag="'.$icondata['tags'].'">';
							$output .= '<i class="'.$icondata['class'].' '.$icon.'"></i></div>';
						}
					$output .='</div>';
				}

			$output .= '<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery(".searchicon").keyup(function(){
							// Get the input field text
							var searchVal = jQuery(this).val();
							// Loop through the icon list
							jQuery(".icons-display-screen .listyle").each(function(){
								// If the list item does not contain the text phrase fade it out
								if (jQuery(this).attr("data-icon-tag").search(new RegExp(searchVal, "i")) < 0) {
									jQuery(this).fadeOut();
								} else {
									jQuery("div.icons-display-screen").fadeIn();
									jQuery(this).show();
								}
							});
						});
					});
			</script>';
			$output .= '</div>';
			
			/*
				Output return
			*/
			return $output;
		}
		
		
		/*
			Register necessary js and css files on frontend
		*/
		function hgr_xtnd_front_scripts(){
			wp_register_script('hgr-vc-countto',$this->js_dir.'countto.js', array('jquery'));
			wp_register_script('hgr-vc-jquery-appear',$this->js_dir.'jquery.appear.js', array('jquery'));
			wp_register_script('hgr-vc-jquery-easing',$this->js_dir.'jquery.easing.min.js', array('jquery'));
			wp_register_script('hgr-vc-jquery-easypiechart',$this->js_dir.'jquery.easypiechart.min.js', array('jquery'));
			wp_register_script('hgr-vc-blogposts',$this->js_dir.'hgrblogposts.js',array('jquery'));
			wp_register_script('hgr-vc-carouFredSel',$this->js_dir.'jquery.carouFredSel-6.2.1.js',array('jquery'));
			wp_register_script('hgr-vc-tooltip',$this->js_dir.'tooltip.js',array('jquery'));
			wp_register_script('hgr-vc-mousewheel',$this->js_dir.'jquery.mousewheel.min.js',array('jquery'));
			wp_register_script('hgr-vc-touchSwipe',$this->js_dir.'jquery.touchSwipe.min.js',array('jquery'));
			wp_register_script('hgr-vc-transit',$this->js_dir.'jquery.transit.min.js',array('jquery'));
			wp_register_script('hgr-vc-throttle-debounce',$this->js_dir.'jquery.ba-throttle-debounce.min.js',array('jquery'));
			wp_register_script('hgr-vc-modernizr',$this->js_dir.'modernizr.custom.js',array('jquery'));
			// HGR Progress bar
			wp_register_script('hgr-vc-progressbar',$this->js_dir.'hgr_progressbar.js',array('jquery'));
			// HGR TweetFeed
			wp_register_script('hgr-vc-tweetfeed',$this->js_dir.'hgr_tweetfeed.js',array('jquery'));
			// Plugin js
			wp_register_script('hgr-vc-app',$this->js_dir.'hgrvcapp.js',array('jquery'));
			// HGR LogoCarousel
			wp_register_script('hgr-vc-logocarousel',$this->js_dir.'owl.carousel.min.js',array('jquery'));
			// HGR Mouse Hover Direction
			wp_register_script('hgr-vc-hoverdir',$this->js_dir.'jquery.hoverdir.js',array('jquery'));
			wp_register_script('hgr-advimage',$this->js_dir.'hgr-advimage.js',array('jquery'));
			// HGR Minimal Form
			wp_register_script('hgr-vc-classie',$this->js_dir.'classie.js');
			wp_register_script('hgr-vc-stepsform',$this->js_dir.'stepsForm.js');
			// enqueue css files on frontend
			wp_enqueue_style('hgr-vc-fa-icons',$this->css_dir.'font-awesome.min.css');
			wp_enqueue_style('hgr-vc-outline-icons',$this->css_dir.'outline.min.css');
			// enqueue global css file for elements on frontend
			wp_register_style('hgr-vc-extender-style',$this->css_dir.'hgr-vc-extender-elements.min.css');
			wp_enqueue_style('hgr-vc-extender-style');
			// Morph Button
			wp_register_style('hgr-vc-morphbtn-general-css',$this->css_dir.'hgr_morphbtn_general.css');
			wp_register_style('hgr-vc-morphbtn-info-css',$this->css_dir.'hgr_morphbtn_info.css');
			//HGR CountDown
			wp_register_script('hgr-countdown_plugin',$this->js_dir.'countdown/jquery.plugin.min.js',array('jquery'));
			wp_register_script('hgr-countdown',$this->js_dir.'countdown/jquery.countdown.js',array('hgr-countdown_plugin'));
		}
		
		
		/*
			Register necessary js and css files on back-end
		*/
		function hgr_xtnd_admin_scripts(){
			wp_enqueue_style('hgr-xtnd-backend',$this->css_dir.'hgr_xtnd_backend.min.css');
			wp_enqueue_style('hgr-vc-fa-icons',$this->css_dir.'font-awesome.min.css');
			wp_enqueue_style('hgr-vc-outline-icons',$this->css_dir.'outline.min.css');
			wp_enqueue_script('media-upload');
			wp_enqueue_media();
		}
	}
	/*
		All good, fire up the plugin :)
	*/
	new HGR_XTND;
}