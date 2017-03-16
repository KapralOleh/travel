<?php
/*
* Add-on Name: Google Maps
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Add-on Author: Bogdan Costescu
*/

if(!class_exists('HGR_VC_GMAP')) {
	class HGR_VC_GMAP {
			
		function __construct() {
			add_action('admin_init', array($this, 'hgr_gmap_init'));
			add_action('wp_enqueue_scripts',array($this,'set_hgr_gmap_styles'));
			
			/*
				Param type "number"
			*/ 
			if ( function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('number' , array('HGR_XTND', 'make_number_input' ) );
			}
		}
		
		/*
			Register and enqueue GMaps JS to header
		*/
		function set_hgr_gmap_styles() {
			// wp_register_script('hgr_vc_script_gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp');
			// wp_enqueue_script('hgr_vc_script_gmapapi');
		}

		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function hgr_gmap_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Google Map", "hgr_lang"),
					   "base"				=>	"hgr_gmap",
					   "class"				=>	"",
					   "icon"				=>	"hgr_gmap",
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "description"		=>	__("Google Map","hgr_lang"),
					   "params" => array(
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Map name:", "hgr_lang"),
								"param_name"	=>	"gmap_name",
								"value"			=>	"Sydney",
								"description"	=>	__("*Insert map name here. Make sure this map name is unique.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Latitude:", "hgr_lang"),
								"param_name"	=>	"gmap_latitude",
								"value"			=>	"-33.8814454",
								"description"	=>	__("Insert latitude coordinate here.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Longitude:", "hgr_lang"),
								"param_name"	=>	"gmap_longitude",
								"value"			=>	"151.2226494",
								"description"	=>	__("Insert longitude coordinate here.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Zoom Level:","hgr_lang"),
								"param_name"	=>	"gmap_zoom",
								"value"			=>	18,
								"min"			=>	0,
								"max"			=>	20,
								"description"	=>	__("Zoom on location. Min value 0 (whole world), max value 20.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Map Style:", "hgr_lang"),
								"param_name"	=>	"gmap_style",
								"value"			=>	array(
										__( 'Google preset colors', 'hgr_lang' )	=> 'gmap_style_normal',
										__( 'Greyscale', 'hgr_lang' ) 			=> 'gmap_style_greyscale',
									),
								"description"	=>	__("Choose map style that suits your design.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Marker Settings:", "hgr_lang"),
								"param_name"	=>	"gmap_marker_settings",
								"value"			=>	array(
										__( 'Google default', 'hgr_lang' )	=> 'gmap_marker_default',
										__( 'Plugin default', 'hgr_lang' ) 	=> 'gmap_marker_plugin',
										__( 'Upload your own', 'hgr_lang' ) 	=> 'gmap_marker_custom',
									),
								"description"	=>	__("Marker style settings.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload Marker Image:", "hgr_lang"),
								"param_name"	=>	"marker_image",
								"value"			=>	"",
								"description"	=>	__("Upload marker custom image.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"gmap_marker_settings",
										"value"		=>	array( "gmap_marker_custom" ),
									),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Map Width:", "hgr_lang"),
								"param_name"	=>	"gmap_width",
								"value"			=>	"640px",
								"description"	=>	__("Enter value in pixels. You can set also % values.", "hgr_lang"),
								"save_always"	=>	true,
							),
							
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Map Height:", "hgr_lang"),
								"param_name"	=>	"gmap_height",
								"value"			=>	"400px",
								"description"	=>	__("Enter value in pixels. You can set also % values.", "hgr_lang"),
								"save_always"	=>	true,
							),
							array(
								"type"			=>	'checkbox',
								"heading"		=>	__("Disable zoom on mouse over scroll:", "hgr_lang"),
								"param_name"	=>	"gmap_disablezoom",
								"description"	=>	__("If checked this will disable map zooming when scrolling over.", "hgr_lang"),
								"value"			=>	array( esc_html__("Yes, please", "hgr_lang") => 'yes' ),
								"save_always"	=>	true,
						    ),
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Extra class", "hgr_lang"),
								 "param_name"	=>	"gmap_extra_class",
								 "value"		=>	"",
								 "description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang"),
								 "save_always"	=>	true,
							),
						),
					)
				);
			}
		}
	}
	new HGR_VC_GMAP;
}