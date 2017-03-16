<?php
/*
 * @package Hatch Wordpress Theme by HighGrade
 * @since version 1.0
 */
 
 // Enqueue CSS and JS script to frontend header and footer
 if( !function_exists('hatch_enqueue') ) {
	function hatch_enqueue() {
		// Include framework glogal
		//global $redux_options;
		$hgr_options = get_option( 'redux_options' );
		
		// CSS
		wp_enqueue_style( 'hatch_css_bootstrap', 				
			trailingslashit( get_template_directory_uri() ) . 'highgrade/css/bootstrap.min.css', 
			'', 
			''
		);
		wp_enqueue_style( 'hatch_icons', 					
			trailingslashit( get_template_directory_uri() ) . 'highgrade/css/icons.css', 
			'', 
			''
		);
		
		wp_enqueue_style( 'hatch_fontawesome', 			
			trailingslashit( get_template_directory_uri() ) . 'highgrade/css/font-awesome.min.css', 
			'', 
			''
		);
		wp_enqueue_style( 'hatch_css_component', 				
			trailingslashit( get_template_directory_uri() ) . 'highgrade/css/component.css', 
			'', 
			''
		);
		
		wp_enqueue_style( 'hatch_venobox', 				
			trailingslashit( get_template_directory_uri() ) . 'highgrade/css/venobox.css', 
			'', 
			''
		);		
		
		wp_enqueue_style( 'hatch_style', get_stylesheet_uri() );
		
		wp_deregister_script( 'jquery-cookie' );
		wp_enqueue_script(	'hatch_jquery_cookie', 
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/jcookie.js', 
			array(), 
			'', 
			true 
		);
				
		// JS
		wp_enqueue_script( 'hatch_bootstrap_min',				
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/bootstrap.min.js', 
			array('jquery'), 
			'',
			true 
		);
		
		wp_enqueue_script( 'hatch_imagesloaded',			
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/imagesloaded.js', 
			array(), 
			'',
			true 
		);
		
		wp_enqueue_script( 'isotope' ); 					// registered and included from VC
		wp_enqueue_script( 'waypoints' ); 				// registered and included from VC
		
		wp_enqueue_script( 'hatch_modernizr_custom',		
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/modernizr.custom.js', 
			array(), 
			'',
			false 
		);
		
		wp_enqueue_script( 'hatch_venobox',				
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/venobox.min.js', 
			array(), 
			'',
			true 
		);
		
		wp_enqueue_script( 'hatch_colors',					
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/jquery.animate-colors-min.js', 
			array(), 
			'', 
			true 
		);
		
		wp_enqueue_script( 'hatch_velocity', 
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/velocity.min.js', 
			array(), 
			'', 
			true 
		); 
		
		
		
		if( is_array($hgr_options) && isset( $hgr_options['enable_smooth_scroll'] ) && $hgr_options['enable_smooth_scroll'] == 1 ) {
			wp_enqueue_script(	'hatch_smoothscroll', 
				trailingslashit( get_template_directory_uri() ) . 'highgrade/js/smoothscroll.js', 
				array(), 
				'', 
				true 
			);
		}
		
		wp_enqueue_script(	'hatch_js', 
			trailingslashit( get_template_directory_uri() ) . 'highgrade/js/app.js', 
			array(), 
			'', 
			true 
		);
		
		
		// Visual composer - move styles to head
		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_style( 'js_composer_custom_css' );

	}
 }
 add_action( 'wp_enqueue_scripts', 'hatch_enqueue' );
 
 

 
 
 

 // REQUIRED
 // Setup $content_width
 if ( ! isset( $content_width ) ) {$content_width = 1180;}
 
 
	
 // Custom pagination for posts
 if( !function_exists('hatch_pagination') ) {
	function hatch_pagination( $args = '' ) {
		$defaults = array(
			'before' => '<p id="post-pagination">' . esc_html__( 'Pages:', 'hatch' ), 
			'after' => '</p>',
			'text_before' => '',
			'text_after' => '',
			'next_or_number' => 'number', 
			'nextpagelink' => esc_html__( 'Next page', 'hatch' ),
			'previouspagelink' => esc_html__( 'Previous page', 'hatch' ),
			'pagelink' => '%',
			'echo' => 0
		);
	
		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );
	
		global $page, $numpages, $multipage, $more, $pagenow;
	
		$output = '';
		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= '<li>';
						$output .= _wp_link_page( $i );
					}
					else {
						$output .= '<li class="active">';
						$output .= _wp_link_page( $i );
					}
	
					$output .= $j;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= '</a>';
						$output .= '</li>';
					}
					else {
						$output .= '</a>';
						$output .= '</li>';
					}
				}
				$output .= $after;
			} else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
		}
		if ( $echo )
			echo esc_html($output);
		return $output;
	}
 }
 
 
 // Include Mobile detect class
 @require_once( trailingslashit( get_template_directory() ) . 'highgrade/Mobile_Detect.php' );
 
 
