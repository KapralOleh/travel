<?php
/*
	Plugin Name: Highgrade Add-Ons: Info Bars
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 1.0.0
	Description: Part of HighGrade Add-Ons for HighGrade themes.
	Text Domain: hgr
*/

/*
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_INFOBARS')) {
	
	/*
	* Any dependency, version, updates check?
	*/ 
	add_action('admin_init','initiate_hgr_infobars');
	function initiate_hgr_infobars() {
		// TBD
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
	add_action( 'plugins_loaded', 'hgr_infobars_load_textdomain' );
	function hgr_infobars_load_textdomain() {
	  load_plugin_textdomain( 'hgr_lang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	
	/**
	 * Function to check if theme is installed and activated
	*/
	if( !function_exists('hgr_theme_dependency_check') ) {
		function hgr_theme_dependency_check() {
			$theme = wp_get_theme(); // gets the current theme
			if ('Hatch' == $theme->name || 'Hatch' == $theme->parent_theme) {
				// if you're here twenty twelve is the active theme or is
				// the current theme's parent theme
				return true;
			}
			return false;
		 }
	}
	
	
	
	class HGR_INFOBARS{
		
		var $css_dir;
		
		public function __construct(){
			
			$this->css_dir			=	plugins_url('css/',__FILE__);
			
			register_activation_hook( __FILE__, array($this, 'hgr_install' ));

			add_action('wp_enqueue_scripts',array($this,'hgr_front_scripts'));
			
			add_action('init',array($this,'hgr_post_type'));
			
			add_action('add_meta_boxes',array($this,'add_info_bar_meta'));
			add_action('save_post',array($this,'save_info_bar_settings'));
			
			// Hook it to the action
			add_action('hatch_after_body_open', array($this,'do_hgr_infobar') );
		}
		
		/**
		* Install function
		* @since 1.0.0
		*/
		public function hgr_install(){
				update_option('hgr_info_bars_version', '1.0.0' );
				/**
				 * Get notices array and update them
				*/
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$theme		=	wp_get_theme();
				/**
				 * Check if theme is installed and activated
				*/
				if( !hgr_theme_dependency_check() ) {
					$notices[]	=	"Highgrade Info Bars Add-On is part of HighGrade Add-Ons Pack and its only available with <b>".$theme->name."</b> theme. You are not allowed to use this pack of parts of it outside <b>".$theme->name."</b> theme.";
				} else {
					
					$notices[]	=	"Highgrade Info Bars Add-On its activated now! Thank you for using <b>".$theme->name."</b> theme.";
				}
				update_option('hgr_admin_notices', $notices);
			}
		
		
		/**
		*	Register the post type hgr_info_bars
		*	@since 1.0.0
		*/
		function hgr_post_type() {
			register_post_type( 'hgr_info_bars',
				array(
					'labels' => array(
						'name'               => esc_html__( 'Info Bars', 'hgr_lang' ),
						'singular_name'      => esc_html__( 'Info Bar', 'hgr_lang' ),
						'menu_name'          => esc_html__( 'Info Bars', 'hgr_lang' ),
						'name_admin_bar'     => esc_html__( 'Info Bar', 'hgr_lang' ),
						'add_new'            => esc_html__( 'Add New info bar', 'hgr_lang' ),
						'add_new_item'       => esc_html__( 'Add New Info Bar', 'hgr_lang' ),
						'new_item'           => esc_html__( 'New Info Bar', 'hgr_lang' ),
						'edit_item'          => esc_html__( 'Edit Info Bar', 'hgr_lang' ),
						'view_item'          => esc_html__( 'View Info Bar', 'hgr_lang' ),
						'all_items'          => esc_html__( 'All Info Bars', 'hgr_lang' ),
						'search_items'       => esc_html__( 'Search Info Bars', 'hgr_lang' ),
						'not_found'          => esc_html__( 'No info bars found.', 'hgr_lang' ),
						'not_found_in_trash' => esc_html__( 'No info bars found in Trash.', 'hgr_lang' ),
					),
				'public' => true,
				'menu_icon'=>'dashicons-align-center',
				'has_archive' => true,
				'rewrite' => array('slug' => 'info_bar'),
				'supports' => array('title','editor','thumbnail')
				)
			);
		}
		
		
		
		/**
		*	Do the Info Bar 
		*	@since 1.0.0
		*/
		function do_hgr_infobar(){
			$hgr_options		=	get_option( 'redux_options' );
			$info_bar_content	=	'<!-- HGR Info Bar START -->';
			$info_bar_ID		=	$hgr_options['top_info_bar_select'];
			
			$bottom_margin		=	( isset($hgr_options['body_border_dimensions']['width']) && !empty($hgr_options['body_border_dimensions']['width']) ? $hgr_options['body_border_dimensions']['width'] : '0');
			
			if( isset($hgr_options['enable_top_info_bar']) && $hgr_options['enable_top_info_bar'] == '1') {
				if( isset($_COOKIE['hgr_info_bar_display_'.$info_bar_ID]) && $_COOKIE['hgr_info_bar_display_'.$info_bar_ID] == 'hidden' ) {
					return false;
				}
				else {
					if( !empty($info_bar_ID) && is_numeric($info_bar_ID) ) {
						// Get post meta
						$hgr_info_bar_bgcolor		=	get_post_meta( $info_bar_ID, '_hgr_info_bar_bgcolor', true );
						$hgr_info_bar_btn_text		=	get_post_meta( $info_bar_ID, '_hgr_info_bar_btn_text', true );
						$hgr_info_bar_btn_text_clr	=	get_post_meta( $info_bar_ID, '_hgr_info_bar_btn_text_clr', true );
						$hgr_info_bar_btn_color		=	get_post_meta( $info_bar_ID, '_hgr_info_bar_btn_color', true );
						$hgr_info_bar_btnroundness	=	get_post_meta( $info_bar_ID, '_hgr_info_bar_btnroundness', true );
						$hgr_info_bar_link			=	get_post_meta( $info_bar_ID, '_hgr_info_bar_link', true );
						$hgr_info_bar_display_mode	=	get_post_meta( $info_bar_ID, '_hgr_info_bar_display_mode', true );
						
						// does it has background image?
						if ( has_post_thumbnail($info_bar_ID	) ) { // check if the post has a Post Thumbnail assigned to it.
							$info_bar_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($info_bar_ID), 'full' );
							$info_bar_image_url = $info_bar_image_url[0];
							
							$inline_style = ' style="background-color:'.$hgr_info_bar_bgcolor.';background-image:url('.$info_bar_image_url.'); background-repeat:no-repeat;background-size:contain;background-position:center center;" ';
						} else {$inline_style = ' style="background-color:'.$hgr_info_bar_bgcolor.'; position:fixed;bottom:'.$bottom_margin.';z-index:1000;width:100%;" ';}
					
					
						$info_bar = get_post($info_bar_ID, ARRAY_A);
							$info_bar_content	.=	'<div class="top_info_bar" '.$inline_style.'>';
							$info_bar_content	.=	'<div class="container">';
								
							$info_bar_content	.= ( $hgr_info_bar_display_mode == 'can_be_closed' ? '<span class="icon info_bar_close close fa fa-close" style="color:'.( !empty($hgr_info_bar_btn_color) ? $hgr_info_bar_btn_color : '#fff' ).';"></span>' : '');
								
							$info_bar_content	.= ( !empty($hgr_info_bar_link) ? '<a href="'.$hgr_info_bar_link.'">' : '');
							$info_bar_content	.= ( !empty($hgr_info_bar_btn_text) ? '<div class="top_info_bar_btn" style="background-color:'.$hgr_info_bar_btn_color.'; padding:8px 16px;border-radius:'.$hgr_info_bar_btnroundness.'px;color:'.$hgr_info_bar_btn_text_clr.';">'.$hgr_info_bar_btn_text.'</div>' : '');
							
							$info_bar_content	.=	'<div class="top_info_bar_content">' . $info_bar['post_content'] . '</div>';
								
							$info_bar_content	.=	( !empty($hgr_info_bar_link) ? '</a>' : '');
								
							$info_bar_content	.=	'</div>';
							$info_bar_content	.=	'</div><!-- end container --><div class="clear"></div><!-- HGR Info Bar END -->';
							
							$info_bar_content	.= '<script type="text/javascript">
								jQuery(document).ready(function($) {   
									var add_margin = jQuery(".top_info_bar").outerHeight( true );
									
									jQuery("#website_boxed, .back-to-top").css("margin-bottom", add_margin);'."\n\r";				
									
									if($hgr_info_bar_display_mode == 'can_be_closed'){
										$info_bar_content	.= '	jQuery(".info_bar_close").on("click", function() {
											jQuery(".top_info_bar").css("display","none");
											jQuery("#website_boxed").css("margin-bottom", 0);
											jQuery(".back-to-top").css("margin-bottom", 0);
											jQuery.cookie("hgr_info_bar_display_'.$info_bar_ID.'", "hidden");
										});
										';
									
									}
							$info_bar_content	.= '	
								});             
								</script>';
						echo $info_bar_content;
					}
				}
			}
			return false;
		}
		
		
		/*
		*	Info Bar Meta Box
		*	@since 1.0.0
		*/
		function add_info_bar_meta() {
			$screens = array( 'hgr_info_bars' );
			foreach ( $screens as $screen ) {
				add_meta_box(	'hgr_info_bar_metabox',
								__( 'Info Bar Settings', 'hgr_lang' ),
								array($this,'display_info_bar_settings'),
								$screen,
								'side',
								'high'
							);
			}}
			
		// Print the info bar settings
		function display_info_bar_settings($post) { 
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'sage_inner_custom_box', 'sage_inner_custom_box_nonce' );
		
			// Get metaboxes values from database
			$hgr_info_bar_bgcolor		=	get_post_meta( $post->ID, '_hgr_info_bar_bgcolor', true );
			$hgr_info_bar_btn_text		=	get_post_meta( $post->ID, '_hgr_info_bar_btn_text', true );
			$hgr_info_bar_btn_text_clr	=	get_post_meta( $post->ID, '_hgr_info_bar_btn_text_clr', true );
			$hgr_info_bar_btn_color		=	get_post_meta( $post->ID, '_hgr_info_bar_btn_color', true );
			$hgr_info_bar_btnroundness	=	get_post_meta( $post->ID, '_hgr_info_bar_btnroundness', true );
			$hgr_info_bar_link			=	get_post_meta( $post->ID, '_hgr_info_bar_link', true );
			$hgr_info_bar_display_mode	=	get_post_meta( $post->ID, '_hgr_info_bar_display_mode', true );
			
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_style('wp-color-picker');
		
			echo '<script type="text/javascript">
			jQuery(document).ready(function($) {   
				jQuery("#hgr_info_bar_bgcolor, #hgr_info_bar_btn_color, #hgr_info_bar_btn_text_clr").wpColorPicker();
			});             
			</script>';
			
			// Construct the metaboxes and print out	
			// Info Bar BG Color
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_bgcolor" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar BG Color", 'hgr_lang' );
			echo '</label> ';
			echo '<input name="hgr_info_bar_bgcolor" type="text" id="hgr_info_bar_bgcolor" value="' . esc_attr( $hgr_info_bar_bgcolor ) . '" data-default-color="#ffffff"></div>';
			
			// Button Text
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_btn_text" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Button Text", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_info_bar_btn_text" name="hgr_info_bar_btn_text" value="' . esc_attr( $hgr_info_bar_btn_text ) . '" size="25" placeholder="Leave empty for No Button" style="width:100%;" /></div>';
			
			// Button Text Color
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_btn_text_clr" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar Button Text Color", 'hgr_lang' );
			echo '</label> ';
			echo '<input name="hgr_info_bar_btn_text_clr" type="text" id="hgr_info_bar_btn_text_clr" value="' . esc_attr( $hgr_info_bar_btn_text_clr ) . '" data-default-color="#ffffff"></div>';
			
			// Button Color
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_btn_color" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar Button Color", 'hgr_lang' );
			echo '</label> ';
			echo '<input name="hgr_info_bar_btn_color" type="text" id="hgr_info_bar_btn_color" value="' . esc_attr( $hgr_info_bar_btn_color ) . '" data-default-color="#ff0000"></div>';
			
			// Info Bar Btn Roundness
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_btnroundness" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar Button Roundness", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_info_bar_btnroundness" name="hgr_info_bar_btnroundness" value="' . esc_attr( $hgr_info_bar_btnroundness ) . '" size="25" placeholder="Ex (pixels): 4" style="width:100%;" /></div>';
			
			// Info Bar link
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="hgr_info_bar_link" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar Link", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="hgr_info_bar_link" name="hgr_info_bar_link" value="' . esc_attr( $hgr_info_bar_link ) . '" size="25" placeholder="Ex: http://www.instagram.com/highgradelab" style="width:100%;" /></div>';
			
			// Info Bar Display Mode
			echo '<div class="settBlock"><label for="hgr_info_bar_display_mode" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Info Bar Display Mode", 'hgr_lang' );
			echo '</label> ';
			if($hgr_info_bar_display_mode == 'always_on'){
				echo '<select name="hgr_info_bar_display_mode" id="hgr_info_bar_display_mode">
						<option value="always_on" name="always_on" selected="selected">Always ON</option>
						<option value="can_be_closed" name="can_be_closed">Can Be Closed</option>
					</select></div>';
			}
			elseif($hgr_info_bar_display_mode == 'can_be_closed'){
				echo '<select name="hgr_info_bar_display_mode" id="hgr_info_bar_display_mode">
						<option value="always_on" name="always_on">Always ON</option>
						<option value="can_be_closed" name="can_be_closed" selected="selected">Can Be Closed</option>
					</select></div>';
			}
			else{
				echo '<select name="hgr_info_bar_display_mode" id="hgr_info_bar_display_mode">
						<option value="always_on" name="always_on">Always ON</option>
						<option value="can_be_closed" name="can_be_closed">Can Be Closed</option>
					</select></div>';
			}
		  }
		  
		// Save the info bar settings
		function save_info_bar_settings( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['sage_inner_custom_box_nonce'] ) ) {
				return $post_id;
			}
		
			$nonce = $_POST['sage_inner_custom_box_nonce'];
		
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'sage_inner_custom_box' ) ) {
				return $post_id;
			}
		
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
		
			// Check the user's permissions.
			if ( 'hgr_info_bars' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}
			
			// OK to save data
			// Sanitize user input
			$hgr_info_bar_bgcolor		= sanitize_text_field( $_POST['hgr_info_bar_bgcolor'] );
			$hgr_info_bar_btn_text		= sanitize_text_field( $_POST['hgr_info_bar_btn_text'] );
			$hgr_info_bar_btn_text_clr	= sanitize_text_field( $_POST['hgr_info_bar_btn_text_clr'] );
			$hgr_info_bar_btn_color		= sanitize_text_field( $_POST['hgr_info_bar_btn_color'] );
			$hgr_info_bar_btnroundness	= sanitize_text_field( $_POST['hgr_info_bar_btnroundness'] );
			$hgr_info_bar_link			= sanitize_text_field( $_POST['hgr_info_bar_link'] );
			$hgr_info_bar_display_mode	= sanitize_text_field( $_POST['hgr_info_bar_display_mode'] );
			
			// Update the meta field in the database
			update_post_meta( $post_id, '_hgr_info_bar_bgcolor',			$hgr_info_bar_bgcolor );
			update_post_meta( $post_id, '_hgr_info_bar_btn_text',		$hgr_info_bar_btn_text );
			update_post_meta( $post_id, '_hgr_info_bar_btn_text_clr',	$hgr_info_bar_btn_text_clr );
			update_post_meta( $post_id, '_hgr_info_bar_btn_color',		$hgr_info_bar_btn_color );
			update_post_meta( $post_id, '_hgr_info_bar_btnroundness',	$hgr_info_bar_btnroundness );
			update_post_meta( $post_id, '_hgr_info_bar_link',			$hgr_info_bar_link );
			update_post_meta( $post_id, '_hgr_info_bar_display_mode',	$hgr_info_bar_display_mode );}
		
		
		/*
			Register necessary js and css files on frontend
		*/
		function hgr_front_scripts(){
			wp_register_style('hgr-infobar',$this->css_dir.'frontend.css');
			wp_enqueue_style('hgr-infobar');
			wp_enqueue_script('hgr_jquery_cookie');
		}
	
	}
	/*
		All good, fire up the plugin :)
	*/
	new HGR_INFOBARS;
}