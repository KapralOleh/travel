<?php
/*
	Plugin Name: Highgrade Essentials
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 1.3.1
	Description: Essential features and goodies for HighGrade Themes. Activating HGR Essentials will register two new post types (Portfolio & Testimonials) and will enable Full-Screen Search feature.
	Text Domain: hgr_lang
*/

/*
*	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_ESSENTIALS')) {
	
	class HGR_ESSENTIALS {
		
		var $js_dir;
		var $css_dir;
		var $gfx_dir;
		
		/**
		*	Constructor function
		*	@since 1.0.0
		*/
		public function __construct(){
			// Activation hook
			register_activation_hook( __FILE__, array($this, 'hgr_install' ));
			
			// Admin notices
			add_action('admin_notices', array($this,'hgr_admin_notices'));
			
			// Add language option
			add_action( 'plugins_loaded', array($this,'hgr_load_textdomain') );
			
			// WP-Admin Menu
			//	DEPRECATED
			//add_action('admin_menu', array($this,'hgr_essentials_menu'));
			
			// CSS and JS for back-end and front-end
			$this->js_dir	=	plugins_url('js/',__FILE__);
			$this->css_dir	=	plugins_url('css/',__FILE__);
			$this->gfx_dir	=	plugins_url('gfx/',__FILE__);
			
			// Enqueue required frontend scripts & styles
			add_action('wp_enqueue_scripts',array($this,'hgr_front_scripts'));
			
			// Register required post types
			add_action('init',array($this,'hgr_post_types'));
			
			// Register required taxonomies
			add_action('init',array($this,'hgr_taxonomies'));
			
			// Visual Composer Elements
			add_action('admin_init', array($this, 'hgr_testimonials_init'));
			
			// Required shortcodes
			add_shortcode( 'hgr_testimonials', array($this,'hgr_testimonials_shortcode') );
			add_shortcode( 'woocommerce_shop_page', array($this,'woo_shop_page_shortcode') );
			
			// Required MetaBoxes
			add_action( 'add_meta_boxes', array($this,'hgr_testimonials_metaboxes') );
			add_action( 'save_post', array($this,'hgr_save_testimonial_data') );
			
			/*add_action( 'add_meta_boxes', array($this,'hgr_parent_metabox') );
			add_action( 'save_post', array($this,'hgr_save_parent_metabox_data') );*/
			
			// Hook FS Search into footer
			add_action('wp_footer', array($this,'do_fssearch') );
		}
		
		
		/**
		*	Load plugin textdomain.
		*	@since 1.0.0
		*/
		function hgr_load_textdomain() {
		  load_plugin_textdomain( 'hgr_lang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
		}
		
		
		/**
		*	Function to check if theme is installed and activated
		*	@since 1.0.0
		*/
		public function hgr_theme_dependency_check() {
			/*$theme = wp_get_theme(); // gets the current theme
			if ('Hatch' == $theme->name || 'Hatch' == $theme->parent_theme) {
				// if you're here twenty twelve is the active theme or is
				// the current theme's parent theme
				return true;
			}
			return false;*/
			return true;
		 }
		 
		 
		 /**
		*	Function to display admin notices
		*	@since 1.0.0
		*/
		function hgr_admin_notices() {
		  if ($notices= get_option('hgr_admin_notices')) {
			foreach ($notices as $notice) {
			  echo "<div class='updated notice is-dismissible'><p>$notice</p></div>";
			}
			delete_option('hgr_admin_notices');
		  }
		}
		 
		
		/**
		*	Install function
		*	@since 1.0.0
		*/
		function hgr_install(){
			update_option('hgr_essentials_version', '1.3.1' );
			/**
			*	Get notices array and update them
			*/
			$notices	=	get_option( 'hgr_admin_notices', array() );
			$theme		=	wp_get_theme();
			/**
			*	Check if theme is installed and activated
			*/
			if( !$this->hgr_theme_dependency_check() ) {
				$notices[]	=	__("Highgrade Essentials its only available with <b>".$theme->name."</b> theme. You are not allowed to use this outside <b>".$theme->name."</b> theme.", "hgr_lang");
			} else {
				$notices[]	=	__("Highgrade Essentials its activated now! Thank you for using <b>".$theme->name."</b> Theme.", "hgr_lang");
			}
			update_option('hgr_admin_notices', $notices);
		}
		
		
		/**
		*	WP-Admin menu function
		*	@since 1.0.0
		*	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		*	DEPRECATED
		*/
		function hgr_essentials_menu() {
			add_menu_page( 'HGR Essentials', 'HGR Essentials', 'manage_options', 'hgr_essentials/hgr_essentials.php', array($this,'hgr_essentials'), $this->gfx_dir.'menu_icon.png', 63 );
		}
		
		
		/**
		*	Main Function for WP-Admin area
		*	@since 1.0.0
		*	DEPRECATED
		*/
		function hgr_essentials(){
			$output = '<div class="wrap">';
				$output .= '<h2>';
				$output .= esc_html__( "HGR Essentials", 'hgr_lang' );
				$output .= '</h2>';
				
				$output .= '<p>';
					$output .= esc_html__( "HGR Essentials is a collection of plugins specially created for our theme. They are required in order for this theme to work.", 'hgr_lang' );
				$output .= '</p>';
				
				$output .= '<h3>';
					$output .= esc_html__( "HGR Testimonials", 'hgr_lang' );
				$output .= '</h3>';
				$output .= '<p>';
					$output .= esc_html__( "This plugin adds a custom post type, so you can add and display testimonials from your customers.", 'hgr_lang' );
				$output .= '</p>';
				
				$output .= '<h3>';
					$output .= esc_html__( "HGR Portfolio", 'hgr_lang' );
				$output .= '</h3>';
				$output .= '<p>';
					$output .= esc_html__( "Do you want a quick and clean way to display some portfolio items? You got it with HGR Portfolio.", 'hgr_lang' );
				$output .= '</p>';
				
				$output .= '<h3>';
					$output .= esc_html__( "HGR FullScreen Search", 'hgr_lang' );
				$output .= '</h3>';
				$output .= '<p>';
					$output .= esc_html__( "This one adds a full-screen in-site search feature for your visitors", 'hgr_lang' );
				$output .= '</p>';
				
				$output .= '<h3>';
					$output .= esc_html__( "HGR Super Search", 'hgr_lang' );
				$output .= '</h3>';
				$output .= '<p>';
					$output .= esc_html__( "HGR Super Search adds a neat search feature for in-site search. Try it, you and your visitors will love it.", 'hgr_lang' );
				$output .= '</p>';
			
				
				
			$output .= '</div><!-- .wrap-->';
			
			echo $output;
		}
		
		
		/**
		*	Create required post types
		*	@since 1.0.0
		*/
		function hgr_post_types() {
			// Testimonial post type
			register_post_type( 'hgr_testimonials',
				array(
					'labels' => array(
						'name'               => esc_html__( 'Testimonials', 'hgr_lang' ),
						'singular_name'      => esc_html__( 'Testimonial', 'hgr_lang' ),
						'menu_name'          => esc_html__( 'Testimonials', 'hgr_lang' ),
						'name_admin_bar'     => esc_html__( 'Testimonial', 'hgr_lang' ),
						'add_new'            => esc_html__( 'Add New', 'info bar', 'hgr_lang' ),
						'add_new_item'       => esc_html__( 'Add New Testimonial', 'hgr_lang' ),
						'new_item'           => esc_html__( 'New Testimonial', 'hgr_lang' ),
						'edit_item'          => esc_html__( 'Edit Testimonial', 'hgr_lang' ),
						'view_item'          => esc_html__( 'View Testimonial', 'hgr_lang' ),
						'all_items'          => esc_html__( 'All Testimonials', 'hgr_lang' ),
						'search_items'       => esc_html__( 'Search Testimonials', 'hgr_lang' ),
						'not_found'          => esc_html__( 'No testimonial found.', 'hgr_lang' ),
						'not_found_in_trash' => esc_html__( 'No testimonial found in Trash.', 'hgr_lang' ),
					),
				'public' => true,
				'menu_icon'=>'dashicons-editor-quote',
				'has_archive' => true,
				'rewrite' => array('slug' => 'testimonials'),
				'supports' => array('title', 'editor', 'thumbnail'),
				)
			);
			
			// Portfolio post type
			register_post_type( 'hgr_portfolio',
				array(
					'labels' => array(
						'name'               => esc_html__( 'Portfolio', 'hgr_lang' ),
						'singular_name'      => esc_html__( 'Portfolio', 'hgr_lang' ),
						'menu_name'          => esc_html__( 'Portfolio', 'hgr_lang' ),
						'name_admin_bar'     => esc_html__( 'Portfolio', 'hgr_lang' ),
						'add_new'            => esc_html__( 'Add New', 'info bar', 'hgr_lang' ),
						'add_new_item'       => esc_html__( 'Add New Portfolio Item', 'hgr_lang' ),
						'new_item'           => esc_html__( 'New Portfolio Item', 'hgr_lang' ),
						'edit_item'          => esc_html__( 'Edit Portfolio Item', 'hgr_lang' ),
						'view_item'          => esc_html__( 'View Portfolio Item', 'hgr_lang' ),
						'all_items'          => esc_html__( 'All Portfolio', 'hgr_lang' ),
						'search_items'       => esc_html__( 'Search Portfolio', 'hgr_lang' ),
						'not_found'          => esc_html__( 'No portfolio item found.', 'hgr_lang' ),
						'not_found_in_trash' => esc_html__( 'No portfolio item found in Trash.', 'hgr_lang' ),
					),
					'public'		=>	true,
					'menu_icon'		=>	'dashicons-format-image',
					'has_archive'	=>	true,
					'rewrite'		=>	array('slug' => 'portfolio'),
					'supports'		=>	array(
						'title',
						'editor',
						'author',
						'thumbnail',
						'excerpt',
						'comments',
					),
					'taxonomies'	=>	array(
						'post_tag',
						'portfolio-category',
					)
				)
			);
		}
		
		
		/**
		*	Register required taxonomies
		*	@since 1.0.0
		*/
		function hgr_taxonomies() {
			register_taxonomy(
				'portfolio-category',
				array('hgr_portfolio'),
				array(
					'hierarchical'	=>	true,
					'label'			=>	__( 'Categories','hgr_lang' ),
					'rewrite'		=>	array( 'slug' => 'portfolio-category' ),
				)
			);
		}
		
		
		/**
		*	hgr_testimonials shortcode function
		*	@since 1.0.0
		*/
		function hgr_testimonials_shortcode ($atts) {
			/*
				 Empty vars declaration
			*/
			$output = 
			$carousel_content = 
			$all_testimonials_content = 
			$carousel_testimonials_number = 
			$carousel_bg_color = 
			$carousel_bottom_bar_color = 
			$testimonial_text_color = 
			$testimonial_name_color = 
			$testimonial_company_position_color = 
			$testimonial_viewall_bg_color = 
			$extra_class = '';
			
			$validPosts = array();
			$this_post = array();
			$id_pot = array();
			$i = 1;
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'carousel_testimonials_number'			=>	'3', 
				'carousel_bg_color'						=>	'#dd6a6a',
				'carousel_bottom_bar_color'				=>	'#dd3333',
				'testimonial_text_color'				=>	'#ffffff',
				'testimonial_name_color'				=>	'#262626',
				'testimonial_company_position_color'	=>	'#777777',
				'testimonial_viewall_bg_color'			=>	'#dd3333',
				'extra_class'							=>	'',
			), $atts));
			
			$args = array(
				   'post_type'			=>	'hgr_testimonials',
				   'posts_per_page'		=>	get_option('posts_per_page'),
				 );
			$hgr_query = new WP_Query($args);

			if( $hgr_query->have_posts() ) {
				/*
					We add JS only if there are some posts to display
				*/
				wp_enqueue_script( 'theshop-masonry' );
				wp_enqueue_script( 'theshop-flexslider' );
				wp_enqueue_script( 'theshop-testimonials' );
				wp_enqueue_style( 'theshop-testimonials-style' );
				
				$output .='<style>
				.cd-testimonials-all p {background: '.$testimonial_viewall_bg_color.';}
				.cd-testimonials-all p {color:'.$testimonial_text_color.';}
				.cd-testimonials-all p::after {border: 8px solid transparent; border-top-color: '.$testimonial_viewall_bg_color.';}
				</style>';
				
				while ( $hgr_query->have_posts() ) {
						$hgr_query->the_post();
						
						$src				=	wp_get_attachment_image_src( get_post_thumbnail_id(), array( 5600,1000 ), false, '' );
						$hgr_testi_author	=	get_post_meta( get_the_ID(), '_hgr_testi_author', true );
						$hgr_testi_position	=	get_post_meta( get_the_ID(), '_hgr_testi_role', true );
						
						if( $i <= $carousel_testimonials_number ) {
							$carousel_content .='<li>
										'.HGR_XTND::hgr_xtnd_getPostContent().'
										<div class="cd-author">
											<img src="'.$src[0].'" alt="'.get_the_title().'">
											<ul class="cd-author-info">
												<li style="color:'.$testimonial_name_color.'">'.$hgr_testi_author	.'</li>
												<li style="color:'.$testimonial_company_position_color.'">'.$hgr_testi_position.'</li>
											</ul>
										</div>
									</li>';
							$i++;
						}
						
						
						$all_testimonials_content .='<li class="cd-testimonials-item">
								'.HGR_XTND::hgr_xtnd_getPostContent().'
								<div class="cd-author">
									<img src="'.$src[0].'" alt="'.get_the_title().'">
									<ul class="cd-author-info">
										<li>'.$hgr_testi_author	.'</li>
										<li>'.$hgr_testi_position.'</li>
									</ul>
								</div> <!-- cd-author -->
							</li>';
				}
				wp_reset_postdata();	
				
				$output .='<div class="cd-testimonials-wrapper cd-container" style="background-color:'.$carousel_bg_color.'">
							<ul class="cd-testimonials" style="color:'.$testimonial_text_color.'">';
				$output .= $carousel_content;
				$output .='</ul> <!-- cd-testimonials -->
						<a href="#0" class="cd-see-all" style="background-color:'.$carousel_bottom_bar_color.'; color:'.$testimonial_text_color.'">See all</a>
					</div> <!-- cd-testimonials-wrapper -->';
					
				$output .='<div class="cd-testimonials-all">
					<div class="cd-testimonials-all-wrapper">
						<ul>';
				$output .= $all_testimonials_content;
				$output .='</ul>
					</div>	<!-- cd-testimonials-all-wrapper -->
				
					<a href="#0" class="close-btn">Close</a>
				</div> <!-- cd-testimonials-all -->';
				
			} else {
				$output .=	'<div class="hgr_testimonials" data-fetch="'.$carousel_testimonials_number.'">';
				$output .=	'<p>'.__('No testimonials to display. Please add some testimonials!', 'hgr_lang').'</p>';
				$output .=	'</div>';
			}
								
			return $output;
		}
		
		
		/*
		*	Visual Composer mapping function
		*	Public API
		*	Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
		*	Example:	http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*	@since 1.0.0
		*/
		function hgr_testimonials_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Testimonials",'hgr_lang'),
					   "holder"				=>	"div",
					   "base"				=>	"hgr_testimonials",
					   "class"				=>	"",
					   "icon"				=>	"hgr_testimonials",
					   "category"			=>	__("HighGrade Extender",'hgr_lang'),
					   "description"		=>	__("Testimonials displayed as carousel with a modal view-all option.","hgr_lang"),
					   "content_element"	=>	true,
					   "params"				=>	array(
								array(
									"type"			=>	"textfield",
									"class"			=>	"",
									"heading"		=>	__("How many testimonials to display in carousel?", "hgr_lang"),
									"param_name"	=>	"carousel_testimonials_number",
									"value"			=>	"",
									"description"	=>	__("Enter the desired number of testimonials to display in carousel. Recomended: 6", "hgr_lang"),
									"save_always" 	=>	true,				
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Carousel background color", "hgr_lang"),
									"param_name"	=>	"carousel_bg_color",
									"value"			=>	"",
									"save_always" 	=>	true,			
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Carousel bottom bar color", "hgr_lang"),
									"param_name"	=>	"carousel_bottom_bar_color",
									"value"			=>	"",
									"save_always" 	=>	true,		
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Testimonial text color", "hgr_lang"),
									"param_name"	=>	"testimonial_text_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Testimonial name color", "hgr_lang"),
									"param_name"	=>	"testimonial_name_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Testimonial company & position color", "hgr_lang"),
									"param_name"	=>	"testimonial_company_position_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Testimonial background color on view all page", "hgr_lang"),
									"param_name"	=>	"testimonial_viewall_bg_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"textfield",
									"class"			=>	"",
									"heading"		=>	__("Extra class", "hgr_lang"),
									"param_name"	=>	"extra_class",
									"value"			=>	"",
									"description"	=>	__("Extra CSS class for custom CSS", "hgr_lang")	,
									"save_always" 	=>	true,		
								),
					   )
					) 
				);
			}
		}
		
		
		/**
		*	Add testimonials metaboxes function
		*	@since 1.0.0
		*/	
		function hgr_testimonials_metaboxes() {
				add_meta_box(
					'hgr_testimetaboxid',
					__( 'Testimonial details', 'hgr_lang' ),
					array($this,'hgr_testimonial_custom_box'),
					'hgr_testimonials'
				);
		}
		function hgr_testimonial_custom_box( $post ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'sage_testi_custom_box', 'sage_testi_custom_box_nonce' );
	
			// Get metaboxes values from database
			$hgr_testi_author			=	get_post_meta( $post->ID, '_hgr_testi_author', true );
			$hgr_testi_role				=	get_post_meta( $post->ID, '_hgr_testi_role', true );
			
			// Construct the metaboxes and print out
			
			// Testimonial author name
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="testi_author" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Testimonial author", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="testi_author" name="testi_author" value="' . esc_attr( $hgr_testi_author ) . '" size="25" placeholder="Jon Doe" /></div>';
		  
			// Testimonial author company and job
			echo '<div class="settBlock" style="margin-bottom:15px"><label for="testi_role" style="width:170px;display:inline-block;height:30px;">';
			   esc_html_e( "Company and Position", 'hgr_lang' );
			echo '</label> ';
			echo '<input type="text" id="testi_role" name="testi_role" value="' . esc_attr( $hgr_testi_role ) . '" size="25" /></div>';
		}
		function hgr_save_testimonial_data( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['sage_testi_custom_box_nonce'] ) ) {
				return $post_id;
			}
	
			$nonce = $_POST['sage_testi_custom_box_nonce'];
	
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'sage_testi_custom_box' ) ) {
				return $post_id;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			// Check the user's permissions.
			if ( 'hgr_testimonials' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}
			
			// OK to save data
			// Sanitize user input
			$hgr_testi_author	= sanitize_text_field( $_POST['testi_author'] );
			$hgr_testi_role		= sanitize_text_field( $_POST['testi_role'] );
	
			
			// Update the meta field in the database
			update_post_meta( $post_id, '_hgr_testi_author',		$hgr_testi_author );
			update_post_meta( $post_id, '_hgr_testi_role',	$hgr_testi_role );
		}
		
		
		
		/**
		*	Metabox for parent page
		*	Choose scroll type: OnePageScroll OR PageSectionEffect
		*	@since 1.2.0
		*/
		/*function hgr_parent_metabox() {
				add_meta_box(
					'hgr_parentboxid',
					__( 'One Page Scroll Type', 'hgr_lang' ),
					array($this,'hgr_parent_custom_metabox'),
					'page',
					'side'
				);
		}
		function hgr_parent_custom_metabox( $post ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( 'hatch_parent_custom_box', 'hatch_parent_custom_box_nonce' );
	
			// Get metaboxes values from database
			$one_page_scroll_type	=	get_post_meta( $post->ID, '_one_page_scroll_type', true );
			$return					=	'';
			
			// Construct the metaboxes and print out
			
			// Testimonial author name
			$return .= '<div class="settBlock">';
			
			$return .= '<label for="one_page_scroll_type" style="width:170px;display:inline-block;">'.esc_html__( "One Page Scroll Type", 'hatch' ).'</label>';
			
			switch($one_page_scroll_type){
				case 'scaledown_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll" selected="selected">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'gallery_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll" selected="selected">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'catch_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll" selected="selected">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'rotate_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll" selected="selected">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'opacity_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll" selected="selected">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'fixed_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll" selected="selected">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
				
				case 'parallax_scroll':
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll" selected="selected">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
				break;
	
				default:
					$return .= '<select name="one_page_scroll_type" id="one_page_scroll_type">
					<option value="normal_scroll" name="normal_scroll" selected="selected">'.esc_html__('Normal Scroll', 'hatch').'</option>
					<option value="scaledown_scroll" name="scaledown_scroll">'.esc_html__('Scale Down', 'hatch').'</option>
					<option value="gallery_scroll" name="gallery_scroll">'.esc_html__('Gallery', 'hatch').'</option>
					<option value="catch_scroll" name="catch_scroll">'.esc_html__('Catch', 'hatch').'</option>
					<option value="rotate_scroll" name="rotate_scroll">'.esc_html__('Rotate', 'hatch').'</option>
					<option value="opacity_scroll" name="opacity_scroll">'.esc_html__('Opacity', 'hatch').'</option>
					<option value="fixed_scroll" name="fixed_scroll">'.esc_html__('Fixed', 'hatch').'</option>
					<option value="parallax_scroll" name="parallax_scroll">'.esc_html__('Parallax', 'hatch').'</option>
					</select></div>';
			}
		  
	
			
			//if( $this->is_parent($post->ID) ) {
				echo $return;
			//}
		}
		function hgr_save_parent_metabox_data( $post_id ) {
			// Check if our nonce is set.
			if ( ! isset( $_POST['hatch_parent_custom_box_nonce'] ) ) {
				return $post_id;
			}
	
			$nonce = $_POST['hatch_parent_custom_box_nonce'];
	
			// Verify that the nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'hatch_parent_custom_box' ) ) {
				return $post_id;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			// Check the user's permissions.
			if ( 'page' == $_POST['post_type'] && $this->is_parent($post_id)) {
				if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}
			
			// OK to save data
			// Sanitize user input
			$one_page_scroll_type	= sanitize_text_field( $_POST['one_page_scroll_type'] );
	
			
			// Update the meta field in the database
			update_post_meta( $post_id, '_one_page_scroll_type',		$one_page_scroll_type );
		}*/
		
		
		
		
		
		/**
		*	Is it Parent or is it Child?
		*	@since 1.2.0
		*/
		/*function is_parent($pid) {      // $pid = The ID of the page we're looking for pages underneath
				global $post;         // load details about this page
				if(is_page()&&($post->post_parent==$pid||is_page($pid)))
					   return true;   // we're at the page or at a sub page
				else
					   return false;  // we're elsewhere
		}*/
		
		
		
		/**
		*	woo_shop_page shortcode function
		*	@since 1.3.0
		*/
		function woo_shop_page_shortcode ($atts ) {
			/*
				 Empty vars declaration
			*/
			$output = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'link_text'	=>	__('Go to shop', 'hgr_lang'), 
				'class'		=>	'', 
				'color'		=>	'', 
			), $atts));
			
			if( empty($color) ) {
				$style = "";
			} else {
				$style = " style=\"color:".$color.";\" ";
			}
			
			if( class_exists("WooCommerce") ) {
				return '<a href="'.esc_url(get_permalink( woocommerce_get_page_id( 'shop' ) )).'" title="'.$link_text.'" class="'.$class.'" '.$style.'>'.$link_text.'</a>';
			} else {
				return '<a href="'.esc_url( home_url( '/' ) ).'" title="'.$link_text.'" class="'.$class.'" '.$style.'>'.$link_text.'</a>';
			}
		}
		
		
		
		/*
		*	Full Screen Search
		*	Hooked into wp_footer (see constructor function above)
		*	@since 1.0.0
		*/
		function do_fssearch(){
			
			$hgr_options = get_option( 'redux_options' );
			
			$only_products = ( is_array($hgr_options) && isset( $hgr_options['enable_fssearch_onlu_for_products'] ) && $hgr_options['enable_fssearch_onlu_for_products'] == 1 ? '<input type="hidden" value="product" name="post_type"></input>' : '' );
			
				
			$output = '<div id="fssearch_container" class="hidden">';
				$output .= '<a class="close-btn" href="#0">Close</a><span class="fssearch_tip">'.esc_attr( "Type and hit enter", 'hgr_lang' ).'</span>';
				$output .= '<form role="search" method="get" id="searchform" class="searchform" action="'.esc_url( home_url( '/' ) ).'">
							<div>
								<input type="text" value="'.get_search_query().'" name="s" id="s" class="fssearch_input" autocomplete="off" spellcheck="false" />
								'.$only_products.'
								<input type="submit" id="searchsubmit" value="Search" class="fssearch_submit" />
							</div>
						</form>';
			$output .= '</div><!-- fssearch_container END -->';
			echo $output;
		}
		
		
		/*
		*	Register necessary js and css files on frontend
		*/
		function hgr_front_scripts(){
			
			// Testimonials files
			wp_register_script('theshop-masonry',$this->js_dir.'masonry.pkgd.min.js', array('jquery'), '' );
			wp_register_script('theshop-flexslider',$this->js_dir.'jquery.flexslider-min.js', array('jquery'), '');
			wp_register_script('theshop-testimonials',$this->js_dir.'testimonials.js', array('jquery'), '');
			wp_register_style('theshop-testimonials-style',$this->css_dir.'testimonials.css', '', '' );
			// HGR Essentials
			wp_register_script('theshop-hgr-essentials',$this->js_dir.'hgr_essentials.js', array('jquery'), '', true);
			wp_enqueue_script( 'theshop-hgr-essentials' );
			wp_register_style('theshop-essentials-style',$this->css_dir.'hgr_essentials.css', '', '' );
			wp_enqueue_style( 'theshop-essentials-style' );
		}
	}	
	/*
	*	All good, fire up the plugin :)
	*/
	new HGR_ESSENTIALS;
}