/*
*	Custom hooks
*/
function hatch_after_body_open(){ do_action( 'hatch_after_body_open' ); }
function hatch_before_footer_open(){ do_action( 'hatch_before_footer_open' ); }
 
 
 
 
 /**
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
// Include the TGM_Plugin_Activation class
	require_once( trailingslashit( get_template_directory() ) . 'highgrade/plugins/class-tgm-plugin-activation.php' );
	add_action( 'tgmpa_register', 'hatch_register_required_plugins' );


// Register the required / recommended plugins for theme
 if( !function_exists('hatch_register_required_plugins') ) {
		function hatch_register_required_plugins() {
		$plugins = array(
			// Visual Composer
			array(
				'name'     				=> esc_html__( 'WPBakery Visual Composer', 'hatch' ), // The plugin name
				'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/js_composer.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
				'is_callable'       		=> '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
			// Revolution Slider
			array(
				'name'     				=> esc_html__( 'Revolution Slider', 'hatch'),
				'slug'     				=> 'revslider',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/revslider.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			// Essential Grid
			array(
				'name'     				=> esc_html__( 'Essential Grid', 'hatch'),
				'slug'     				=> 'essential-grid',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/essential-grid.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			// HighGrade Extender for Visual Composer
			array(
				'name'     				=> esc_html__( 'HighGrade Extender for Visual Composer', 'hatch'),
				'slug'     				=> 'hgr_vc_extender',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_vc_extender.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			// HGR Custom Post Types
			array(
				'name'     				=> esc_html__( 'HGR Essentials', 'hatch'),
				'slug'     				=> 'hgr_essentials',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_essentials.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			// HGR MegaHeader
			array(
				'name'     				=> esc_html__( 'HGR MegaHeader', 'hatch'),
				'slug'     				=> 'hgr_megaheader',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_megaheader.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			array(
				'name'     				=> esc_html__( 'HGR InfoBars', 'hatch'),
				'slug'     				=> 'hgr_info_bars',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_info_bars.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			array(
				'name'     				=> esc_html__( 'HGR Popups', 'hatch'),
				'slug'     				=> 'hgr_popups',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_popups.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			array(
				'name'     				=> esc_html__( 'HGR SlideIn Panel', 'hatch'),
				'slug'     				=> 'hgr_slide_in_panel',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_slide_in_panel.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			array(
				'name'     				=> esc_html__( 'HGR QuickCartView', 'hatch'),
				'slug'     				=> 'hgr_qcv',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/hgr_qcv.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			array(
				'name'     				=> esc_html__( 'WooCommerce', 'hatch'),
				'slug'     				=> 'woocommerce',
				'source'   				=> trailingslashit( get_template_directory() ) . 'highgrade/plugins/woocommerce.2.6.4.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> true,
				'external_url' 			=> '',
				'is_callable'       		=> '',
			),
			
			
			
			// Contact Form 7
			array(
				'name' 		=> esc_html__( 'Contact Form 7', 'hatch'),
				'slug' 		=> 'contact-form-7',
				'required'	=> false,
			),
		);
			
		/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'hatch',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'cast' ),
			'menu_title'                      => __( 'Install Plugins', 'cast' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'cast' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'cast' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'cast' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'cast'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'cast'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'cast'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'cast'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'cast'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'cast'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'cast'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'cast'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'cast'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'cast' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'cast' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'cast' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'cast' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'cast' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'cast' ),
			'dismiss'                         => __( 'Dismiss this notice', 'cast' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'cast' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'cast' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);
    
        tgmpa( $plugins, $config );
	 }
 }
 

$hgr_options = get_option( 'redux_options' );
if( is_array($hgr_options) && isset( $hgr_options['enable_full_screen_search'] ) && $hgr_options['enable_full_screen_search'] == 1 ) {
	add_filter('wp_nav_menu_items','hatch_add_search_box_to_menu', 10, 2);
	function hatch_add_search_box_to_menu( $items, $args ) {
		if( $args->theme_location == 'header-menu' || $args->theme_location == 'right-menu' )
			return $items."<li><a target=\"_blank\" href=\"https://www.linkedin.com/company/ovc-automation-limited\"><i class=\"linkedin-blue\"></i></a></li>";
	
		return $items;
	}
}

function hatch_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'hatch_add_editor_styles' );
 
 
 // Some basic setup after theme setup
 add_action( 'after_setup_theme', 'hatch_theme_setup' );
 function hatch_theme_setup(){
	// Add theme support for featured image, menus, etc
	if ( function_exists( 'add_theme_support' ) ) { 
			$hgr_defaults = array(
				'default-image'          => '',
				'random-default'         => false,
				'width'                  => 2560,
				'height'                 => 1440,
				'flex-height'            => true,
				'flex-width'             => true,
				'default-text-color'     => '#fff',
				'header-text'            => false,
				'uploads'                => true,
				'wp-head-callback'       => '',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
			);
		add_theme_support( 'custom-header', $hgr_defaults );
		
		$args = array(
			'default-color'          => '',
			'default-image'          => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
		
		add_theme_support( "custom-background", $args );
		
		// Add theme support for featured image
		add_theme_support( 'post-thumbnails', array( 'post','hgr_portfolio','hgr_testimonials' ) );
		
		// Add theme support for feed links
		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( 'title-tag' );
		
		// Add theme support for woocommerce
		add_theme_support( 'woocommerce' );
		
		// Add theme support for menus
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
				  'header-menu'	=> esc_html__( 'Main Menu', 'hatch' ),
				  'left-menu'	=> esc_html__( 'Left Menu', 'hatch' ),
				  'right-menu'	=> esc_html__( 'Right Menu', 'hatch' ),
				)
			);
		}

	 }
	 
	// Enable Visual Composer on desired post types
	// and disable front end editor
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if( is_plugin_active( 'js_composer/js_composer.php' ) ) {
		// disable front end editor
		if( function_exists('vc_disable_frontend') ) {
			vc_disable_frontend();
		}
	}
	 
	// Add multilanguage support
	load_theme_textdomain( 'hatch', get_template_directory() . '/highgrade/languages' );
	
	 function hgr_widgets_init() {
		if ( function_exists('register_sidebar') ) {
			register_sidebar(array(	'name'			=>	esc_html__( 'Blog', 'hatch'),
									'id'			=>	'blog-widgets',
									'description'	=>	esc_html__( 'Widgets in this area will be shown into the blog sidebar.', 'hatch'),
									'before_widget' =>	'<div class="col-md-12 blog_widget">',
									'after_widget'	=>	'</div>',
									'before_title'	=>	'<h4>',
									'after_title'	=>	'</h4>',
								)
						);
					
			register_sidebar(array(	'name'			=>	esc_html__('Reservations', 'hatch'),
									'id'			=>	'reservations-widgets',
									'description'	=>	esc_html__( 'Only use this sidebar for reservations widgets.', 'hatch'),
									'before_widget' =>	'<div class="col-md-12 blog_widget">',
									'after_widget'	=>	'</div>',
									'before_title'	=>	'<h4>',
									'after_title'	=>	'</h4>',
								)
						);
		}
	 }
	 add_action( 'widgets_init', 'hgr_widgets_init' );
	 
	 
	 	$hgr_options = get_option( 'redux_options' );
		if( $hgr_options && !is_array($hgr_options) ){
			delete_option('redux_options');
		}
	
	
		setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
		setcookie('vchideactivationmsg_vc11', (defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1'), strtotime('+3 years'), '/');
 }
 
 
 // Some basic setup after theme change
add_action('after_switch_theme', 'hatch_theme_change');
function hatch_theme_change () {
	
	$hgr_options = get_option( 'redux_options' );
	if( $hgr_options && !is_array($hgr_options) ){
		delete_option('redux_options');
	}
	
	
	if ( class_exists( 'Redux' ) ) {
		global $wp_filesystem;
        $json_file = $wp_filesystem->get_contents( trailingslashit( get_template_directory() ).'highgrade/hgr_oci/demo_files/themeOptions/agency.json');
		if( $json_file ){
			update_option( 'redux_options', json_decode($json_file, true), '', 'yes' );
		}
    }
}



add_action('switch_theme', 'hatch_theme_deactivated');
function hatch_theme_deactivated () {
  delete_option('redux_options');
}
 
  if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function hatch_slug_render_title() {
 ?>
 <title><?php wp_title( '|', true, 'right' ); ?></title>
 <?php
    }
    add_action( 'wp_head', 'hatch_slug_render_title' );
 endif;

	
 // Portfolio Metaboxes	
	function hatch_portfoliometaboxes() {
    	$screens = array( 'hgr_testimonials' );
    	foreach ( $screens as $screen ) {
       		add_meta_box(
           	'hgr_testimetaboxid',
            	esc_html__( 'Testimonial details', 'hatch' ),
            	'hatch_testi_custom_box',
            	$screen
        	);
    	}
	}
	add_action( 'add_meta_boxes', 'hatch_portfoliometaboxes' );
	function hatch_testi_custom_box($post) {
		// Add an nonce field so we can check for it later
		wp_nonce_field( 'hatch_testi_custom_box', 'hatch_testi_custom_box_nonce' );

		// Get metaboxes values from database
		$hgr_testi_author			=	get_post_meta( $post->ID, '_hgr_testi_author', true );
		$hgr_testi_role				=	get_post_meta( $post->ID, '_hgr_testi_role', true );
		
		// Construct the metaboxes and print out
		
		// Testimonial author name
		echo '<div class="settBlock"><label for="testi_author">';
		   esc_html_e( "Testimonial author", 'hatch' );
		echo '</label> ';
		echo '<input type="text" id="testi_author" name="testi_author" value="' . esc_attr( $hgr_testi_author ) . '" size="25" placeholder="' . esc_html__( "Jon Doe", "hatch" ) . '" /></div>';
	  
	  	// Testimonial author company and job
	  	echo '<div class="settBlock"><label for="testi_role">';
		   esc_html_e( "Company and Position", 'hatch' );
		echo '</label> ';
	  	echo '<input type="text" id="testi_role" name="testi_role" value="' . esc_attr( $hgr_testi_role ) . '" size="25" /></div>';
	}
	function hatch_save_testidata( $post_id ) {
		
		// Check the user's permissions.
		if ( isset($_POST['post_type']) && $_POST['post_type'] == 'hgr_testimonials' ) {
		
			if ( ! current_user_can( 'edit_post', $post_id ) || ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
			
			
			// Verify that the nonce is set and valid
			if ( !isset( $_POST['hatch_testi_custom_box_nonce'] ) && ! wp_verify_nonce( $_POST['hatch_testi_custom_box_nonce'] ) ) {
				return;
			}
	
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			
			// OK to save data
			// Update the meta field in the database		
			if ( empty( $_POST['testi_author'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_testi_author', true ) ) {
					delete_post_meta( $post_id, '_hgr_testi_author' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_testi_author', sanitize_text_field( $_POST['testi_author'] ) );
			}
			
			if ( empty( $_POST['testi_role'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_testi_role', true ) ) {
					delete_post_meta( $post_id, '_hgr_testi_role' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_testi_role', sanitize_text_field( $_POST['testi_role'] ) );
			}
		}
	}
	add_action( 'save_post', 'hatch_save_testidata' );
	
	

 
 // Pages Metaboxes
	// Generate the metabox
	function hatch_metaboxes() {
    	$screens = array( 'page' );
    	foreach ( $screens as $screen ) {
       		add_meta_box(
           	'hgr_metaboxid',
            	esc_html__( 'Page settings', 'hatch' ),
            	'hatch_inner_custom_box',
            	$screen
        	);
    	}
	}
	add_action( 'add_meta_boxes', 'hatch_metaboxes' );
	// Print the box content
	function hatch_inner_custom_box($post) {
		// Add an nonce field so we can check for it later
		wp_nonce_field( 'hatch_inner_custom_box', 'hatch_inner_custom_box_nonce' );

		// Get metaboxes values from database
		$hgr_page_bgcolor			=	get_post_meta( $post->ID, '_hgr_page_bgcolor', true );
		$hgr_page_top_padding		=	get_post_meta( $post->ID, '_hgr_page_top_padding', true );
		$hgr_page_btm_padding		=	get_post_meta( $post->ID, '_hgr_page_btm_padding', true );
		$hgr_page_color_scheme		=	get_post_meta( $post->ID, '_hgr_page_color_scheme', true );
		$hgr_page_height			=	get_post_meta( $post->ID, '_hgr_page_height', true );
		
		// Construct the metaboxes and print out
		// Page color scheme
		echo '<div class="settBlock"><label for="page_color_scheme">';
		   esc_html_e( "Page color scheme", 'hatch' );
		echo '</label> ';
		if($hgr_page_color_scheme == 'dark_scheme'){
			echo '<select name="page_color_scheme" id="page_color_scheme"><option value="dark_scheme" name="dark_scheme" selected="selected">'.esc_html__('Dark scheme', 'hatch').'</option><option value="light_scheme" name="light_scheme">'.esc_html__('Light scheme', 'hatch').'</option></select></div>';
		}
		elseif($hgr_page_color_scheme == 'light_scheme'){
			echo '<select name="page_color_scheme" id="page_color_scheme"><option value="dark_scheme" name="dark_scheme">'.esc_html__('Dark scheme', 'hatch').'</option><option value="light_scheme" name="light_scheme" selected="selected">'.esc_html__('Light scheme', 'hatch').'</option></select></div>';
		}
		else{
			echo '<select name="page_color_scheme" id="page_color_scheme"><option value="light_scheme" name="light_scheme" selected="selected">'.esc_html__('Light scheme', 'hatch').'</option><option value="dark_scheme" name="dark_scheme">'.esc_html__('Dark scheme', 'hatch').'</option></select></div>';
		}
		
		// Page background color
		echo '<div class="settBlock"><label for="page_bgcolor">';
		   esc_html_e( "Page background color", 'hatch' );
		echo '</label> ';
		echo '<input type="text" id="page_bgcolor" name="page_bgcolor" value="' . esc_attr( $hgr_page_bgcolor ) . '" size="25" placeholder="#000" /></div>';
	  
	  	// Page top padding
	  	echo '<div class="settBlock"><label for="page_top_padding">';
		   esc_html_e( "Page top padding", 'hatch' );
		echo '</label> ';
	  	echo '<input type="text" id="page_top_padding" name="page_top_padding" value="' . esc_attr( $hgr_page_top_padding ) . '" size="25" /> <em>pixels</em></div>';
	  
	  	// Page bottom padding
	  	echo '<div class="settBlock"><label for="page_btm_padding">';
		   esc_html_e( "Page bottom padding", 'hatch' );
	  	echo '</label> ';
	  	echo '<input type="text" id="page_btm_padding" name="page_btm_padding" value="' . esc_attr( $hgr_page_btm_padding ) . '" size="25" /> <em>pixels</em></div>';
		
		// Page height
	  	echo '<div class="settBlock"><label for="page_height">';
		   esc_html_e( "Page height", 'hatch' );
	  	echo '</label> ';
	  	echo '<input type="text" id="page_height" name="page_height" value="' . esc_attr( $hgr_page_height ) . '" size="25" /> <em>'.esc_html__('pixels. If not set, auto-height is set.', 'hatch').'</em></div>';
	}
	// Save the metabox data to database
	function hatch_save_postdata( $post_id ) {
		
		if( isset($_POST['post_type']) && $_POST['post_type'] == 'page' ) {
		
			// If this is an autosave, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// Check if our nonce is set and ok.
			if ( ! isset( $_POST['hatch_inner_custom_box_nonce'] ) && ! wp_verify_nonce( $_POST['hatch_inner_custom_box_nonce'] ) ) {
				return;
			}
			
	
			// Check the user's permissions.
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
			}
			
			// OK to save data
			if ( empty( $_POST['page_bgcolor'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_page_bgcolor', true ) ) {
					delete_post_meta( $post_id, '_hgr_page_bgcolor' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_page_bgcolor', sanitize_text_field( $_POST['page_bgcolor'] ) );
			}
			
			if ( empty( $_POST['page_top_padding'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_page_top_padding', true ) ) {
					delete_post_meta( $post_id, '_hgr_page_top_padding' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_page_top_padding', sanitize_text_field( $_POST['page_top_padding'] ) );
			}
			
			if ( empty( $_POST['page_btm_padding'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_page_btm_padding', true ) ) {
					delete_post_meta( $post_id, '_hgr_page_btm_padding' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_page_btm_padding', sanitize_text_field( $_POST['page_btm_padding'] ) );
			}
			
			if ( empty( $_POST['page_color_scheme'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_page_color_scheme', true ) ) {
					delete_post_meta( $post_id, '_hgr_page_color_scheme' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_page_color_scheme', sanitize_text_field( $_POST['page_color_scheme'] ) );
			}
			
			if ( empty( $_POST['page_height'] ) ) {
				if ( get_post_meta( $post_id, '_hgr_page_height', true ) ) {
					delete_post_meta( $post_id, '_hgr_page_height' );
				}
			} else {
				update_post_meta( $post_id, '_hgr_page_height', sanitize_text_field( $_POST['page_height'] ) );
			}
		}
	}
	add_action( 'save_post', 'hatch_save_postdata' );
 // END Pages Metaboxes



/**
 * LESS PHP
 *
 * @link http://leafo.net/lessphp/
 */
 
 function hatch_do_less($debug = false){
	@require_once( trailingslashit( get_template_directory() ) . 'highgrade/lessc.inc.php' );
	$hgr_options = get_option( 'redux_options' );
	$less		=	new lessc;
	if($debug == false ) { $less->setFormatter("compressed"); };
	if($debug == true ) { $less->setPreserveComments(true); };
	$options		=	'';
	
	switch($hgr_options['header_floating']){
		
		case '2': $bkaTopmenuPosition = "fixed";
		break;
		
		case '3': $bkaTopmenuPosition = "fixed";
		break;
		
		case '4': $bkaTopmenuPosition = "fixed";
		break;
		
		case '5': 
			$bkaTopmenuPosition =	"absolute";
		break;
		
		default: $bkaTopmenuPosition = "fixed";
		break;
	}
		
	
	//var_dump($hgr_options);
	$less->setVariables(array(
	  "mediaquery_screen_xs"	=>	$hgr_options['mediaquery_screen_xs'].'px',	// Default: 480
	  "mediaquery_screen_s"		=>	$hgr_options['mediaquery_screen_s'].'px', 	// Default: 640
	  "mediaquery_screen_m"		=>	$hgr_options['mediaquery_screen_m'].'px',	// Default: 768
	  "mediaquery_screen_l"		=>	$hgr_options['mediaquery_screen_l'].'px',	// Default: 980
	  "mediaquery_screen_xl"	=>	$hgr_options['mediaquery_screen_xl'].'px',	// Default: 1280
	  "mediaquery_screen_xxl"	=>	$hgr_options['mediaquery_screen_xxl'].'px',	// Default: 1280
	  
	  "container_xs"			=>	$hgr_options['container_xs']['width'],		// Default: 300
	  "container_s"				=>	$hgr_options['container_s']['width'],		// Default: 440
	  "container_m"				=>	$hgr_options['container_m']['width'], 		// Default: 600
	  "container_l"				=>	$hgr_options['container_l']['width'],		// Default: 720
	  "container_xl"			=>	$hgr_options['container_xl']['width'],		// Default: 920
	  "container_xxl"			=>	$hgr_options['container_xxl']['width'],		// Default: 1200
	  
	  "header_height"			=>	( isset($hgr_options['header_height']['height']) && !empty($hgr_options['header_height']['height']) ? $hgr_options['header_height']['height'] : '0'),
	  "header_top_padding"		=>	( isset($hgr_options['header_padding']['padding-top']) && !empty($hgr_options['header_padding']['padding-top']) ? $hgr_options['header_padding']['padding-top'] : '0'),
	  
	  // Only available for 4th case of header type: shrink after scroll
	  "header_initial_pt"		=>	( isset($hgr_options['menu_bar_padding_start']['padding-top']) && !empty($hgr_options['menu_bar_padding_start']['padding-top']) ? $hgr_options['menu_bar_padding_start']['padding-top'] : '0'),
	  "header_initial_pb"		=>	( isset($hgr_options['menu_bar_padding_start']['padding-bottom']) && !empty($hgr_options['menu_bar_padding_start']['padding-bottom']) ? $hgr_options['menu_bar_padding_start']['padding-bottom'] : '0'),
	  "header_initial_pl"		=>	( isset($hgr_options['menu_bar_padding_start']['padding-left']) && !empty($hgr_options['menu_bar_padding_start']['padding-left']) ? $hgr_options['menu_bar_padding_start']['padding-left'] : '0'),
	  "header_initial_pr"		=>	( isset($hgr_options['menu_bar_padding_start']['padding-right']) && !empty($hgr_options['menu_bar_padding_start']['padding-right']) ? $hgr_options['menu_bar_padding_start']['padding-right'] : '0'),
	  
	  "header_final_pt"			=>	( isset($hgr_options['menu_bar_padding_end']['padding-top']) && !empty($hgr_options['menu_bar_padding_end']['padding-top']) ? $hgr_options['menu_bar_padding_end']['padding-top'] : '0'),
	  "header_final_pb"			=>	( isset($hgr_options['menu_bar_padding_end']['padding-bottom']) && !empty($hgr_options['menu_bar_padding_end']['padding-bottom']) ? $hgr_options['menu_bar_padding_end']['padding-bottom'] : '0'),
	  "header_final_pl"			=>	( isset($hgr_options['menu_bar_padding_end']['padding-left']) && !empty($hgr_options['menu_bar_padding_end']['padding-left']) ? $hgr_options['menu_bar_padding_end']['padding-left'] : '0'),
	  "header_final_pr"			=>	( isset($hgr_options['menu_bar_padding_end']['padding-right']) && !empty($hgr_options['menu_bar_padding_end']['padding-right']) ? $hgr_options['menu_bar_padding_end']['padding-right'] : '0'),
	  
	  // Contact Form 7
	  "cf_input_field_roundness"=>	( isset($hgr_options['cf_input_field_roundness']['padding-top']) && !empty($hgr_options['cf_input_field_roundness']['padding-top']) ? $hgr_options['cf_input_field_roundness']['padding-top'] : '0'),
	  
	  "bkaTopmenuPosition"		=>	$bkaTopmenuPosition,
	  
	  // QCV BTNS
	  "qcv_button_cart_regular_color"		=>	$hgr_options['qcv_gtc_btn_bg_color']['regular'],
	  "qcv_button_cart_hover_color"			=>	$hgr_options['qcv_gtc_btn_bg_color']['hover'],
	  "qcv_button_checkout_regular_color"	=>	$hgr_options['qcv_chk_btn_bg_color']['regular'],
	  "qcv_button_checkout_hover_color"		=>	$hgr_options['qcv_chk_btn_bg_color']['hover'],
	  
	  "blog_ahref_color_regular"			=>	$hgr_options['blog_ahref_color']['regular'],
	  "blog_ahref_color_hover"				=>	$hgr_options['blog_ahref_color']['hover'],
	  
	  // Body border
	  "body_border_width"					=>	( isset($hgr_options['body_border_dimensions']['width']) && !empty($hgr_options['body_border_dimensions']['width']) ? $hgr_options['body_border_dimensions']['width'] : '0'),
	  
	  // back to top button
	  "back_to_top_button_width"			=>	( isset($hgr_options['back_to_top_button_dimensions']['width']) && !empty($hgr_options['back_to_top_button_dimensions']['width']) ? $hgr_options['back_to_top_button_dimensions']['width'] : '30px'),
	));
	
	
	
	$options .="
	.clearfix() {
	  &:before,
	  &:after {
		content: \" \";
		display: table;
	  }
	  &:after {
		clear: both;
	  }
	}
	.horizontal_padding(){
		/*padding: 0px 10px;  */
	}
	
	#website_boxed{
		margin: auto;
		overflow: hidden;
		width:100vw;
		max-width:100%;
	}
	
	.bkaTopmenu {
		position: @bkaTopmenuPosition;
	}
	
	a.link-curtain::before {
		border-top: 2px solid rgba(".Redux_Helpers::hex2rgba($hgr_options['theme_dominant_color'])." , 0.3);
	}
	a.link-curtain::after {
		background: rgba(".Redux_Helpers::hex2rgba($hgr_options['theme_dominant_color'])." , 0.1);
	}
	
	.dropdown-menu li a:hover{
		background-color: rgba(".Redux_Helpers::hex2rgba($hgr_options['theme_dominant_color'])." , 0.05);
	}
	
	.dropdown-menu {
		border-top: 2px solid ".$hgr_options['theme_dominant_color']." !important;
	}
	
	
	
	.wpcf7 input[type=text], 
	.wpcf7 input[type=email], 
	.wpcf7 textarea, 
	.wpcf7 input[type=submit] {
		border-radius: @cf_input_field_roundness;
	}
	
	/* QCV BTNS */
	.qcv_button_cart{background-color: @qcv_button_cart_regular_color;}
	.qcv_button_cart:hover{background-color: @qcv_button_cart_hover_color;}
	.qcv_button_checkout{background-color: @qcv_button_checkout_regular_color;}
	.qcv_button_checkout:hover{background-color: @qcv_button_checkout_hover_color;}
	
	/* BLOG COMMENTS BTN */
	#comments-form input[type=submit], #commentform input[type=submit] {
		background-color: @blog_ahref_color_regular;
	}
	#comments-form input[type=submit]:hover, #commentform input[type=submit]:hover {
		background-color: @blog_ahref_color_hover;
	}
	
	".( isset($hgr_options['body_border']) && $hgr_options['body_border'] == 'body_border_on' ? 
	"
	#hgr_left, #hgr_right {width: @body_border_width;} 
	#hgr_top, #hgr_bottom {height: @body_border_width;}
	body {margin-top: @body_border_width !important;}
	.bka_footer{margin-bottom: @body_border_width !important;}
	"
	: '')."
	
	
	".( isset($hgr_options['back_to_top_button']) && $hgr_options['back_to_top_button'] == '1' ? 
	"
	.back-to-top {
		width:@back_to_top_button_width;
		height:@back_to_top_button_width;
		line-height:@back_to_top_button_width;
	}
	"
	: '')."
	

	
	
	/*==========  START MEDIA QUERIES  ==========*/
	
	/* 
		Extra Small Screen
		Over:		0
		Under:		mediaquery_screen_xs
		Default:	480px
		Container:	container_xs
		Media:		(max-width: 480px)
	*/
	@media (max-width: @mediaquery_screen_xs - 1) {
		.container, #container{
			max-width: @container_xs;
			.clearfix;
			.horizontal_padding;
		}
		.megamenu {width:@container_xs;}
		.bka_menu .navbar-collapse.collapse{
			display: none;
			flex-direction: row;
			width: auto;
		}
		.bka_menu .navbar-collapse.collapse.in{
			display: block;
			flex-direction: row;
			width: auto;
		}
	
		#website_boxed{
			/*width: @container_xs;*/
			.clearfix;
		}
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_xs!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		
		#qcv_handle {
			position: absolute;
			top: 22px;
			right: 70px;
		}
		
		/* MAILCHIP COLLECTOR */
		#hgr_mc_name, #hgr_mc_lastname, #hgr_mc_email, .hgr_mc_btn{
			width: 100%!important;
			margin-bottom:10px!important;
		}
		
		
		/* WOOCOMMERCE */
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		.hgr_main_image{
			float:none;
			width:300px;
			margin-bottom:20px;
		}
		.hgr_product_thumbnails{
			width:300px;
			max-height:240px;
			float:none;
			overflow:hidden;
		}
		.hgr_product_thumbnails a{
			margin-right:10px;
		}
		.hgr_product_thumbnails a:last-child{
			margin-right:0;
		}
		.hgr_product_thumbnails img{
			max-width:90px!important;
			height:auto;
		}
		.woocommerce-page div.product div.summary{
			width:300px;
			height:auto;
			margin-right:auto;
			margin-left:auto;
		}
		.woocommerce-page div.product div.summary p{
			text-align:justify;
		}
		.woocommerce-page div.product .product_title{
			text-align:center;
		}
		.woocommerce div.product .woocommerce-product-rating{
			float:right;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
		}
		
		.woocommerce div.product .product_meta .posted_in{
			padding:0!important;
		}
		#tab-description{
			text-align:justify;
		}
		.woocommerce #respond input#submit{
			width:100%;
		}
		.woocommerce p.stars{
			font-size:0.9em;
		}
		.woocommerce p.stars span{
			display: block;
			text-align: center;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product{
			width:48%!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 35%;
			bottom: 125px;
		}
		/* buy btn */
		.woocommerce a.button, 
		.woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
		/*WOOCOMMERCE END*/
		
	}
	
	
	
	/* 
		Small Screen
		Over:		mediaquery_screen_xs
		Under:		mediaquery_screen_s
		Default:	640px
		Container:	container_s
		Media:		(min-width: 481px) and (max-width: 640px)
	*/
	@media (min-width: @mediaquery_screen_xs ) and (max-width: @mediaquery_screen_s - 1) {
		.container, #container{
			max-width: @container_s;
			.clearfix;
			.horizontal_padding;
		}
		.megamenu {width:@container_s;}
		.bka_menu .navbar-collapse.collapse{
			display: none;
			flex-direction: row;
			width: auto;
		}
		.bka_menu .navbar-collapse.collapse.in{
			display: block;
			flex-direction: row;
			width: auto;
		}
	
		#website_boxed{
			/*width: @container_s;*/
			.clearfix;
		}
		
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_s!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		#qcv_handle {
			position: absolute;
			top: 22px;
			right: 70px;
		}
		
		/* MAILCHIP COLLECTOR */
		#hgr_mc_name, #hgr_mc_lastname, #hgr_mc_email, .hgr_mc_btn{
			width: 100%!important;
			margin-bottom:10px!important;
		}
		
		/* WOOCOMMERCE */
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		.hgr_main_image{
			float: right;
			width: 360px;
			margin-bottom: 20px;
		}
		.hgr_product_thumbnails{
			width:70px;
			max-height:240px;
			float:left;
			overflow:hidden;
		}
		.hgr_product_thumbnails a{
			margin-right:10px;
		}
		.hgr_product_thumbnails a:last-child{
			margin-right:0;
		}
		.hgr_product_thumbnails img{
			max-width:70px!important;
			height:auto;
		}
		.woocommerce-page div.product div.summary{
			width:440px!important;
			height:auto;
			float:left!important;
		}
		.woocommerce-page div.product div.summary p{
			text-align:justify;
		}
		.woocommerce-page div.product .product_title{
			text-align:center;
		}
		.woocommerce div.product .woocommerce-product-rating{
			float:right;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
		}
		
		.woocommerce div.product .product_meta .posted_in{
			padding:0!important;
		}
		#tab-description{
			text-align:justify;
		}
		.woocommerce #respond input#submit{
			width:100%;
		}
		.woocommerce p.stars{
			font-size:0.9em;
		}
		.woocommerce p.stars span{
			display: block;
			text-align: center;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product, .woocommerce .related li.product:nth-child(2n) {
			width:32%!important;
			clear:none!important;
			margin-left: 2px;
			margin-right: 2px;
			text-align:center;
			float:left!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 37%;
			top: -12px;
		}
	
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product h3{
			/*text-align:center;*/
		}
		/* buy btn */
		.woocommerce a.button, 
		.woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
		/*WOOCOMMERCE END*/
	}
	
	
		
	/* 
		Medium Screen
		Over:		mediaquery_screen_s
		Under:		mediaquery_screen_m
		Default:	768px
		Container:	container_m
		Media:		(min-width: 641px) and (max-width: 768px)
	*/
	@media (min-width: @mediaquery_screen_s) and (max-width: @mediaquery_screen_m - 1) {
		.container, #container{
			max-width: @container_m;
			.clearfix;
			.horizontal_padding;
		}
		.megamenu {width:@container_m;}
		#website_boxed{
			/*width: @container_m;*/
			.clearfix;
		}
	
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_m!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		.initialHeaderSize{
			padding-top: @header_initial_pt;
	  		padding-bottom: @header_initial_pb;
	  		padding-left: @header_initial_pl;
	  		padding-right: @header_initial_pr;
	  
	
		}
		.finalHeaderSize{
			padding-top: @header_final_pt!important;
	  		padding-bottom: @header_final_pb!important;
	  		padding-left: @header_final_pl!important;
	  		padding-right: @header_final_pr!important;
		}
		
		
		
		/* WOOCOMMERCE */
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		.hgr_main_image{
			float: right;
			width: 470px;
			margin-bottom: 20px;
		}
		.hgr_product_thumbnails{
			width:120px;
			max-height:460px;
			float:left;
			overflow:hidden;
		}
		.hgr_product_thumbnails a{
			margin-right:10px;
		}
		.hgr_product_thumbnails a:last-child{
			margin-right:0;
		}
		.hgr_product_thumbnails img{
			max-width:120px!important;
			height:auto;
		}
		.woocommerce-page div.product div.summary{
			width:600px!important;
			height:auto;
			float:left!important;
		}
		.woocommerce-page div.product div.summary p{
			text-align:justify;
		}
		.woocommerce-page div.product .product_title{
			text-align:left;
		}
		.woocommerce div.product .woocommerce-product-rating{
			float:right;
		}
		div.quantity_select{
			width:70px!important;
			background-position:50px!important;
		}
		.woocommerce select.qty{
			width:280px!important;
		}
		.woocommerce form.cart select.qty{
			width:85px!important;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
			width:50%!important;
		}
		
		.woocommerce div.product .product_meta .posted_in{
			padding:0!important;
		}
		#tab-description{
			text-align:justify;
		}
		.woocommerce #respond input#submit{
			width:100%;
		}
		.woocommerce p.stars{
			font-size:0.9em;
		}
		.woocommerce p.stars span{
			display: block;
			text-align: center;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product{
			width:32%!important;
			clear:none!important;
			margin-left: 2px;
			margin-right: 2px;
			text-align:center;
			float:left!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 37%;
			top: -12px;
		}
	
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product h3{
			/*text-align:center;*/
		}
		/* buy btn */
		.woocommerce a.button, .woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
		/*WOOCOMMERCE END*/
			
	}
	
	
	
	/* 
		Large Screen
		Over:		mediaquery_screen_m
		Under:		mediaquery_screen_l
		Default:	980px
		Container:	container_l
		Media:		(min-width: 769px) and (max-width: 980px)
	*/
	@media (min-width: @mediaquery_screen_m) and (max-width: @mediaquery_screen_l - 1) {
		.container, #container{
			max-width: @container_l;
		}
		.megamenu {width:@container_l;}
		ul.primary_menu{
			margin-top:@header_height;
		}
		#website_boxed{
			/*width: @container_l;*/
		}
		
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_l!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		.initialHeaderSize{
			padding-top: @header_initial_pt;
	  		padding-bottom: @header_initial_pb;
	  		padding-left: @header_initial_pl;
	  		padding-right: @header_initial_pr;
	  
	
		}
		.finalHeaderSize{
			padding-top: @header_final_pt!important;
	  		padding-bottom: @header_final_pb!important;
	  		padding-left: @header_final_pl!important;
	  		padding-right: @header_final_pr!important;
		}
		
		
		/* WOOCOMMERCE */
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		.hgr_main_image{
			float: right;
			width: 500px;
			margin-bottom: 20px;
		}
		.hgr_product_thumbnails{
			width:200px;
			max-height:500px;
			float:left;
			overflow:hidden;
		}
		.hgr_product_thumbnails a{
			margin-right:10px;
		}
		.hgr_product_thumbnails a:last-child{
			margin-right:0;
		}
		.hgr_product_thumbnails img{
			max-width:200px!important;
			height:auto;
		}
		.woocommerce-page div.product div.summary{
			width:700px!important;
			height:auto;
			float:left!important;
		}
		.woocommerce-page div.product div.summary p{
			text-align:justify;
		}
		.woocommerce-page div.product .product_title{
			text-align:left;
		}
		.woocommerce div.product .woocommerce-product-rating{
			float:right;
		}
		div.quantity_select{
			width:70px!important;
			background-position:50px!important;
		}
		.woocommerce select.qty{
			width:280px!important;
		}
		.woocommerce form.cart select.qty{
			width:85px!important;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
			width:50%!important;
		}
		
		.woocommerce div.product .product_meta .posted_in{
			padding:0!important;
		}
		#tab-description{
			text-align:justify;
		}
		.woocommerce #respond input#submit{
			width:100%;
		}
		.woocommerce p.stars{
			font-size:0.9em;
		}
		.woocommerce p.stars span{
			display: block;
			text-align: center;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product{
			width:32%!important;
			clear:none!important;
			margin-left: 2px;
			margin-right: 2px;
			text-align:center;
			float:left!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 37%;
			top: -12px;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product h3{
			/*text-align:center;*/
		}
		/* buy btn */
		.woocommerce a.button, .woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
		/*WOOCOMMERCE END*/
	}	
	
	
	
	/* 
		Extra Large Screen
		Over:		mediaquery_screen_l
		Under:		mediaquery_screen_xl
		Default:	1280px
		Container:	container_xl
		Media:		(min-width: 981px) and (max-width: 1280px)
	*/
	@media (min-width: @mediaquery_screen_l) and (max-width: @mediaquery_screen_xl - 1)  {
		
		.container, #container{
			max-width: @container_xl;
		}
		.megamenu {width:@container_xl;}
		ul.primary_menu{
			line-height:@header_height;
		}
		ul.sub-menu{
			line-height:24px;
			top:@header_height - @header_top_padding - 1;
		}
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_xl!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		.initialHeaderSize{
			padding-top: @header_initial_pt;
	  		padding-bottom: @header_initial_pb;
	  		padding-left: @header_initial_pl;
	  		padding-right: @header_initial_pr;
	  
	
		}
		.finalHeaderSize{
			padding-top: @header_final_pt!important;
	  		padding-bottom: @header_final_pb!important;
	  		padding-left: @header_final_pl!important;
	  		padding-right: @header_final_pr!important;
		}
		
		
		/* WOOCOMMERCE */
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		.hgr_main_image{
			float: right;
			width: 700px;
			margin-bottom: 20px;
		}
		.hgr_product_thumbnails{
			width:200px;
			float:left;
			overflow:hidden;
		}
		.hgr_product_thumbnails a{
			margin-right:10px;
		}
		.hgr_product_thumbnails a:last-child{
			margin-right:0;
		}
		.hgr_product_thumbnails img{
			max-width:200px!important;
			height:auto;
		}
		.woocommerce-page div.product div.summary{
			width:920px!important;
			height:auto;
			float:left!important;
		}
		.woocommerce-page div.product div.summary p{
			text-align:justify;
		}
		.woocommerce-page div.product .product_title{
			text-align:left;
		}
		.woocommerce div.product .woocommerce-product-rating{
			float:right;
		}
		div.quantity_select{
			width:70px!important;
			background-position:50px!important;
		}
		.woocommerce select.qty{
			width:280px!important;
		}
		.woocommerce form.cart select.qty{
			width:70px!important;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
			width:150px!important;
			float:none;
		}
		
		.woocommerce div.product .product_meta .posted_in{
			padding:0!important;
		}
		#tab-description{
			text-align:justify;
		}
		.woocommerce #respond input#submit{
			width:50%;
			float:right;
		}
		.woocommerce p.stars{
			font-size:0.9em;
		}
		.woocommerce p.stars span{
			display: block;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product{
			width:24%!important;
			clear:none!important;
			margin-left: 2px;
			margin-right: 2px;
			text-align:center;
			float:left!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 39%;
			bottom: 125px;
		}
	
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product h3{
			/*text-align:center;*/
		}
		/* buy btn */
		.woocommerce a.button, .woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
		/*WOOCOMMERCE END*/
	}
	
	
	
	/* 
		XXL Screen
		Over:		mediaquery_screen_xl
		Under:		none
		Default:	over 1280px
		Container:	container_xxl
		Media:		min-width: 1281px
	*/
	@media (min-width: @mediaquery_screen_xl) {
		.container, #container{
			max-width: @container_xxl;
		}
		
		.megamenu {width:@container_xxl;}
	
		ul.primary_menu{
			line-height:@header_height;
		}
		ul.sub-menu{
			line-height:24px;
			top:@header_height - @header_top_padding - 1;
		}
		#website_boxed{
			/*width: @container_xxl;*/
		}
		".( isset($hgr_options['website_model']) && $hgr_options['website_model'] === 'website_boxed' ? 
		' #masthead, #website_boxed, .bka_menu {width: @container_xxl!important;} ' : ' #website_boxed{width: 100vw;max-width:100%;} ')."
		".( isset($hgr_options['enable_boxed_shadow']) && $hgr_options['enable_boxed_shadow'] == '1' ? 
		' #website_boxed  {-webkit-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);-moz-box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);box-shadow: 0px 0px 60px 0px rgba(0,0,0,0.2);} ' : '')."
		
		
		.initialHeaderSize{
			padding-top: @header_initial_pt;
	  		padding-bottom: @header_initial_pb;
	  		padding-left: @header_initial_pl;
	  		padding-right: @header_initial_pr;
	  
	
		}
		.finalHeaderSize{
			padding-top: @header_final_pt!important;
	  		padding-bottom: @header_final_pb!important;
	  		padding-left: @header_final_pl!important;
	  		padding-right: @header_final_pr!important;
		}
		
		
		/* WOOCOMMERCE */
		.hgr_product_images{
			width:960px;
			height:800px;
			float:left;
		}
		.hgr_product_summary{
			width:700px;
			height:800px;
			float:right;
		}
		.hgr_main_image{
			float:left;
			width:600px;
		}
		.hgr_main_image.has_thumbnails{
			width:480px;
		}
		.hgr_product_thumbnails{
			width:100px;
			margin-right:20px;
			max-height:800px;
			float:left;
			overflow:hidden;
		}
		.woocommerce .product span.onsale {
			top: 10px!important;
			right: 10px!important;
			left:auto!important;
		}
		div.quantity_select{
			width:70px!important;
			background-position:50px!important;
		}
		.woocommerce select.qty{
			width:280px!important;
		}
		.woocommerce form.cart select.qty{
			width:85px!important;
		}
		.woocommerce div.product form.cart .button{
			margin-top:0!important;
			width:150px!important;
			float:none;
		}
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product{
			width:24%!important;
			clear:none!important;
			margin-left: 2px;
			margin-right: 2px;
			text-align:center;
			float:left!important;
		}
		/* buy btn related products */
		.woocommerce .related ul.products li.product a, .woocommerce-page .related ul.products li.product a {
			left: 39%;
			bottom: 125px;
		}
	
		.woocommerce .related ul.products li.product, .woocommerce .related ul li.product h3{
			/*text-align:center;*/
		}
		/* buy btn */
		.woocommerce a.button, .woocommerce-page a.button{
			margin-top:0px!important;
			left: 10px!important;
			top:  10px!important;
		}
	}
	
	";
	
	// Try to return the output
	try {
    	echo '<style type="text/css">';
		echo esc_html($less->compile($options));
		echo '</style>';
	} catch (Exception $ex) {
		echo "lessphp fatal error: ".$ex->getMessage();
	}
 }



