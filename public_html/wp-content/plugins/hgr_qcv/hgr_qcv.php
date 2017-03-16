<?php
/*
	Plugin Name: Highgrade Add-Ons: Quick Cart View
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 1.0.0
	Description: Part of HighGrade Add-Ons for HighGrade themes and adds a quick cart view option for your website header. It requires WooCommerce min version 2.3.11
	Text Domain: hgr_qcv
	Domain Path: /languages
*/

/*
*	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('HGR_QCV')) {
	
	class HGR_QCV {
		
		var $js_dir;
		var $css_dir;
		
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
			
			// CSS and JS for back-end and front-end
			$this->js_dir	=	plugins_url('js/',__FILE__);
			$this->css_dir	=	plugins_url('css/',__FILE__);
			
			// Enqueue required frontend scripts & styles
			add_action('wp_enqueue_scripts',array($this,'hgr_front_scripts'));
			
			add_action( 'admin_init', array($this,'hgr_dependency_check') );
			add_action( 'activated_plugin', array($this,'hgr_dependency_check') );
			
			// Required shortcodes: header_style_1.php
			add_shortcode( 'hgr_quick_cart', array($this,'do_qcv_shortcode') );
			
			// Hook QCV into footer
			//add_action('wp_footer', array($this,'do_qcv') );
			
		}
		
		/**
		*	Load plugin textdomain.
		*	@since 1.0.0
		*/
		function hgr_load_textdomain() {
		  load_plugin_textdomain( 'hgr_qcv', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
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
				/**
				*	Get theme details
				*/
				$theme = wp_get_theme();
				
				/**
				*	Get notices array and update them
				*/
				$notices	=	get_option( 'hgr_admin_notices', array() );
				$notices[]	=	"Highgrade Quick Cart View its activated now! Thank you for using <b>".$theme->name."</b> Theme.";
				update_option('hgr_qcv_version', '1.0.0' );
				update_option('hgr_admin_notices', $notices);
		}
		
		
		/**
		*	Function to check if required theme is installed and activated
		*	@since 1.0.0
		*/
		function hgr_dependency_check() {
			
			$theme = wp_get_theme(); // gets the current theme
			
			/**
			*	Get notices array and update them
			*/
			$notices	=	get_option( 'hgr_admin_notices', array() );
			
			if( 'Hatch' == $theme->name || 'Hatch' == $theme->parent_theme) {}
			else {
				$notices[]	=	"Highgrade Quick Cart View its only available with <b>".$theme->name."</b> theme. You are not allowed to use this outside <b>".$theme->name."</b> Theme.";
				update_option('hgr_admin_notices', $notices);
				$this->hgr_deactivate();
			}
			
			if( !is_plugin_active('woocommerce/woocommerce.php') ) {
				$notices[]	=	"Highgrade Quick Cart View is a WooCommerce plugin, so please install and activate WooCommerce first. WooZoom was deactivated!";
				update_option('hgr_admin_notices', $notices);
				$this->hgr_deactivate();
			}
		 }
		 
		 
		/*
		*	Deactivate plugin
		*/
		function hgr_deactivate(){
			/*
			Deactivate the plugin as the conditions are not met
			*/
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		
		
		/*
		*	Quick Cart View
		*	Hooked into wp_footer (see constructor function above)
		*	@since 1.0.0
		*/
		function do_qcv_shortcode($atts){
			global $woocommerce;
			
			$items_list = $output = '';
			
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
			
			// cart content
			$cart_content = $woocommerce->cart->get_cart();
			
			if( !empty($cart_content) ){
				
				foreach($cart_content as $item){					
					
					if ( has_post_thumbnail($item['product_id']) ) {
						$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
						$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );							
						$image       	= get_the_post_thumbnail( $item['product_id'], apply_filters( 'single_product_large_thumbnail_size', array(50) ), array('class'=>'qcv_image') );
					} else { $image = ''; }
					
					$items_list .= '<div class="qcv_item">';
						$items_list .= $image;
						$items_list .= '<div class="qcv_item_title">';
							$items_list .= '<a href="'.get_permalink($item['product_id']).'" class="qcv_item_link">';
								$items_list .= $item['quantity'] . ' x ' . $item['data']->post->post_title;
							$items_list .= '</a>';
							$items_list .= '<div class="qcv_item_subtotal">';
								$items_list .= 'Item subtotal: ' . get_woocommerce_currency_symbol() . $item['line_subtotal'];
							$items_list .= '</div>';
						$items_list .= '</div>';
					$items_list .= '</div><!--.qcv_item-->';
				}
			
			
				$output .= '<div id="qcv_handle">';		
					$output .= '<div id="qcv_container" class="hidden">';
						$output .= '<div class="qcv_cart_content">
										<div class="qcv_list">
											'.$items_list.'
										</div>
										<div class="qcv_items_subtotal">Total: '.$woocommerce->cart->get_cart_total().'</div>
							<a href="'.$woocommerce->cart->get_cart_url().'" class="qcv_button qcv_button_cart">Go to Cart</a><br>
							<a href="'.$woocommerce->cart->get_checkout_url().'" class="qcv_button qcv_button_checkout">Go to CheckOut</a>
							</div>';
					$output .= '</div><!-- qcv_container END -->';
				$output .= '</div><!-- #qcv_handle END -->';
			
			}
			else {
				// Empty cart
				$output .= '<div id="qcv_handle">';
						//$output .= $woocommerce->cart->get_cart_total();
						//$output .= ' <span class="qcv_icon fa-shopping-cart"></span>';
				
					$output .= '<div id="qcv_container" class="hidden">';
						$output .= '<div class="qcv_cart_content">
										<div class="qcv_items_subtotal qcv_empty_cart">'.__('Your cart is empty!', 'hgr_lang').'</div>
							</div>';
					$output .= '</div><!-- qcv_container END -->';
				$output .= '</div><!-- #qcv_handle END -->';
			}
			return $output;
		}
		
		
		/*
		*	Register necessary js and css files on frontend
		*/
		function hgr_front_scripts(){
			wp_register_script('sage-hoverIntent',$this->js_dir.'jquery.hoverIntent.minified.js', array('jquery'), '', true);
			wp_enqueue_script( 'sage-hoverIntent' );
			wp_register_script('sage-qcv',$this->js_dir.'hgr_qcv.js', array('jquery'), '', true);
			wp_enqueue_script( 'sage-qcv' );
			wp_register_style('sage-qcv-style',$this->css_dir.'hgr_qcv.css', '', '' );
			wp_enqueue_style( 'sage-qcv-style' );
		}
	}	
	/*
	*	All good, fire up the plugin :)
	*/
	new HGR_QCV;
}