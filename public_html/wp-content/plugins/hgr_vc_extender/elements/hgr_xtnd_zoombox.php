<?php
/*
* Add-on Name: Zoom Box
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Add-on Author: Bogdan Costescu
*/
if(!class_exists('HGR_VC_ZOOMBOX')) {
	class HGR_VC_ZOOMBOX {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_zoombox_init'));
			
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
		function hgr_zoombox_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
						"name"			=>	__("HGR ZoomBox", "hgr_lang"),
						"base"			=>	"hgr_zoom_box",
						"class"			=>	"",
						"icon"			=>	"hgr_zoom_box",
						"category"		=>	__("HighGrade Extender", "hgr_lang"),
						"description"	=>	__("ZoomBox - two sided box", "hgr_lang"),
						"params"		=>	array(
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Display icon:","hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
									__( 'Font Icon Browser', 'hgr_lang' )	=> 'selector',
									__( 'Custom Image Icon', 'hgr_lang' )	=> 'custom-icon',
									__( 'None', 'hgr_lang' ) 				=> 'none',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select icon source.", "hgr_lang")
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon:","hgr_lang"),
								"param_name"	=>	"icon",
								"value"			=>	"",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array("selector"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Size:", "hgr_lang"),
								"param_name"	=>	"icon_size",
								"value"			=>	32,
								"min"			=>	12,
								"max"			=>	72,
								"suffix"		=>	"px",
								"description"	=>	__("Set the icon size.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array("selector"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Color:", "hgr_lang"),
								"param_name"	=>	"icon_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array("selector"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload image icon:", "hgr_lang"),
								"param_name"	=>	"icon_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array( "custom-icon" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Image width:", "hgr_lang"),
								"param_name"	=>	"img_width",
								"value"			=>	48,
								"min"			=>	16,
								"max"			=>	512,
								"suffix"		=>	"px",
								"description"	=>	__("Provide image width.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array( "custom-icon" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Front Title text:", "hgr_lang"),
								"param_name"	=>	"front_title",
								"value"			=>	"Fast customization",
								"description"	=>	__("Title for the front view.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front Title color:", "hgr_lang"),
								"param_name"	=>	"front_title_color",
								"value"			=>	"#222222",
								"description"	=>	__("Color of front title text.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Front Description text:","hgr_lang"),
								 "param_name"	=>	"front_desc",
								 "value"		=>	"Using the visual editor has never been easier.",
								 "description"	=>	__("Insert front description here.", "hgr_lang"),
								 "save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front Description color:", "hgr_lang"),
								"param_name"	=>	"front_desc_color",
								"value"			=>	"#8d8d8d",
								"description"	=>	__("Color of front description text.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Front Background type:", "hgr_lang"),
								"param_name"	=>	"front_background_type",
								"value"			=>	array(
									__( 'Custom settings', 'hgr_lang' )	=> 'custom-front-background',
									__( 'None', 'hgr_lang' )				=> 'none',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select background type for front panel.","hgr_lang"),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front Background color:", "hgr_lang"),
								"param_name"	=>	"front_background_color",
								"value"			=>	"#ffffff",
								"description"	=>	__("Pick a background color for front panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_background_type",
									"value"		=>	array("custom-front-background"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Front Background opacity:", "hgr_lang"),
								"param_name"	=>	"front_background_opacity",
								"value"			=>	1,
								"min"			=>	0.1,
								"max"			=>	1,
								"description"	=>	__("Front panel background opacity. Min value 0.1, max value 1.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_background_type",
									"value"		=>	array("custom-front-background"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Front Border type:", "hgr_lang"),
								"param_name"	=>	"front_border_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' )				=> 'none',
									__( 'Custom settings', 'hgr_lang' )	=> 'custom-front-border',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select border type for front panel.", "hgr_lang"),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Front Border width:", "hgr_lang"),
								"param_name"	=>	"front_border_width",
								"value"			=>	2,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"		=>	"front_border_type",
									"value"			=>	array("custom-front-border"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front Border color:", "hgr_lang"),
								"param_name"	=>	"front_border_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a border color for front panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_border_type",
									"value"		=>	array("custom-front-border"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Title text:", "hgr_lang"),
								"param_name"	=>	"zoom_title",
								"value"			=>	"Unlimited options",
								"description"	=>	__("Insert zoom panel title text here.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Title color:", "hgr_lang"),
								"param_name"	=>	"zoom_title_color",
								"value"			=>	"#222222",
								"description"	=>	__("Color of zoom panel title text.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Zoom Panel Description text:", "hgr_lang"),
								 "param_name"	=>	"zoom_desc",
								 "value"		=>	"Extensive editing options, no coding required.",
								 "description"	=>	__("Insert zoom panel description here.", "hgr_lang"),
								 "save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Description color:", "hgr_lang"),
								"param_name"	=>	"zoom_desc_color",
								"value"			=>	"#8d8d8d",
								"description"	=>	__("Color of zoom panel description text.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Background type:", "hgr_lang"),
								"param_name"	=>	"zoom_background_type",
								"value"			=>	array(
									__( 'Select color', 'hgr_lang' )	=> 'custom-zoom-color',
									__( 'None', 'hgr_lang' )			=> 'none',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select background type for zoom panel.", "hgr_lang"),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Background color:", "hgr_lang"),
								"param_name"	=>	"zoom_background_color",
								"value"			=>	"#ffffff",
								"description"	=>	__("Pick a background color for zoom panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"zoom_background_type",
									"value"		=>	array("custom-zoom-color"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Border type:", "hgr_lang"),
								"param_name"	=>	"zoom_border_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' )				=> 'none',
									__( 'Custom settings', 'hgr_lang' )	=> 'custom-zoom-border',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select border type for zoom panel.", "hgr_lang"),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Border width:", "hgr_lang"),
								"param_name"	=>	"zoom_border_width",
								"value"			=>	2,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"zoom_border_type",
									"value"		=>	array("custom-zoom-border"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Zoom Panel Border color:", "hgr_lang"),
								"param_name"	=>	"zoom_border_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a border color for zoom panel.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"zoom_border_type",
										"value"			=>	array("custom-zoom-border"),
									),						
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Box Border Roundness:", "hgr_lang"),
								"param_name"	=>	"zb_border_roundness",
								"value"			=>	0,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels, example: 0 for square, or 5 for rounded corners.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"		=>	"",
								"heading"		=>	__("Link","hgr_lang"),
								"param_name"	=>	"custom_link",
								"value"			=>	array(
									__( 'No Link', 'hgr_lang' )					=> 'no-link',
									__( 'Add custom link to box', 'hgr_lang' )	=> 'set-link',
								),
								"save_always" 	=>	true,
								"description"	=>	__("You can add/remove custom link.", "hgr_lang"),
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("Box Link:","hgr_lang"),
								 "param_name"	=>	"zoombox_link",
								 "value"		=>	"",
								 "description"	=>	__("You can add or remove the existing link from here.", "hgr_lang"),
								 "dependency"	=>	array(
								 	"element"	=>	"custom_link",
									"value"		=>	array( "set-link" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra class","hgr_lang"),
								"param_name"	=>	"zb_extra_class",
								"value"			=>	"",
								"description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							
						),
					)
				);
			}
		}
	}
	new HGR_VC_ZOOMBOX;
}