/*
*	Force Visual Composer to initialize as "built into the theme". 
*	This will hide certain tabs under the Settings->Visual Composer page
*/
	if(function_exists('vc_set_as_theme')){
	add_action( 'vc_before_init', 'hgr_vcSetAsTheme' );
	function hgr_vcSetAsTheme() {
    	vc_set_as_theme();
	}
 }



/*
*	WooCommerce: Display product atributes
*/
function hatch_woo_show_product_atributes(){
 
    global $product;
    $attributes = $product->get_attributes();
 
    if ( ! $attributes ) {
        return;
    }
 	
	
    $out = '<ul class="custom-attributes">';
 
    foreach ( $attributes as $attribute ) {
 
 
        // skip variations
        if ( $attribute['is_variation'] ) {
        continue;
        }
 
 
        if ( $attribute['is_taxonomy'] ) {
 
            $terms = wp_get_post_terms( $product->id, $attribute['name'], 'all' );
 
            // get the taxonomy
            $tax = $terms[0]->taxonomy;
 
            // get the tax object
            $tax_object = get_taxonomy($tax);
 
            // get tax label
            if ( isset ($tax_object->labels->name) ) {
                $tax_label = $tax_object->labels->name;
            } elseif ( isset( $tax_object->label ) ) {
                $tax_label = $tax_object->label;
            }
 
            foreach ( $terms as $term ) {
 
                $out .= '<li class="' . esc_attr( $attribute['name'] ) . ' ' . esc_attr( $term->slug ) . '">';
                $out .= '<span class="attribute-label">' . $tax_label . '</span> ';
                $out .= '<span class="attribute-value">' . $term->name . '</span></li>';
 
            }
 
        } else {
 
            $out .= '<li class="' . sanitize_title($attribute['name']) . ' ' . sanitize_title($attribute['value']) . '">';
            $out .= '<span class="attribute-label">' . $attribute['name'] . '</span> ';
            $out .= '<span class="attribute-value">' . $attribute['value'] . '</span></li>';
        }
    }
 
    $out .= '</ul>';
 
    echo esc_html($out);}
	


