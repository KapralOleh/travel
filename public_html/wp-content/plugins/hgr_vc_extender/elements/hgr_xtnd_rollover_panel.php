<?php
/*
	* Add-on Name: Rollover Panel
	* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
	* Since: 1.0.3.8
	* Add-on Author: Bogdan Costescu
*/
if(!class_exists('HGR_VC_ROLLOVERPANEL')) {
	class HGR_VC_ROLLOVERPANEL {
		function __construct() {
			add_action('admin_init', array($this, 'hgr_rolloverpanel'));
			/*
				Param type "number"
			*/ 
			if ( function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('number' , array('HGR_XTND', 'make_number_input' ) );
			}
			/*
				Param type "icon_browser"
			*/ 
			if(function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param('icon_browser', array('HGR_XTND','icon_browser'));
			}
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function hgr_rolloverpanel() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"			=>	__("HGR Rollover Panel","hgr_lang"),
					   "base"			=>	"hgr_rollover_panel",
					   "class"			=>	"",
					   "icon"			=>	"hgr_rolloverpanel",
					   "category"		=>	__("HighGrade Extender", "hgr_lang"),
					   "description"	=>	__("Rollover Panel with advanced settings", "hgr_lang"),
					   "params"			=>	array(
							/*
								=== Front panel settings ===
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon to display on front side:", "hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
									__( 'Font Icon Browser', 'hgr_lang' ) => 'selector',
									__( 'Custom Image Icon', 'hgr_lang' ) => 'custom-icon',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select icon source.", "hgr_lang"),
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select icon:", "hgr_lang"),
								"param_name"	=>	"icon",
								"value"			=>	"",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array( "selector" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"hgr_range_class",
								"heading"		=>	__("Size of icon on front side:", "hgr_lang"),
								"param_name"	=>	"icon_size",
								"value"			=>	32,
								"min"			=>	12,
								"max"			=>	120,
								"suffix"		=>	"px",
								"description"	=>	__("Set the icon size on front panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array( "selector" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Color of icon on front side:", "hgr_lang"),
								"param_name"	=>	"icon_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick your desired icon color.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_type",
									"value"		=>	array( "selector" ),
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
							/*
								Front side title settings
							*/
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Front side title text:","hgr_lang"),
								"param_name"	=>	"title_front",
								"value"			=>	"Fast customization",
								"description"	=>	__("Title for the front panel.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Front side title size:", "hgr_lang"),
								"param_name"	=>	"title_front_size",
								"value"			=>	14,
								"min"			=>	8,
								"max"			=>	30,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front side title color:", "hgr_lang"),
								"param_name"	=>	"title_front_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for the front side title.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							/*
								Front side background settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Front side background type:", "hgr_lang"),
								"param_name"	=>	"front_background_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' ) 		=> 'none',
									__( 'Select color', 'hgr_lang' )	=> 'custom-front-color',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Choose between transparent or color background.", "hgr_lang"),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading" 		=>	__("Front side background color:", "hgr_lang"),
								"param_name"	=>	"front_background_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a background color for front panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_background_type",
									"value"		=>	array("custom-front-color"),
								),
								"save_always" 	=>	true,
							),
							/*
								Front side border settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Front side border type:", "hgr_lang"),
								"param_name"	=>	"front_border_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' ) 		=> 'none',
									__( 'Custom border settings', 'hgr_lang' )	=> 'custom-front-border',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Add border to front side panel.", "hgr_lang"),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Front border width:", "hgr_lang"),
								"param_name"	=>	"front_border_width",
								"value"			=>	1,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_border_type",
									"value"		=>	array( "custom-front-border" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front border color:", "hgr_lang"),
								"param_name"	=>	"front_border_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for front side border.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"front_border_type",
									"value"		=>	array( "custom-front-border" ),
								),
								"save_always" 	=>	true,
							),
							/*
								=== Back panel settings ===
							*/
							/*
								Back side title settings
							*/
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Back side title text:","hgr_lang"),
								"param_name"	=>	"title_back",
								"value"			=>	"Fast customization",
								"description"	=>	__("Title for the back panel.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Back side title size:", "hgr_lang"),
								"param_name"	=>	"title_back_size",
								"value"			=>	14,
								"min"			=>	8,
								"max"			=>	30,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Back side title color:", "hgr_lang"),
								"param_name"	=>	"title_back_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for the back side title.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							/*
								Back side description settings
							*/
							array(
								"type"			=>	"textfield",
								"class"		=>	"",
								"heading"		=>	__("Back side description text:","hgr_lang"),
								"param_name"	=>	"description_back",
								"value"		=>	"",
								"description"	=>	__("Description for the back panel.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Back side description text size:", "hgr_lang"),
								"param_name"	=>	"description_back_size",
								"value"			=>	14,
								"min"			=>	8,
								"max"			=>	30,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Back side description text color:", "hgr_lang"),
								"param_name"	=>	"description_back_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for the back side description.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							/*
								Back side background settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Back side background type:", "hgr_lang"),
								"param_name"	=>	"back_background_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' ) 		=> 'none',
									__( 'Select color', 'hgr_lang' )	=> 'custom-back-color',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Choose between transparent or color background.", "hgr_lang"),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading" 		=>	__("Back side background color:", "hgr_lang"),
								"param_name"	=>	"back_background_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a background color for back panel.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"back_background_type",
									"value"		=>	array("custom-back-color"),
								),
								"save_always" 	=>	true,
							),
							/*
								Back side border settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Back side border type:", "hgr_lang"),
								"param_name"	=>	"back_border_type",
								"value"			=>	array(
									__( 'None', 'hgr_lang' ) 					=> 'none',
									__( 'Custom border settings', 'hgr_lang' )	=> 'custom-back-border',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Add border to back side panel.", "hgr_lang"),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Back border width:", "hgr_lang"),
								"param_name"	=>	"back_border_width",
								"value"			=>	1,
								"min"			=>	1,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"back_border_type",
									"value"		=>	array( "custom-back-border" ),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Back border color:", "hgr_lang"),
								"param_name"	=>	"back_border_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for back side border.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"back_border_type",
									"value"		=>	array( "custom-back-border" ),
								),
								"save_always" 	=>	true,
							),
							/*
								Back side link settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Back side link settings:", "hgr_lang"),
								"param_name"	=>	"custom_link_back",
								"value"			=>	array(
									__( 'No link', 'hgr_lang' ) 			=> '',
									__( 'Add custom link', 'hgr_lang' )	=> 'yes',
								),
								"save_always" 	=> true,
								"description"	=>	__("You can add/remove custom link.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Back side link text:","hgr_lang"),
								"param_name"	=>	"link_text",
								"value"			=>	"Read more",
								"description"	=>	__("Choose a text for your link.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"custom_link_back",
									"not_empty"	=>	true,
									"value"		=>	array("yes"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"vc_link",
								"class"			=>	"",
								"heading"		=>	__("Link to URL:", "hgr_lang"),
								"param_name"	=>	"link_url",
								"value"			=>	"",
								"description"	=>	__("Select URL to link.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"custom_link_back",
									"not_empty"	=>	true,
									"value"		=>	array("yes"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Link text size:", "hgr_lang"),
								"param_name"	=>	"link_size",
								"value"			=>	14,
								"min"			=>	8,
								"max"			=>	30,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"custom_link_back",
									"not_empty"	=>	true,
									"value"		=>	array("yes"),
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Link text color:", "hgr_lang"),
								"param_name"	=>	"link_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a color for the link text.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"custom_link_back",
									"not_empty"	=>	true,
									"value"		=>	array("yes"),
								),
								"save_always" 	=>	true,
							),
							/*
								General panel settings
							*/
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Box rounded corners:", "hgr_lang"),
								"param_name"	=>	"box_roundness",
								"value"			=>	0,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels, example: 0 for square, or 5 for rounded corners. Roundness will be applied to both sides.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	'checkbox',
								"heading"		=>	__("Enable panel reflection:", "hgr_lang"),
								"param_name"	=>	"box_reflection",
								"description"	=>	__("Check box to apply reflection. Reflection works best on square boxes.", "hgr_lang"),
								"value"			=>	array( esc_html__("Yes, please", "hgr_lang") => 'yes' ),
								"save_always" 	=>	true,
						    ),
							/*
								Box height settings
							*/
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Set box height:", "hgr_lang"),
								"param_name"	=>	"height_type",
								"value"			=>	array(
									__( 'Auto', 'hgr_lang' ) 	=> 'auto',
									__( 'Custom', 'hgr_lang' )	=> 'custom',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Select height option for this box.", "hgr_lang"),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Box height:", "hgr_lang"),
								"param_name"	=>	"box_height",
								"value"			=>	300,
								"min"			=>	200,
								"max"			=>	1200,
								"suffix"		=>	"px",
								"description"	=>	__("Provide box height.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"height_type",
									"value"		=>	array( "custom" ),
								),
								"save_always" 	=>	true,
							),
							/*
								Item extra class
							*/
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Extra class:", "hgr_lang"),
								 "param_name"	=>	"box_extra_class",
								 "value"		=>	"",
								 "description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang"),
								 "save_always" 	=>	true,
							),
						),
					)
				);
			}
		}
	}
	new HGR_VC_ROLLOVERPANEL;
}