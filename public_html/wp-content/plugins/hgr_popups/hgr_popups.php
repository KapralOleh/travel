<?php
/*
	Plugin Name: Highgrade Add-Ons: Popups
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 1.0.0
	Description: Part of HighGrade Add-Ons for HighGrade themes. It requires Visual Composer min version 4.8
	Text Domain: hgr_lang
*/

/*
	Based on http://lab.veno.it/venobox/
	Version 1.5
*/

/*
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_POPUPS')) {
	
	/*
	* Any dependency, version, updates check?
	*/ 
	add_action('admin_init','initiate_hgr_popups');
	function initiate_hgr_popups() {
		hgr_vc_dependency_check();
	}
	
	
	/**
	 * Function to display admin notices
	*/
	add_action('admin_notices', 'hgr_admin_notices');
	if( !function_exists('hgr_admin_notices') ) {
		function hgr_admin_notices() {
		  if ($notices= get_option('hgr_admin_notices')) {
			foreach ($notices as $notice) {
			  echo "<div class='updated notice is-dismissible'><p>$notice</p></div>";
			}
			delete_option('hgr_admin_notices');
		  }
		}
	}
	
	
	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	add_action( 'plugins_loaded', 'hgr_popups_load_textdomain' );
	function hgr_popups_load_textdomain() {
	  load_plugin_textdomain( 'hgr_lang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
	
	
	/**
	 * Function to check if theme is installed and activated
	*/
	if( !function_exists('hgr_theme_dependency_check') ) {
		function hgr_theme_dependency_check() {
			$theme = wp_get_theme(); // gets the current theme
			if ('Hatch' == $theme->name || 'Hatch' == $theme->parent_theme) {
				// if you're here Sage is the active theme or is
				// the current theme's parent theme
				return true;
			}
			return false;
		 }
	}
	
	
	
	/**
	 * Function to check if Visual Composer is installed 
	 * and activated and has the minimum required version
	*/
	if( !function_exists('hgr_vc_dependency_check') ) {
		function hgr_vc_dependency_check() {
			if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
				/*
					Minimum Visual composer version check
				*/
				if( version_compare( '4.8', WPB_VC_VERSION, '>' ) ) {
					/*
						Deactivate the plugin as the conditions are not met
					*/
					if ( is_plugin_active('hgr_popups/hgr_popups.php') ) {
						deactivate_plugins( '/hgr_popups/hgr_popups.php', true );
					}
					/**
					 * Get notices array and update them
					*/
					delete_option('hgr_admin_notices');
					$notices	=	get_option( 'hgr_admin_notices', array() );
					$notices[]	=	__( "Highgrade Popups Add-On is part of HighGrade Add-Ons Pack and it requires Visual Composer minimum version 4.8. Please install and activate Visual Composer 4.8 first.", "hgr_lang");
					update_option('hgr_admin_notices', $notices);
					return false;
				}
			} else {
				/*
					Deactivate the plugin as the conditions are not met
				*/
				if ( is_plugin_active('hgr_popups/hgr_popups.php') ) {
					deactivate_plugins( '/hgr_popups/hgr_popups.php', true );
				}
				/**
				 * Get notices array and update them
				*/
				delete_option('hgr_admin_notices');
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$notices[]	=	__( "Highgrade Popups Add-On is part of HighGrade Add-Ons Pack and it requires Visual Composer minimum version 4.8. Please install and activate Visual Composer 4.8 first.", "hgr_lang");
				update_option('hgr_admin_notices', $notices);
				return false;
			}
			return false;
		 }
	}
		
	
	class HGR_POPUPS {
		
		var $js_dir;
		var $css_dir;
		
		public function __construct(){	
			
			$this->js_dir			=	plugins_url('js/',__FILE__);
			$this->css_dir			=	plugins_url('css/',__FILE__);
			
			/**
			 * Mobile devices detection library
			 */
			@require_once get_template_directory() . '/highgrade/Mobile_Detect.php';
			
			register_activation_hook( __FILE__, array($this, 'hgr_install' ));
			
			add_action('wp_enqueue_scripts',array($this,'hgr_front_scripts'));
			
			add_action('init',array($this,'hgr_post_type'));
			
			// Init & save metaboxex for pages, posts, etc
			add_action( 'add_meta_boxes', array($this,'hgr_popups_metaboxes') );
			add_action( 'save_post', array($this,'hgr_save_popup_data') );
			
			// Init & save metaboxex for hgr_popup post type
			add_action( 'add_meta_boxes', array($this,'hgr_popups_posttype_metaboxes') );
			add_action( 'save_post', array($this,'hgr_save_popup_posttype_data') );
			
			
			// Hook FS Search into footer, only if NOT MOBILE
			//if( class_exists('Mobile_Detect') ){
			//	$detect = new Mobile_Detect;
			//	if( !$detect->isMobile() && !$detect->isTablet() ){
					add_action('wp_footer', array($this,'do_popup') );
			//	}
			//}
		}
		
		/**
		* Install function
		* @since 1.0.0
		*/
		public function hgr_install() {
				update_option('hgr_popups_version', '1.0.0' );
				/**
				 * Get notices array and update them
				*/
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$theme = wp_get_theme();
				/**
				 * Check if theme is installed and activated
				*/
				if( !hgr_theme_dependency_check() ) {
					$notices[]	=	__("Highgrade Popups AddOn is part of HighGrade AddOns Pack and its only available with ".$theme->name." theme. You are not allowed to use this pack of parts of it outside ".$theme->name." theme.", "hgr_lang");
				} else {
					
					$notices[]	=	__("Highgrade Popups AddOn its activated now! Thank you for using <b>".$theme->name."</b> theme.", "hgr_lang");
				}
				update_option('hgr_admin_notices', $notices);
			}
		
		/**
		* Create post type hgr_popup function
		* @since 1.0.0
		*/
		function hgr_post_type() {
			register_post_type( 'hgr_popup',
				array(
					'labels' => array(
						'name'               => esc_html__( 'Popup', 'hgr_lang' ),
						'singular_name'      => esc_html__( 'Popup', 'hgr_lang' ),
						'menu_name'          => esc_html__( 'Popups', 'hgr_lang' ),
						'name_admin_bar'     => esc_html__( 'Popup', 'hgr_lang' ),
						'add_new'            => esc_html__( 'Add New', 'info bar', 'hgr_lang' ),
						'add_new_item'       => esc_html__( 'Add New Popup', 'hgr_lang' ),
						'new_item'           => esc_html__( 'New Popup', 'hgr_lang' ),
						'edit_item'          => esc_html__( 'Edit Popup', 'hgr_lang' ),
						'view_item'          => esc_html__( 'View Popup', 'hgr_lang' ),
						'all_items'          => esc_html__( 'All Popups', 'hgr_lang' ),
						'search_items'       => esc_html__( 'Search Popup', 'hgr_lang' ),
						'not_found'          => esc_html__( 'No slide Popup found.', 'hgr_lang' ),
						'not_found_in_trash' => esc_html__( 'No slide Popup found in Trash.', 'hgr_lang' ),
					),
				'public'			=>	true,
				'menu_icon'		=>	'dashicons-welcome-view-site',
				'has_archive'	=>	true,
				'rewrite'		=>	array('slug' => 'hgr_popup'),
				'supports'		=>	array('title', 'editor', 'thumbnail'),
				)
			);
		}
		
		
		/**
		* Add hgr_popup metaboxes function for posts, pages, etc
		* @since 1.0.0
		* Doc: https://codex.wordpress.org/Function_Reference/add_meta_box
		*/	
		function hgr_popups_metaboxes() {
			$screens = array( 'post','page' ); // Available in all kind of posts types
			foreach ( $screens as $screen ) {
				add_meta_box(
					'hgr_popupmetaboxid',					// $id
					__( 'Popup Settings', 'hgr_lang' ),		// $title
					array($this,'hgr_popup_custom_box'),		// $callback
					$screen,								// $screen
					'side',									// $context
					'default'								// $priority
				);
			}
		}
		function hgr_popup_custom_box( $post ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'hgr_popup_custom_box', 'hgr_popup_custom_box_nonce' );
	
			// Get metaboxes values from database
			$hgr_popup_id	=	get_post_meta( $post->ID, '_hgr_popup_id', true );	// Popup unique ID
						
			// Construct the metaboxes and print out
			
			// What Popup to be displayed on this page?
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_id" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Show this Popup", 'hgr_lang' );
			echo '</label> ';
				echo '<select name="hgr_popup_id" id="hgr_popup_id">';
				
				$args = array(
					'post_type'		=>	'hgr_popup',
					'posts_per_page'=>	'99'
				 );
				 
				$hgr_query = new WP_Query($args);
				$allPanels = '';
				
				if( $hgr_query->have_posts() ) {
					echo '<option value="" '.(empty($hgr_popup_id) ? 'selected = "selected"' : '').'>No Popup</option>';
					while ( $hgr_query->have_posts() ) {
						$hgr_query->the_post();
						echo '<option value="'.get_the_ID().'" '.($hgr_popup_id == get_the_ID() ? 'selected = "selected"' : '').'>'.get_the_title().'</option>';
					}
				} else {
					echo '<option value="" selected="selected">No Popup Available</option>';
				}
			echo '</select></div>';
		}
		function hgr_save_popup_data( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['hgr_popup_custom_box_nonce'] ) ) {
				return $post_id;
			}
	
			$nonce = $_POST['hgr_popup_custom_box_nonce'];
	
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'hgr_popup_custom_box' ) ) {
				return $post_id;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			// Check the user's permissions.
			if ( 'hgr_popup' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}
			
			// OK to save data
			// Sanitize user input
			$hgr_popup_id			= sanitize_text_field( $_POST['hgr_popup_id'] );	
			
			// Update the meta field in the database
			update_post_meta( $post_id, '_hgr_popup_id',	 $hgr_popup_id );
		}
		
		
		/**
		* Add hgr_popup metaboxes function for popups
		* @since 1.0.0
		* Doc: https://codex.wordpress.org/Function_Reference/add_meta_box
		*/	
		function hgr_popups_posttype_metaboxes() {
				add_meta_box(
					'hgr_popupmetaboxid',							// $id
					__( 'Popup Settings', 'hgr_lang' ),				// $title
					array($this,'hgr_popup_posttype_custom_box'),	// $callback
					'hgr_popup',									// $screen
					'side',											// $context
					'default'										// $priority
				);
		}
		function hgr_popup_posttype_custom_box( $post ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'hgr_popup_posttype_custom_box', 'hgr_popup_posttype_custom_box_nonce' );
			
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_style('wp-color-picker');
		
			echo '<script type="text/javascript">
			jQuery(document).ready(function($) {   
				$("#hgr_popup_bgcolor, #hgr_popup_overlay_color").wpColorPicker();
			});             
			</script>';
	
			// Get metaboxes values from database
			//$hgr_popup_data_type	=	get_post_meta( $post->ID, '_hgr_popup_data_type', true );		// Available values: iframe inline ajax youtube vimeo
			$hgr_popup_width		=	get_post_meta( $post->ID, '_hgr_popup_width', true );			// You can set a static window width, otherwise the plugin will keep the responsive size settings of .venoframe class
			$hgr_popup_height		=	get_post_meta( $post->ID, '_hgr_popup_height', true );			// You can set a static window height, otherwise the plugin will keep the responsive size settings of .venoframe class
			$hgr_popup_border_width	=	get_post_meta( $post->ID, '_hgr_popup_border_width', true );		// Border thickness of the popup window in pixel - default: '0px'
			$hgr_popup_bgcolor		=	get_post_meta( $post->ID, '_hgr_popup_bgcolor', true );			// Background color of popup window (also affects border color, if has a border) - default: '#ffffff'
			$hgr_popup_overlay_color=	get_post_meta( $post->ID, '_hgr_popup_overlay_color', true );	// Background color of popup overlay (modal)
			$hgr_popup_seconds		=	get_post_meta( $post->ID, '_hgr_popup_seconds', true );			// If above is seconds, how many seconds?! 
						
			// Construct the metaboxes and print out
			
			// Popup show after...
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_seconds" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup Show After", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_popup_seconds" name="hgr_popup_seconds" value="' . esc_attr( $hgr_popup_seconds ) . '" style="width:90%;" placeholder="How many seconds?" /><br>';
			_e( "Number of seconds until popup appears", 'hgr_lang' );
			echo '</div> ';
			
			
			// Popup width
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_width" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup Width", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_popup_width" name="hgr_popup_width" value="' . esc_attr( $hgr_popup_width ) . '" size="25" placeholder="400 OR empty" /><br>';
			_e( "You can set a static window width, otherwise the plugin will keep the responsive size settings and autosize.", 'hgr_lang' );
			echo '</div>';
			
			
			// Popup height
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_height" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup Height", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_popup_height" name="hgr_popup_height" value="' . esc_attr( $hgr_popup_height ) . '" size="25" placeholder="400 OR Empty" /><br>';
			_e( "You can set a static window height, otherwise the plugin will keep the responsive size settings and autosize.", 'hgr_lang' );
			echo '</div>';
			
			// Popup Border Width
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_border_width" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup Border Width", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_popup_border_width" name="hgr_popup_border_width" value="' . esc_attr( $hgr_popup_border_width ) . '" size="25" placeholder="4 OR Empty" /><br>';
			_e( "Border thickness of the popup window in pixels - default: 0", 'hgr_lang' );
			echo '</div>';
			
			// Popup BG Color
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_bgcolor" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup BG Color", 'hgr_lang' );
			echo '</label> ';
			echo '<input name="hgr_popup_bgcolor" type="text" id="hgr_popup_bgcolor" value="' . esc_attr( $hgr_popup_bgcolor ) . '" data-default-color="#ffffff"><br>';
			_e( "Background color of popup window (also affects border color, if has a border) - default: #ffffff", 'hgr_lang' );
			echo '</div>';
			
			// Popup Overlay BG Color
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_popup_overlay_color" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Popup Overlay BG Color", 'hgr_lang' );
			echo '</label> ';
			echo '<input name="hgr_popup_overlay_color" type="text" id="hgr_popup_overlay_color" value="' . esc_attr( $hgr_popup_overlay_color ) . '" data-default-color="#000000"><br>';
			_e( "Background color of popup overlay (modal) - default: #000000", 'hgr_lang' );
			echo '</div>';				
		}
		function hgr_save_popup_posttype_data( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['hgr_popup_posttype_custom_box_nonce'] ) ) {
				return $post_id;
			}
	
			$nonce = $_POST['hgr_popup_posttype_custom_box_nonce'];
	
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'hgr_popup_posttype_custom_box' ) ) {
				return $post_id;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			// Check the user's permissions.
			/*if ( 'hgr_testimonials' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}*/
			
			// OK to save data
			// Sanitize user input
			//$hgr_popup_data_type		= sanitize_text_field( $_POST['hgr_popup_data_type'] );		// Available values: iframe inline ajax youtube vimeo
			$hgr_popup_width			= sanitize_text_field( $_POST['hgr_popup_width'] );			// You can set a static window width, otherwise the plugin will keep the responsive size settings of .venoframe class
			$hgr_popup_height			= sanitize_text_field( $_POST['hgr_popup_height'] );			// You can set a static window height, otherwise the plugin will keep the responsive size settings of .venoframe class
			$hgr_popup_border_width		= sanitize_text_field( $_POST['hgr_popup_border_width'] );	// Border thickness of the popup window in pixel - default: '0px'
			$hgr_popup_bgcolor			= sanitize_text_field( $_POST['hgr_popup_bgcolor'] );		// Background color of popup window (also affects border color, if has a border) - default: '#ffffff'
			$hgr_popup_overlay_color	= sanitize_text_field( $_POST['hgr_popup_overlay_color'] );	// Background color of popup overlay (modal)
			$hgr_popup_seconds			= sanitize_text_field( $_POST['hgr_popup_seconds'] );		// If above is seconds, how many seconds?! 
			
	
			
			// Update the meta field in the database
			//update_post_meta( $post_id, '_hgr_popup_data_type',		$hgr_popup_data_type );
			update_post_meta( $post_id, '_hgr_popup_width',			$hgr_popup_width );
			update_post_meta( $post_id, '_hgr_popup_height',			$hgr_popup_height );
			update_post_meta( $post_id, '_hgr_popup_border_width',	$hgr_popup_border_width );
			update_post_meta( $post_id, '_hgr_popup_bgcolor',		$hgr_popup_bgcolor );
			update_post_meta( $post_id, '_hgr_popup_overlay_color',	$hgr_popup_overlay_color );
			update_post_meta( $post_id, '_hgr_popup_seconds',		$hgr_popup_seconds );
		}
		
		
		/*
		*	Function to get and display HGR Popup on page, post, etc
		*	Hooked into wp_footer (see constructor function above)
		*	@since 1.0.0
		*/
		function do_popup(){
		
		$hgr_popup_id			=	get_post_meta( get_the_ID(), '_hgr_popup_id', true );
		
		// Get popup metaboxes values from database
		$hgr_popup_width		=	get_post_meta( $hgr_popup_id	, '_hgr_popup_width', true );			// You can set a static window width, otherwise the plugin will keep the responsive size settings of .venoframe class
		$hgr_popup_height		=	get_post_meta( $hgr_popup_id	, '_hgr_popup_height', true );			// You can set a static window height, otherwise the plugin will keep the responsive size settings of .venoframe class
		$hgr_popup_border_width	=	get_post_meta( $hgr_popup_id	, '_hgr_popup_border_width', true );		// Border thickness of the popup window in pixel - default: '0px'
		$hgr_popup_bgcolor		=	get_post_meta( $hgr_popup_id	, '_hgr_popup_bgcolor', true );			// Background color of popup window (also affects border color, if has a border) - default: '#ffffff'
		$hgr_popup_overlay_color=	get_post_meta( $hgr_popup_id	, '_hgr_popup_overlay_color', true );	// Background color of popup overlay (modal)
		$hgr_popup_seconds		=	get_post_meta( $hgr_popup_id	, '_hgr_popup_seconds', true );			// If above is seconds, how many seconds?! 
		
		if( !empty($hgr_popup_id) && is_numeric($hgr_popup_id) ) {
			
			wp_enqueue_style( 'theshop-venobox-style' );
			wp_enqueue_script( 'theshop-venobox' );
		
			$args = array(
				   'post_type'	=>	'hgr_popup',
				   'p'			=>	$hgr_popup_id,
				 );
			$hgr_query = new WP_Query($args);
			
			if( $hgr_query->have_posts() ) {
				$output = '';
				
				// Appear after time or scroll?
				// TIME
				if( !empty($hgr_popup_seconds) && is_numeric($hgr_popup_seconds) ){
					
					$output .= '<script type="text/javascript">
						jQuery(document).ready(function($) {
							"use strict";
							setTimeout(function(){
								// Auto-open #hgr_popup_'.$hgr_popup_id.' after '.$hgr_popup_seconds	.' seconds
   								$(".hgr_popup_'.$hgr_popup_id.'").venobox({	framewidth: "'.$hgr_popup_width.'px",        // default: ""
																		frameheight: "'.$hgr_popup_height.'px",       // default: ""
																		border: "'.$hgr_popup_border_width.'px",             // default: "0"
																		bgcolor: "'.$hgr_popup_bgcolor.'",         // default: "#fff"
																	}).trigger("click");
						}, '.$hgr_popup_seconds.'000);
						
						});
						</script>';
					
					while ( $hgr_query->have_posts() ) {
						$hgr_query->the_post();
						
						$output .= '<a class="venobox hgr_popup_'.$hgr_popup_id.'" data-type="inline" href="#hgr_popup_'.$hgr_popup_id.'" data-overlay="'.$hgr_popup_overlay_color.'"></a>';
						$output .= '<div class="hgr_popup" id="hgr_popup_'.$hgr_popup_id.'" style="display:none;">';
						$output .= HGR_XTND::hgr_xtnd_getPostContent();
						$output .= '</div>';
					}
					echo $output;
				}
			}
		}
		return false;
	}
		
		/*
			Register necessary js and css files on frontend
		*/
		function hgr_front_scripts(){
			wp_register_script('theshop-venobox',$this->js_dir.'venobox.min.js', array('jquery'), '' );
			wp_register_style('theshop-venobox-style',$this->css_dir.'venobox.css', '', '' );
		}
	
	}
	/*
		All good, fire up the plugin :)
	*/
	new HGR_POPUPS;
}