/*
* Do the custom page layout
*/
function hatch_get_layout( $page_type = 'page' ){
	$hgr_options = get_option( 'redux_options' );
	
	// Blog Specific
	if( isset($hgr_options['blog_layout']) && $page_type == 'blog') {
		require_once( trailingslashit( get_template_directory() ) . 'layouts/' . $page_type . '/' . $hgr_options['blog_layout'] . '.php' );
	}
	elseif( isset($hgr_options['content_layout']) ) {
		require_once( trailingslashit( get_template_directory() ) . 'layouts/' . $page_type . '/' . $hgr_options['content_layout'] . '.php' );
	} else {
		require_once( trailingslashit( get_template_directory() ) . 'layouts/' . $page_type . '/nosidebar.php' );
	}
}



/**
*	Header function  
*/
function hatch_do_header() {
	$hgr_options = get_option( 'redux_options' );
	
	$header_type = $hgr_options['header_floating'];
	/*
		$header_type values:
		1 - Fixed - DEFAULT
		2 - Apear after scrolling down
		3 - Dissapear after scrolling down
	*/
	$output = '';
	
	$original_header_type = $header_type;
	
	// If on mobile, header is always fixed.
	// If other page than home, header is always fixed
	$detect = new Mobile_Detect;
	if( $detect->isMobile() || $detect->isTablet() || !is_front_page() ){
		$header_type = '1';
	}
	
	
	$bkaTopmenu_lineHeight = ( isset($hgr_options['menu-font']['line-height']) && 
									$hgr_options['menu-font']['line-height'] != 'px' ? 
									$hgr_options['menu-font']['line-height']*1 : '60px');
	
	switch($header_type){
		case '2': // Apear after scrolling down
			$scroll_amount = ( isset($hgr_options['header_floating_display_after']['height']) && 
									$hgr_options['header_floating_display_after']['height'] != 'px' ? 
									$hgr_options['header_floating_display_after']['height']*1 : '$(window).height()');
			
			
			$output = '<script type="text/javascript">
				jQuery(document).ready(function($) {
					"use strict";
					
					//$(".hgr_woo_minicart").height($( ".bkaTopmenu").outerHeight(true) );
					$(".hgr_woo_minicart").height("'.$bkaTopmenu_lineHeight.'");
					
					if($(window).height() < $("body").prop("scrollHeight")) {
					
						$(".bkaTopmenu").removeClass("displayed").addClass("hidden");
						$(window).bind("scroll", function() {
								if ($(window).scrollTop() > '.$scroll_amount.') {
									$(".bkaTopmenu").slideDown(200);
									$(".bkaTopmenu").removeClass("hidden").addClass("displayed");
								}
								if ($(window).scrollTop() < '.$scroll_amount.') {
									$(".bkaTopmenu").slideUp(200, function() {
										$(".bkaTopmenu").removeClass("displayed").addClass("hidden");
									});
								}
							});
					}
				});
			</script>';
		break;
		
		case '3': // Dissapear after scrolling down
			$scroll_amount = ( isset($hgr_options['header_floating_hide_after']['height']) && 
									$hgr_options['header_floating_hide_after']['height'] != 'px' ? 
									$hgr_options['header_floating_hide_after']['height']*1 : '$(window).height()');
			
			$output = '<script type="text/javascript">
					jQuery(document).ready(function($) {
						"use strict";
						var header_height = $(".bkaTopmenu").outerHeight(true);
						var lastScrollTop = 0;
						//$("#primary").css("margin-top",header_height);
						//$("#secondary").css("margin-top",header_height);
						//$(".header_spacer").height( header_height /*+ 30*/ );
						
						$(".hgr_woo_minicart").height($( ".bkaTopmenu").outerHeight(true) );
												
						
						$(window).scroll(function(event){
						   var st = $(this).scrollTop();
						   if (st > lastScrollTop){
							   // downscroll code
							   if ($(window).scrollTop() > '.$scroll_amount.') {
									$(".bkaTopmenu").slideUp(200, function() {
										$(".bkaTopmenu").removeClass("displayed").addClass("hidden");
									});
								}
						   } else {
							  // upscroll code
							  $(".bkaTopmenu").slideDown(200);
							  $(".bkaTopmenu").removeClass("hidden").addClass("displayed");
						   }
						   lastScrollTop = st;
						});
					});
				</script>';
		break;
		
		case '4': // Shrink after scrolling down
			$scroll_amount = ( isset($hgr_options['header_shrink_after_scroll']['height']) && 
									$hgr_options['header_shrink_after_scroll']['height'] != 'px' ? 
									$hgr_options['header_shrink_after_scroll']['height']*1 : '$(window).height()');
			
			//$header_size_before_scroll = $hgr_options['header_size_before_scroll']['height'];
			//$header_size_after_scroll = $hgr_options['header_size_after_scroll']['height'];
			
			$output = '<script type="text/javascript">
					jQuery(document).ready(function($) {
						"use strict";
						var header_height = $(".bkaTopmenu").outerHeight(true);
						var lastScrollTop = 0;
						
						$(".hgr_woo_minicart").height($( ".bkaTopmenu").outerHeight(true) );
						
						$(".bkaTopmenu").addClass("initialHeaderSize");
						$(window).scroll(function(event){
						   var st = $(this).scrollTop();
						   if (st > lastScrollTop){
							   // downscroll code
							   if ($(window).scrollTop() > '.$scroll_amount.') {
									$(".bkaTopmenu").removeClass("initialHeaderSize").addClass("finalHeaderSize");
								}
						   } else if ($(window).scrollTop() < '.$scroll_amount.') {
							  // upscroll code
							  $(".bkaTopmenu").removeClass("finalHeaderSize").addClass("initialHeaderSize");
						   }
						   lastScrollTop = st;
						});
					});
				</script>';
		break;
		
		case '5': // Transparent, scrolls with page and then falls down after scrolling
		
			$scroll_amount = ( isset($hgr_options['header_transparent_display_after']['height']) && 
									$hgr_options['header_transparent_display_after']['height'] != 'px' ? 
									$hgr_options['header_transparent_display_after']['height']*1 : '$(window).height()');
			
			$afterScrollOpacity =	$hgr_options['header_transp_bg_opacity_after_scroll'];
			
			//$header_size_before_scroll = $hgr_options['header_size_before_scroll']['height'];
			$header_top_padding_after_scroll = ( isset($hgr_options['menu_bar_padding_end']['margin-top']) ? $hgr_options['menu_bar_padding_end']['margin-top'] : '0');
			
			$output = '<script type="text/javascript">
				jQuery(document).ready(function($) {
					"use strict";
					var header_height = $(".bkaTopmenu").outerHeight(true);
					var hasBeenTrigged = false;
					
					//$(".hgr_woo_minicart").height($( ".bkaTopmenu").outerHeight(true) );
					$(".hgr_woo_minicart").height("'.$bkaTopmenu_lineHeight.'");
					  
					
					// Set transparency and position for header
						
						$(".bkaTopmenu").css("background-color","rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , 0)");
					
					function doTheStickyHeader() {
						// Do we have the admin bar on?
							var adminBarHeight = ( $("body").hasClass("admin-bar") ) ? "32px" : 0;
						
						// Window scroll position Y
							var winYval = $(window).scrollTop();
						
						// Do the tricks
						if ( winYval > '.$scroll_amount.'  && !hasBeenTrigged ) {
							$(".bkaTopmenu").css("top",-header_height);
							$(".bkaTopmenu").addClass("finalHeaderSize").addClass("stickyHeader").css("background-color","rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')").animate({
								"top": adminBarHeight
							},300);
							hasBeenTrigged = true;
							
						}
						if( winYval < '.$scroll_amount.' && $(".bkaTopmenu").hasClass("stickyHeader")  && hasBeenTrigged ){
							$(".bkaTopmenu").animate({"top": -header_height}, 300, function() {
								$(".bkaTopmenu").css("top",0).removeClass("finalHeaderSize").removeClass("stickyHeader").css("display","block").css("background-color","rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , 0)");
							  });
							hasBeenTrigged = false;
						}
						
					}
					$(window).scroll(function(){
						// Do the sticky header
						doTheStickyHeader();
					});
				});
			</script>';
		break;
		
		default: // Fixed - DEFAULT
		
			$output = '<script type="text/javascript">
					jQuery(document).ready(function($) {
						"use strict";
						
						var hasBeenTrigged = false;
						var header_height = $(".bkaTopmenu").outerHeight(true);
						//$(".hgr_woo_minicart").height($( ".bkaTopmenu").outerHeight(true) );
						$(".hgr_woo_minicart").height("'.$bkaTopmenu_lineHeight.'");
						';
						
						
						if( $original_header_type != 1 && $header_type == 1 ) {
							$output .= '$(".bkaTopmenu").addClass("finalHeaderSize").css("position", "fixed");';
						}
						
	
						if( isset(	$hgr_options['header_opacity_change_after_scroll']) && 
									$hgr_options['header_opacity_change_after_scroll'] == 1) {
							$scroll_amount_change_color = ( isset (
								$hgr_options['header_background_opacity_change_after_amount']['height']) && 
								$hgr_options['header_background_opacity_change_after_amount']['height'] != 'px' ? 
								$hgr_options['header_background_opacity_change_after_amount']['height']*1 : '$(window).height()');
													
							$initialOpacity		=	$hgr_options['header_background_rgba']['alpha'];
							$afterScrollOpacity =	$hgr_options['header_background_opacity_after_scroll'];
							
												
							$output .= '$(".dropdown-menu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);
										if ($(window).scrollTop() > '.$scroll_amount_change_color.' ) {
										$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);
										
										}';
							
							if( $original_header_type != 1 && $header_type == 1 || !is_front_page() ) {
								
								if( $detect->isMobile() || $detect->isTablet() ) {
									// If not FIXED by settings, and mobile, fixed and with background
									$output .= '$(".bkaTopmenu").removeClass("finalHeaderSize").css("position", "fixed").css("padding-top", "0px").css("padding-bottom", "0px").css("padding-left", "20px").css("padding-right", "20px");';
									$output .= '$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);';
								} else {
									$output .= '$(".bkaTopmenu").addClass("finalHeaderSize").css("position", "fixed");';
									$output .= '$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);';
								}
							} 
							// If mobile, fixed and with background
							else if( $detect->isMobile() || $detect->isTablet() ) {
								
								//$output .= '$(".bkaTopmenu").addClass("finalHeaderSize").css("position", "fixed");';
								$output .= '$(".bkaTopmenu").removeClass("finalHeaderSize").css("position", "fixed").css("padding-top", "0px").css("padding-bottom", "0px").css("padding-top", "0px").css("padding-bottom", "0px").css("padding-left", "20px").css("padding-right", "20px");';
								$output .= '$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);';
							}
							else {
								$output .= '$(window).bind("scroll", function() {
									
									if ($(window).scrollTop() > '.$scroll_amount_change_color.' && !hasBeenTrigged ) {
										$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$afterScrollOpacity.')"}, 500);
										hasBeenTrigged = true;
										
									}
									if ($(window).scrollTop() < '.$scroll_amount_change_color.' && hasBeenTrigged ) {
										$(".bkaTopmenu").animate({backgroundColor: "rgba('.Redux_Helpers::hex2rgba($hgr_options['header_background_rgba']['color']).' , '.$initialOpacity.')"}, 500);
										hasBeenTrigged = false;
										
									}
								});';
							}
								
					
						}
			
			$output .=' }); </script>';
		break;
	}
	
	wp_localize_script( 'hatch_js', 'menu_js', $output );
	
	}


 // Custom search form
 function hatch_search_form( $form ) {
    $form = '<form method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '" >
    <div>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'. esc_html__( 'Search','hatch' ) .'" />
    <input type="submit" id="searchsubmit" value="'. esc_html__( 'Search','hatch' ) .'" />
    </div>
    </form>';

    return $form;
 }
 add_filter( 'get_search_form', 'hatch_search_form' );

 
  
 
 // Include the HighGrade Framework
	if ( !class_exists( 'ReduxFramework' ) && file_exists( trailingslashit( get_template_directory() ) . 'highgrade/framework/framework.php' ) ) {
		require_once( trailingslashit( get_template_directory() ) . 'highgrade/framework/framework.php' );
	}
	if ( file_exists( trailingslashit( get_template_directory() ) . 'highgrade/config.php' ) ) {
		require_once( trailingslashit( get_template_directory() ) . 'highgrade/config.php' );
	}

