<?php
/*
* Add-on Name: Counter
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
* Update & Bug fixes: Bogdan Costescu
*/
if(!class_exists('HGR_VC_COUNTER')) {
	class HGR_VC_COUNTER {
		
		function __construct() {
			add_action('admin_init', array($this, 'hgr_counter_init'));
			
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
		function hgr_counter_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Counter", "hgr_lang"),
					   "holder"				=>	"div",
					   "base"				=>	"hgr_counter",
					   "class"				=>	"",
					   "icon"				=>	"hgr_counter",
					   "description"		=>	__("Animated counters", "hgr_lang"),
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "content_element"	=>	true,
					   "params"				=>	array(
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon to display:", "hgr_lang"),
								"description"	=>	__("Use an existing font icon or upload a custom image.", "hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' ) => 'selector',
										__( 'Custom Image Icon', 'hgr_lang' ) => 'custom',
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon ","hgr_lang"),
								"param_name"	=>	"icon",
								"value"			=>	"",
								"dependency"	=>	array(
										"element"	=>	"icon_type",
										"value"		=>	array( "selector" )
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload Image Icon:", "hgr_lang"),
								"param_name"	=>	"icon_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_type",
										"value"		=>	array( "custom" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Image Width", "hgr_lang"),
								"param_name"	=>	"img_width",
								"value"			=>	48,
								"min"			=>	16,
								"max"			=>	512,
								"suffix"		=>	"px",
								"description"	=>	__("Provide image width.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_type",
										"value"		=>	array( "custom" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Icon Size:","hgr_lang"),
								"param_name"	=>	"counter_icon_size",
								"value"			=>	32,
								"min"			=>	12,
								"max"			=>	72,
								"suffix"		=>	"px",
								"description"	=>	__("Set the icon size.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_type",
										"value"		=>	array( "selector" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Color:", "hgr_lang"),
								"param_name"	=>	"counter_icon_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_type",
										"value"		=>	array( "selector" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon position:", "hgr_lang"),
								"description"	=>	__("Select icon position.","hgr_lang"),
								"param_name"	=>	"counter_icon_position",
								"value"			=>	array(
										"Left"			=>	"icon-left",
										"Top"			=>	"icon-top",
										"Right"			=>	"icon-right",
										"Bottom"		=>	"icon-bottom",
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Counter Number:","hgr_lang"),
								"description"	=>	__("Count from 1 to this number.", "hgr_lang"),
								"param_name"	=>	"counter_number",
								"value"			=>	100,
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Counter Number Color:", "hgr_lang"),
								"param_name"	=>	"counter_number_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a color.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Counter Units:","hgr_lang"),
								"param_name"	=>	"counter_units",
								"value"			=>	"",
								"description"	=>	__("Ex: cups, lines of code, projects.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Counter Units Color:", "hgr_lang"),
								"param_name"	=>	"counter_units_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a color.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Counter Text:","hgr_lang"),
								"param_name"	=>	"counter_text",
								"value"			=>	__("", "hgr_lang"),
								"description"	=>	__("Ex: of coffee (cups), written (lines of code), delivered (projects).", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Counter Text Color:", "hgr_lang"),
								"param_name"	=>	"counter_text_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a color.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Counter Speed:","hgr_lang"),
								"param_name"	=>	"counter_speed",
								"value"			=>	5,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	__("seconds", "hgr_lang"),
								"description"	=>	__("Set counter speed. Default is 5 seconds.", "hgr_lang"),
								"save_always" 	=>	true,
							),						
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Background Settings:", "hgr_lang"),
								"param_name"	=>	"counter_background_settings",
								"value"			=>	array(
										"None"			=>	"none",
										"Select color"	=>	"custom-counter-background",
									),
								"description"	=>	__("Select background type.","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Background Color:", "hgr_lang"),
								"param_name"	=>	"counter_background_color",
								"value"			=>	"#0484c9",
								"description"	=>	__("Pick a background color.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"counter_background_settings",
										"value"		=>	array( "custom-counter-background" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Border Settings:", "hgr_lang"),
								"param_name"	=>	"counter_border_settings",
								"value"			=>	array(
									"None"			=>	"none",
									"Custom border"	=>	"custom-counter-border",
								),
								"description"	=>	__("Select border type.","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Border Width:", "hgr_lang"),
								"param_name"	=>	"counter_border_width",
								"value"			=>	1,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"counter_border_settings",
									"value"		=>	array( "custom-counter-border" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Border Color:", "hgr_lang"),
								"param_name"	=>	"counter_border_color",
								"value"			=>	"#222222",
								"description"	=>	__("Pick a border color.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"counter_border_settings",
									"value"		=>	array("custom-counter-border"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Box Border Roundness:", "hgr_lang"),
								"param_name"	=>	"counter_border_corner",
								"value"			=>	0,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels, example: 0 for square, or 5 for rounded corners.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra class name","hgr_lang"),
								"param_name"	=>	"extra_class",
								"value"			=>	"",
								"description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang"),
								"save_always" 	=>	true,
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_COUNTER;
}