<?php
/*
	Plugin Name: Highgrade Add-Ons: Slide In Panel
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 1.0.0
	Description: Part of HighGrade Add-Ons for HighGrade themes. It requires Visual Composer min version 4.8
	Text Domain: hgr_lang
*/

/*
	Based on http://codyhouse.co/demo/client-testimonials-carousel/index.html
*/

/*
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_SLIDEINPANEL')) {
	
	/*
	* Any dependency, version, updates check?
	*/ 
	add_action('admin_init','initiate_hgr_slideinpanel');
	function initiate_hgr_slideinpanel() {
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
	add_action( 'plugins_loaded', 'hgr_slideinpanel_load_textdomain' );
	function hgr_slideinpanel_load_textdomain() {
	  load_plugin_textdomain( 'hgr_lang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
	
	
	/**
	 * Function to check if theme is installed and activated
	*/
	if( !function_exists('hgr_theme_dependency_check') ) {
		function hgr_theme_dependency_check() {
			$theme = wp_get_theme(); // gets the current theme
			if ('Hatch' == $theme->name || 'Hatch' == $theme->parent_theme) {
				// if you're here sage is the active theme or is
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
					if ( is_plugin_active('hgr_slide_in_panel/hgr_slide_in_panel.php') ) {
						deactivate_plugins( '/hgr_slide_in_panel/hgr_slide_in_panel.php', true );
					}
					/**
					 * Get notices array and update them
					*/
					delete_option('hgr_admin_notices');
					$notices	=	get_option( 'hgr_admin_notices', array() );
					$notices[]	=	__("Highgrade Slide In Panel Add-On is part of HighGrade Add-Ons Pack and it requires Visual Composer minimum version 4.8. Please install and activate Visual Composer 4.8 first.", "hgr_lang");
					update_option('hgr_admin_notices', $notices);
					return false;
				}
			} else {
				/*
					Deactivate the plugin as the conditions are not met
				*/
				if ( is_plugin_active('hgr_slide_in_panel/hgr_slide_in_panel.php') ) {
					deactivate_plugins( '/hgr_slide_in_panel/hgr_slide_in_panel.php', true );
				}
				/**
				 * Get notices array and update them
				*/
				delete_option('hgr_admin_notices');
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$notices[]	=	__("Highgrade Slide In Panel Add-On is part of HighGrade Add-Ons Pack and it requires Visual Composer minimum version 4.8. Please install and activate Visual Composer 4.8 first.", "hgr_lang");
				update_option('hgr_admin_notices', $notices);
				return false;
			}
			return false;
		 }
	}
		
	
	class HGR_SLIDEINPANEL {
		
		public function __construct(){
			
			require_once get_template_directory() . '/highgrade/Mobile_Detect.php';
						
			register_activation_hook( __FILE__, array($this, 'hgr_install' ));
			
			add_action('init',array($this,'hgr_post_type'));
			
			add_action( 'add_meta_boxes', array($this,'hgr_slide_in_panel_metaboxes') );
			add_action( 'save_post', array($this,'hgr_save_slide_in_panel_data') );
			
			// Hook into footer
			
			// Hook FS Search into footer, only if NOT MOBILE
			if( class_exists('Mobile_Detect') ){
				$detect = new Mobile_Detect;
				if( !$detect->isMobile() ){
					add_action('wp_footer', array($this,'do_slideinpanel') );
				}
			}
		}
		
		/**
		* Install function
		* @since 1.0.0
		*/
		public function hgr_install() {
				update_option('hgr_slideinpanel_version', '1.0.0' );
				/**
				 * Get notices array and update them
				*/
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$theme = wp_get_theme();
				/**
				 * Check if theme is installed and activated
				*/
				if( !hgr_theme_dependency_check() ) {
					$notices[]	=	__("Highgrade Slide In Panel AddOn is part of HighGrade AddOns Pack and its only available with <b>".$theme->name."</b> theme. You are not allowed to use this pack of parts of it outside <b>".$theme->name."</b> theme.", "hgr_lang");
				} else {
					
					$notices[]	=	__("Highgrade Slide In Panel AddOn its activated now! Thank you for using <b>".$theme->name."</b> theme.", "hgr_lang");
				}
				update_option('hgr_admin_notices', $notices);
			}
		
		/**
		* Create post type hgr_testimonials function
		* @since 1.0.0
		*/
		function hgr_post_type() {
			register_post_type( 'hgr_slide_in_panel',
				array(
					'labels' => array(
						'name'               => esc_html__( 'Slide In Panel', 'hgr_lang' ),
						'singular_name'      => esc_html__( 'Slide In Panel', 'hgr_lang' ),
						'menu_name'          => esc_html__( 'Slide In Panels', 'hgr_lang' ),
						'name_admin_bar'     => esc_html__( 'Slide In Panel', 'hgr_lang' ),
						'add_new'            => esc_html__( 'Add New', 'info bar', 'hgr_lang' ),
						'add_new_item'       => esc_html__( 'Add New Slide In Panel', 'hgr_lang' ),
						'new_item'           => esc_html__( 'New Slide In Panel', 'hgr_lang' ),
						'edit_item'          => esc_html__( 'Edit Slide In Panel', 'hgr_lang' ),
						'view_item'          => esc_html__( 'View Slide In Panel', 'hgr_lang' ),
						'all_items'          => esc_html__( 'All Slide In Panels', 'hgr_lang' ),
						'search_items'       => esc_html__( 'Search Slide In Panels', 'hgr_lang' ),
						'not_found'          => esc_html__( 'No slide In Panels found.', 'hgr_lang' ),
						'not_found_in_trash' => esc_html__( 'No slide In Panels found in Trash.', 'hgr_lang' ),
					),
					'public'			=>	true,
					'menu_icon'		=>	'dashicons-align-right',
					'has_archive'	=>	true,
					'rewrite'		=>	array( 'slug' => 'slide_in_panel' ),
					'supports'		=>	array(
						'title',
						'editor',
						'thumbnail'
					),
				)
			);
		}
		
		
		/**
		* Add hgr_slide_in_panel metaboxes function for posts, pages, etc
		* @since 1.0.0
		* Doc: https://codex.wordpress.org/Function_Reference/add_meta_box
		*/	
		function hgr_slide_in_panel_metaboxes() {
			$screens = array( 'post','page' ); // Available in all kind of posts types
			foreach ( $screens as $screen ) {
				add_meta_box(
					'hgr_slideinmetaboxid',							// $id
					__( 'Slide In Panel Settings', 'hgr_lang' ),		// $title
					array($this,'hgr_slide_in_panel_custom_box'),	// $callback
					$screen,										// $screen
					'side',											// $context
					'default'										// $priority
				);
			}
		}		
		function hgr_slide_in_panel_custom_box( $post ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'hgr_slide_in_panel_custom_box', 'hgr_slide_in_panel_custom_box_nonce' );
	
			// Get metaboxes values from database
			$hgr_slideinpanel_id			=	get_post_meta( $post->ID, '_hgr_slideinpanel_id', true );
			$hgr_slideinpanel_width			=	get_post_meta( $post->ID, '_hgr_slideinpanel_width', true );
			$hgr_slideinpanel_height		=	get_post_meta( $post->ID, '_hgr_slideinpanel_height', true );
			$hgr_slideinpanel_from			=	get_post_meta( $post->ID, '_hgr_slideinpanel_from', true );
			$hgr_slideinpanel_show_after	=	get_post_meta( $post->ID, '_hgr_slideinpanel_show_after', true );
			$hgr_slideinpanel_px_seconds	=	get_post_meta( $post->ID, '_hgr_slideinpanel_px_seconds', true );
						
			// Construct the metaboxes and print out
			
			
			// What Slide In Panel to display on this page?
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_slideinpanel_id" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Show this Slide In Panel", 'hgr_lang' );
			echo '</label> ';
				echo '<select name="hgr_slideinpanel_id" id="hgr_slideinpanel_id">';
				
				$args = array(
					'post_type'		=>	'hgr_slide_in_panel',
					'posts_per_page'=>	'99'
				 );
				$hgr_query = new WP_Query($args);
				$allPanels = '';
				if( $hgr_query->have_posts() ) {
					echo '<option value="" '.(empty($hgr_slideinpanel_id) ? 'selected = "selected"' : '').'>No Panel</option>';
					while ( $hgr_query->have_posts() ) {
						$hgr_query->the_post();
						echo '<option value="'.get_the_ID().'" '.($hgr_slideinpanel_id == get_the_ID() ? 'selected = "selected"' : '').'>'.get_the_title().'</option>';
					}
				} else {
					echo '<option value="" selected="selected">No Panel Available</option>';
				}
				echo '</select></div>';
			
			// Slide In Panel width
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_slideinpanel_width" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Slide In Panel Width", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_slideinpanel_width" name="hgr_slideinpanel_width" value="' . esc_attr( $hgr_slideinpanel_width ) . '" size="25" placeholder="Value in pixels: 400" /></div>';
			
			
			// Slide In Panel height
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_slideinpanel_height" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Slide In Panel Height", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_slideinpanel_height" name="hgr_slideinpanel_height" value="' . esc_attr( $hgr_slideinpanel_height ) . '" size="25" placeholder="Value in pixels: 400" /></div>';
			
			// Slide In Panel from
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_slideinpanel_from" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Slide In Panel from", 'hgr_lang' );
			echo '</label> ';
				echo '<select name="hgr_slideinpanel_from" id="hgr_slideinpanel_from">
						<option value="left" '.($hgr_slideinpanel_from == 'left' ? ' selected="selected"' : '').'>Left</option>
						<option value="right"'.($hgr_slideinpanel_from == 'right' ? ' selected="selected"' : '').'>Right</option>
					</select></div>';
				
			
			// Slide In Panel show after
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_slideinpanel_show_after" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Slide In Panel Show After", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_slideinpanel_show_after" name="hgr_slideinpanel_show_after" value="' . esc_attr( $hgr_slideinpanel_show_after ) . '" size="15" placeholder="Empty, px, seconds" />';
			
			echo '<select name="hgr_slideinpanel_px_seconds" id="hgr_slideinpanel_px_seconds">
						<option value="" '.($hgr_slideinpanel_px_seconds == '' ? ' selected="selected"' : '').'>-</option>
						<option value="pixels" '.($hgr_slideinpanel_px_seconds == 'pixels' ? ' selected="selected"' : '').'>Pixels</option>
						<option value="seconds" '.($hgr_slideinpanel_px_seconds == 'seconds' ? ' selected="selected"' : '').'>Seconds</option>
					</select>';
			_e( "Empty field means Slide In Panel appears after page scrolls to bottom", 'hgr_lang' );
			echo '</div> ';
				
		}
		function hgr_save_slide_in_panel_data( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['hgr_slide_in_panel_custom_box_nonce'] ) ) {
				return $post_id;
			}
	
			$nonce = $_POST['hgr_slide_in_panel_custom_box_nonce'];
	
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'hgr_slide_in_panel_custom_box' ) ) {
				return $post_id;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			// Check the user's permissions.
			if ( 'hgr_slide_in_panel' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}
			
			// OK to save data
			// Sanitize user input
			$hgr_slideinpanel_id			= sanitize_text_field( $_POST['hgr_slideinpanel_id'] );
			$hgr_slideinpanel_width			= sanitize_text_field( $_POST['hgr_slideinpanel_width'] );
			$hgr_slideinpanel_height		= sanitize_text_field( $_POST['hgr_slideinpanel_height'] );
			$hgr_slideinpanel_from			= sanitize_text_field( $_POST['hgr_slideinpanel_from'] );
			$hgr_slideinpanel_show_after	= sanitize_text_field( $_POST['hgr_slideinpanel_show_after'] );
			$hgr_slideinpanel_px_seconds	= sanitize_text_field( $_POST['hgr_slideinpanel_px_seconds'] );
			
	
			
			// Update the meta field in the database
			update_post_meta( $post_id, '_hgr_slideinpanel_id',			$hgr_slideinpanel_id );
			update_post_meta( $post_id, '_hgr_slideinpanel_width',		$hgr_slideinpanel_width );
			update_post_meta( $post_id, '_hgr_slideinpanel_height',		$hgr_slideinpanel_height );
			update_post_meta( $post_id, '_hgr_slideinpanel_from',		$hgr_slideinpanel_from );
			update_post_meta( $post_id, '_hgr_slideinpanel_show_after',	$hgr_slideinpanel_show_after );
			update_post_meta( $post_id, '_hgr_slideinpanel_px_seconds',	$hgr_slideinpanel_px_seconds );
		}
		
		
		/*
		*	Function to get and display Slide In Panel on page, post, etc
		*	Hooked into wp_footer (see constructor function above)
		*	@since 1.0.0
		*/
		function do_slideinpanel(){
			
			$hgr_slideinpanel_id			=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_id', true );
			$_hgr_slideinpanel_width		=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_width', true );
			$_hgr_slideinpanel_height		=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_height', true );
			$hgr_slideinpanel_from			=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_from', true );
			$hgr_slideinpanel_show_after	=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_show_after', true );
			$hgr_slideinpanel_px_seconds	=	get_post_meta( get_the_ID(), '_hgr_slideinpanel_px_seconds', true );		
			
			// No errors please
			$hgr_slideinpanel_width	=	( !empty( $_hgr_slideinpanel_width ) ?	$_hgr_slideinpanel_width.'px' : '400px' );
			$hgr_slideinpanel_height=	( !empty( $_hgr_slideinpanel_height ) ?	$_hgr_slideinpanel_height.'px' : 'auto' );
			
			
			if( !empty($hgr_slideinpanel_id) && is_numeric($hgr_slideinpanel_id) ) {
				$args = array(
					   'post_type'	=>	'hgr_slide_in_panel',
					   'p'			=>	$hgr_slideinpanel_id,
					 );
	
	
					//die(var_dump("adxaescfserge"));
					$hgr_query = new WP_Query($args);
				
					if( $hgr_query->have_posts() ) {
							$output = '';
							
							// Appear after time or scroll?
							// TIME
							if( !empty($hgr_slideinpanel_show_after) && is_numeric($hgr_slideinpanel_show_after) && $hgr_slideinpanel_px_seconds == "seconds" ){
								
							$output .= '<script type="text/javascript">
								jQuery(document).ready(function($) {
									"use strict";
									var ElPosition = "'.$hgr_slideinpanel_from.'";					
									setTimeout(function(){
										$(".hgr_slide_in_panel").animate({"'.$hgr_slideinpanel_from.'":"20px"}, "slow");
									}, '.$hgr_slideinpanel_show_after.'000);
									
									$(".slide_in_panel_close").click(function() {
										$(".hgr_slide_in_panel").css("display","none");
									});
									
								});
								</script>
								<style>
								.hgr_slide_in_panel{
								position:fixed;
								bottom:20px;
								overflow:hidden;
								margin:0!important;
								box-sizing:content-box;
								'.$hgr_slideinpanel_from.':-'.$hgr_slideinpanel_width.';
								z-index:99999;
								}
								.slide_in_panel_close{
									margin-right:10px;
									margin-top:10px;
									font-family: "fontawesome";
								}
								'.$mobile_height.'
								</style>
								
								';
							}
							// SCROLL
							else {
								$output .= '<script type="text/javascript">
								jQuery(document).ready(function($) {
									"use strict";
									
									var ElPosition		=	"'.$hgr_slideinpanel_from.'";
									var appearAfter 	=	'.( empty($hgr_slideinpanel_show_after) ? '$(document).height() - $(window).height() - 100' : '"'.$hgr_slideinpanel_show_after.'"').';
									var $win 			=	$(window);
									
									function checkScroll() {
										if ($win.scrollTop() > appearAfter) {
											$win.off("scroll", checkScroll);
											$(".hgr_slide_in_panel").animate({"'.$hgr_slideinpanel_from.'":"20px"}, "slow");
										}
									}
									
									$win.scroll(checkScroll);
									
									$(".slide_in_panel_close").click(function() {
										$(".hgr_slide_in_panel").css("display","none");
									});
									
								});
								</script>
								<style>
								.hgr_slide_in_panel{
								position:fixed;
								bottom:20px;
								overflow:hidden;
								margin:0!important;
								box-sizing:content-box;
								'.$hgr_slideinpanel_from.':-'.$hgr_slideinpanel_width.';
								z-index:99999;
								}
								.slide_in_panel_close{
									margin-right:10px;
									margin-top:10px;
									font-family: "fontawesome";
								}
								</style>
								
								';
							}
							while ( $hgr_query->have_posts() ) {
								$hgr_query->the_post();
								//-'.$hgr_slideinpanel_width.'
								$output .= '<div class="hgr_slide_in_panel" style="width:'.$hgr_slideinpanel_width.'; height:'.$hgr_slideinpanel_height.';"><span class="slide_in_panel_close close fa-times"></span>';
								$output .= HGR_XTND::hgr_xtnd_getPostContent();
								$output .= '</div>';
							}
							echo $output;
						}
				
			}
			return false;
		}
	
	}
	/*
		All good, fire up the plugin :)
	*/
	new HGR_SLIDEINPANEL;

}