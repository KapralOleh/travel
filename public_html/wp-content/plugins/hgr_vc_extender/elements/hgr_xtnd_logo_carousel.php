<?php
/*
* Add-on Name: Logo Carousel
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Based on: www.owlgraphic.com/owlcarousel/
* Since: 1.0
* Author: Bogdan Costescu
*/
if(!class_exists('HGR_VC_LOGOCAROUSEL')) {
	class HGR_VC_LOGOCAROUSEL {

		function __construct() {
			add_action('admin_init', array($this, 'add_logocarousel'));
			
			/*
				Param type "number"
			*/ 
			if ( function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('number' , array('HGR_XTND', 'make_number_input' ) );
			}
		}
		
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function add_logocarousel() {
			if(function_exists('vc_map')) {
				
				/*
					Parent element
				*/
				vc_map(
					array(
					   "name"						=>	__("HGR LogoCarousel", "hgr_lang"),
					   "base"						=>	"hgr_logocarousel",
					   "class"						=>	"",
					   "icon"						=>	"hgr_logocarousel",
					   "category"					=>	__("HighGrade Extender", "hgr_lang"),
					   "as_parent"					=>	array( 'only' => 'hgr_logocarousel_item' ),
					   "description"				=>	__("Carousel block", "hgr_lang"),
					   "content_element"			=>	true,
					   "show_settings_on_create"	=>	true,
					   "params"					=>	array(
							array(
								"type"				=>	"number",
								"class"				=>	"",
								"heading"			=>	__("Numer of logos displayed at a time with the widest browser width:", "hgr_lang"),
								"param_name"		=>	"carousel_items_number_max",
								"value"				=>	5,
								"min"				=>	1,
								"max"				=>	50,
								"description"		=>	__("Logos displayed at a time with the widest browser width.", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"number",
								"class"				=>	"",
								"heading"			=>	__("Number of logos displayed for desktop window size (< 1200px):", "hgr_lang"),
								"param_name"		=>	"carousel_items_number_desktop",
								"value"				=>	4,
								"min"				=>	1,
								"max"				=>	40,
								"description"		=>	__("Logos displayed at a time for desktop window size.", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"number",
								"class"				=>	"",
								"heading"			=>	__("Number of logos displayed for desktop small window size (< 980px):", "hgr_lang"),
								"param_name"		=>	"carousel_items_number_desktop_small",
								"value"				=>	3,
								"min"				=>	1,
								"max"				=>	30,
								"description"		=>	__("Logos displayed at a time for desktop small window size.", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"number",
								"class"				=>	"",
								"heading"			=>	__("Number of logos displayed for tablet window size (< 769px):", "hgr_lang"),
								"param_name"		=>	"carousel_items_number_tablet",
								"value"				=>	2,
								"min"				=>	1,
								"max"				=>	20,
								"description"		=>	__("Logos displayed at a time for desktop small window size.", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"checkbox",
								"heading"			=>	__("Auto play scrooling:", "hgr_lang"),
								"param_name"		=>	"carousel_autoplay",
								"description"		=>	__("If checked this will set the carousel to scroll every 5 seconds.", "hgr_lang"),
								"value"				=>	array( esc_html__("Yes, please", "hgr_lang") => 'yes' ),
								"save_always" 		=>	true,
							),
							array(
								 "type"				=>	"textfield",
								 "class"			=>	"",
								 "heading"			=>	__("Extra class:", "hgr_lang"),
								 "param_name"		=>	"carousel_extra_class",
								 "value"			=>	"",
								 "description"		=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang"),
								 "save_always" 		=>	true,
							),
							array(
								"type"				=>	"heading",
								"sub_heading"		=>	"This is a global setting page for the whole \"Carousel\" block. Add some \"Carousel Items\" in the container row to make it complete.",
								"param_name"		=>	"notification",
							),
						),
						"js_view" => 'VcColumnView'
				));
					
				/*
					Child element
				*/
				vc_map(
					array(
					   "name"						=>	__("Carousel item", "hgr_lang"),
					   "holder"						=>	"div",
					   "base"						=>	"hgr_logocarousel_item",
					   "class"						=>	"",
					   "icon"						=>	"",
					   "content_element"			=>	true,
					   "as_child"					=>	array(
					   			"only"				=>	"hgr_logocarousel"
							),
					   "params"						=>	array(
							array(
								"type"				=>	"attach_image",
								"class"				=>	"",
								"heading"			=>	__("Logo image:", "hgr_lang"),
								"param_name"		=>	"item_image",
								"admin_label"		=>	true,
								"value"				=>	"",
								"description"		=>	__("Upload carousel item logo image.", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"dropdown",
								"class"				=>	"",
								"heading"			=>	__("Link text settings:", "hgr_lang"),
								"param_name"		=>	"item_link_settings",
								"value"				=>	array(
										__( 'No Link', 'hgr_lang' )	=> 'link-off',
										__( 'Add link', 'hgr_lang' )	=> 'link-on',
									),
								"save_always" 		=> true,
								"description"		=>	__("You can add / remove custom link for logo image.", "hgr_lang"),
							),
							array(
								"type"				=>	"vc_link",
								"class"				=>	"",
								"heading"			=>	__("Link to:","hgr_lang"),
								"param_name"		=>	"item_link",
								"value"				=>	"",
								"description"		=>	__("Set a link to this logo image.","hgr_lang"),
								"dependency"		=>	array(
										"element"	=>	"item_link_settings",
										"value"		=>	array( "link-on" ),
									),
								"save_always" 		=>	true,
							),
					    )
					) 
				);
			}
		}
	}
	new HGR_VC_LOGOCAROUSEL;
}