// Custom CSS for Highgrade Framework admin panel
	function hatch_addAndOverridePanelCSS() {
	  wp_dequeue_style( 'redux-css' );
	  wp_register_style(
		'highgrade-css',
		get_template_directory_uri().'/highgrade/css/framework.css',
		array(),
		time(),
		'all'
	  );    
	  wp_enqueue_style('highgrade-css');
	}
	add_action( 'redux/page/hgr_options/enqueue', 'hatch_addAndOverridePanelCSS' );
	
	add_action('admin_head', 'hatch_custom_meta_css');
	function hatch_custom_meta_css() {
	  echo '<style>
		#hgr_metaboxid label {
		  display: inline-block;
		  min-width:170px;
		} 
		#hgr_metaboxid .settBlock {
		  display: block;
		  margin-bottom:5px;
		} 
		#hgr_metaboxid input[type="text"], #hgr_metaboxid select {
		  width: 120px;
		} 
	  </style>';
	}
	
	function hatch_get_post_meta_by_key($key) {
		global $wpdb;
		$vc_styles = '';
		
		$sql		=	$wpdb->prepare( "SELECT DISTINCT `meta_value` FROM $wpdb->postmeta WHERE `meta_key` = %s", $key );
		$meta		=	$wpdb->get_results( $sql );
	

		if ( !empty($meta) ) {
			$vc_styles .= '<!-- VC COMBINED STYLES --> <style type="text/css" data-type="vc-shortcodes-custom-css">';
			foreach($meta as $custom_style){
				$vc_styles .= $custom_style->meta_value;
			}
			$vc_styles .= '</style> <!-- / VC COMBINED STYLES -->';
			
			return $vc_styles;
		}
		return false;
	}
	
	
	function hatch_get_custom_css() {
		$hgr_options = get_option( 'redux_options' );
		if ( isset($hgr_options['enable_css-code']) && $hgr_options['enable_css-code'] == 'custom_css_on') {
			if( !empty($hgr_options['css-code']) ){
				echo '<!-- Custom CSS from Theme Options --> <style type="text/css">';
				echo esc_attr($hgr_options['css-code']);
				echo '</style> <!-- / Custom CSS from Theme Options -->';
			}
		}
		return false;
	}
	
	
 // HGR Menu fallback
	function hatch_menu_fallback(){
		echo '<ul id="mainNavUl" class="nav navbar-nav navbar-right"><li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-480 current_page_item"><a href="' . esc_url( home_url( '/' ) ) . '">'. esc_html__( 'Home','hatch' ) .'</a></li></ul>';
	}
	

	/*
	*	OneClick Install DEMO
	*/
	require_once( trailingslashit( get_template_directory() ) . 'highgrade/hgr_oci/hgr_oci.php' );



function hatch_removeDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFramework') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFramework::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFramework') ) {
        remove_action('admin_notices', array( ReduxFramework::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'hatch_removeDemoModeLink');

/** remove redux menu under the tools **/
add_action( 'admin_menu', 'hatch_remove_redux_menu',12 );
function hatch_remove_redux_menu() {
    remove_submenu_page('tools.php','redux-about');
}


/*
	Dinamic Styles based on Theme options
*/
 function hatch_styles(){
 	$hgr_options = get_option( 'redux_options' );
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	// Theme dominant color
	$theme_dominant_color = ( isset($hgr_options['theme_dominant_color']) && !empty($hgr_options['theme_dominant_color']) ? $hgr_options['theme_dominant_color'] : '#999');
	
	$output = '';
	$output .= '<style type="text/css" id="theme_options_dinamic_css">';
	$output .= '
		.wpb_btn-success, #itemcontainer-controller {
			background-color: '.$theme_dominant_color.'!important;
		}
		.hoveredIcon {
			color:'.$theme_dominant_color.'>!important;
		}
		/*#mainNavUl .dropdown-menu {
			border-top:2px solid '.$theme_dominant_color.'!important;
		}*/
		
		.topborder h3 a {
			border-top: 1px solid '.$theme_dominant_color.';
		}
		ul.nav a.active {
			color: '.$theme_dominant_color.' !important;
		}
		.testimonial_text{
			margin-bottom:60px;
		}';
	 
		if( is_plugin_active('woocommerce/woocommerce.php') && !empty($hgr_options['woo_support']) && $hgr_options['woo_support'] == 1 ) :

	$output .= '/* woocommerce */
		body.woocommerce{
			background-color: '.$hgr_options['shop_bg_color'].';
		}
		.woocommerce span.onsale, .woocommerce-page span.onsale {
			background-color: '.$hgr_options['theme_dominant_color'].'!important;
		}
		.woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li span.current {
			background: none repeat scroll 0% 0% '.$hgr_options['theme_dominant_color'].'!important;
			border: 2px solid '.$hgr_options['theme_dominant_color'].' !important;
		}
		.woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover {
			background-color: '.$hgr_options['theme_dominant_color'].' !important;
			border: 2px solid '.$hgr_options['theme_dominant_color'].' !important;
		}
		.woocommerce #content div.product form.cart .button, .woocommerce div.product form.cart .button, .woocommerce-page #content div.product form.cart .button, .woocommerce-page div.product form.cart .button {
			background: none repeat scroll 0% 0% '.$hgr_options['theme_dominant_color'].' !important;
		}
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active {
			border-bottom-color: '.$hgr_options['theme_dominant_color'].' !important;
		}
		.woocommerce #reviews #comments ol.commentlist li .comment-text, .woocommerce-page #reviews #comments ol.commentlist li .comment-text {
			background-color: '.$hgr_options['theme_dominant_color'].' !important;
		}
		.woocommerce p.stars a, .woocommerce-page p.stars a{
			color:'.$hgr_options['theme_dominant_color'].'!important;
		}
		.woocommerce #content .quantity .minus:hover, .woocommerce #content .quantity .plus:hover, .woocommerce .quantity .minus:hover, .woocommerce .quantity .plus:hover, .woocommerce-page #content .quantity .minus:hover, .woocommerce-page #content .quantity .plus:hover, .woocommerce-page .quantity .minus:hover, .woocommerce-page .quantity .plus:hover {
			background-color: '.$hgr_options['theme_dominant_color'].' !important;
		}
		
		.woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3 {
			font-size: '.$hgr_options['shop_h3_font']['font-size'].'!important;
			line-height: '.$hgr_options['shop_h3_font']['line-height'].'!important;
			color: '.$hgr_options['shop_h3_font']['color'].'!important;
		}
		.woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover {
			background-color: '.$theme_dominant_color.' !important;
		}
		.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info {	
			background-color: '.$theme_dominant_color.' !important;
		}
		.woocommerce table.shop_table thead span, .woocommerce-page table.shop_table thead span {
			border-bottom: 1px solid '.$theme_dominant_color.';
		}
		.proceed_button{
			border: 2px solid '.$theme_dominant_color.'!important;
			background-color:'.$theme_dominant_color.'!important;
		}
		.woocommerce .cart-collaterals .shipping-calculator-button{
			color:'.$theme_dominant_color.';
		}
		.checkout_apply_coupon{
			border: 2px solid '.$theme_dominant_color.';
			background-color: '.$theme_dominant_color.';
		}
		#place_order {
			border: 2px solid '.$theme_dominant_color.' !important;
			background-color: '.$theme_dominant_color.' !important;
		}
		.login_btn_hgr, .hgr_woobutton{
			border: 2px solid '.$theme_dominant_color.';
			background-color: '.$theme_dominant_color.';
		}
		.thankyoutext{color:'.$theme_dominant_color.';}
		#my-account h4.inline{
			border-bottom: 1px solid '.$theme_dominant_color.';
		}
		#my-account a{
		color:'.$theme_dominant_color.';
		}
		.hgr_woo_minicart .woo_bubble{
			background-color: '.$hgr_options['woo_bubble_color']['regular'].';
		}
		.hgr_woo_minicart .woo_bubble:hover{
			background-color: '.$hgr_options['woo_bubble_color']['hover'].';
		}
		.woocommerce a.added_to_cart {
			margin-left: auto;
			margin-right: auto;
			width: 100%;
			text-align: center;
			color:#000;
			background-color: '.$theme_dominant_color.';
		}
		.woocommerce a.added_to_cart:hover {
			color:#fff;
		}
		.woocommerce .woocommerce-message a:hover, .woocommerce-page .woocommerce-message a:hover {
			color: #FFF;
		}
		.woocommerce .bka_footer.dark_scheme a{
			color:'.$hgr_options['ahref_color']['regular'].';
		}
		.woocommerce .bka_footer.light_scheme a{
			color:'.$hgr_options['light_ahref_color']['regular'].';
		}
		.woocommerce .bka_footer.dark_scheme a:hover{
			color:'.$hgr_options['ahref_color']['hover'].';
		}
		.woocommerce .bka_footer.light_scheme a:hover{
			color:'.$hgr_options['light_ahref_color']['hover'].';
		}
		/* woocommerce end */';
		
	endif; // end if woo_support enabled
		
	$output .= '</style>';
	echo wp_kses($output, array('style' => array()) );
 }

 // Boostrap Menu Walker ( from: https://github.com/twittem/wp-bootstrap-navwalker )
 // Register Custom Navigation Walker
	@require_once( trailingslashit( get_template_directory() ) . 'highgrade/hgr_bootstrap_navwalker.php');
	
	
	
 // WOOCOMMERCE
 add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
 
 // Remove breadcrumb
 remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
 
 
 // Remove page title 
 add_filter('woocommerce_show_page_title', '__return_false');
 
 /**
 * Custom Add To Cart Messages
 * Add this to your theme functions.php file
 **/
 add_filter( 'wc_add_to_cart_message', 'hatch_custom_add_to_cart_message' );
 function hatch_custom_add_to_cart_message() {
	global $woocommerce;
 
	// Output success messages
	if ( get_option('woocommerce_cart_redirect_after_add') == 'yes' ) :
	 
	$return_to = get_permalink( woocommerce_get_page_id('shop') );
	 
	$message = sprintf('<a href="%s" class="button">%s</a> %s', $return_to, esc_html__('Continue Shopping &rarr;', 'hatch'), esc_html__('Product successfully added to your cart.', 'hatch') );
	 
	else :
	
	$message = '<i class="fa fa-icon fa-check" style="font-size:17px;margin-right:10px;"></i>';
	
	$message .= sprintf('<a href="%s" class="hgr_view_cart_link">%s <i class="fa fa-icon fa-angle-right" style="font-size:17px;margin-left:10px;"></i></a> %s', get_permalink( woocommerce_get_page_id('cart') ), esc_html__('View Cart', 'hatch'), esc_html__('Product successfully added to your cart.', 'hatch') );
	 
	endif;
	 
	return $message;
}




function hatch_display_logo(){
    $hgr_options = get_option( 'redux_options' );
    if (is_ssl()) {
        echo str_replace('http://','https://',( !empty($hgr_options['logo']['url']) 
        ? '<span class="helper"></span><img src="'.$hgr_options['logo']['url'].'" alt="'.get_bloginfo('name').'" class="logo" height="'.$hgr_options['logo']['height'].'" width="'.$hgr_options['logo']['width'].'">' 
        : '<span class="helper"></span><img src="'.esc_url( get_template_directory_uri() ).'/highgrade/images/logo.png" alt="Initial Logo" class="logo">' 
        ));
    }
    else {
        echo ( !empty($hgr_options['logo']['url']) 
        ? '<span class="helper"></span><img src="'.$hgr_options['logo']['url'].'" alt="'.get_bloginfo('name').'" class="logo" height="'.$hgr_options['logo']['height'].'" width="'.$hgr_options['logo']['width'].'">' 
        : '<span class="helper"></span><img src="'.esc_url( get_template_directory_uri() ).'/highgrade/images/logo.png" alt="Initial Logo" class="logo"><span class="redactor-selection-marker" id="selection-marker-1"></span>' 
        );
    }
}
