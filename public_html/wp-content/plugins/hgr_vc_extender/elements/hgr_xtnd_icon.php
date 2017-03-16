<?php
/*
* Add-on Name: Icon
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_ICON')) {
	class HGR_VC_ICON {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_icon_init'));
			
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
		function hgr_icon_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Icon", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_icon",
					   "class"				=>	"",
					   "icon"				=>	"hgr_icon",
					   "description"		=>	__("Icon with advanced parameters", "hgr_lang"),
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "content_element"	=>	true,
					   "params"			=>	array(
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Display icon:", "hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' ) => 'selector',
										__( 'Custom Image Icon', 'hgr_lang' ) => 'custom',
									),
								"save_always" => true,
								"description" =>	__("Select icon source.", "hgr_lang")
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select icon:", "hgr_lang"),
								"param_name"	=>	"icntxt_icon",
								"value"			=>	"icon",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),
							),
						   array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon color:", "hgr_lang"),
								"param_name"	=>	"icntxt_iconcolor",
								"value"			=>	"",
								"description"	=>	__("Select prefered icon color.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon hover color:", "hgr_lang"),
								"param_name"	=>	"icntxt_iconcolor_hover",
								"value"			=>	"",
								"description"	=>	__("Select prefered icon color on hover state.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),								
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon size:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnsize",
								"value"			=>	32,
								"min"			=>	12,
								"max"			=>	72,
								"suffix"		=>	"px",
								"description"	=>	__("Set the icon size.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload image icon:", "hgr_lang"),
								"param_name"	=>	"icontxt_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array( "custom" ),
									),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Image width:", "hgr_lang"),
								"param_name"	=>	"icontxt_img_width",
								"value"			=>	48,
								"min"			=>	16,
								"max"			=>	512,
								"suffix"		=>	"px",
								"description"	=>	__("Provide image width.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("custom"),
									),
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Settings:", "hgr_lang"),
								"param_name"	=>	"icon_background_type",
								"value"			=>	array(
										__( 'None', 'hgr_lang' ) => 'none',
										__( 'Select background color', 'hgr_lang' ) => 'icon-background-select',
									),
								"save_always" => true,
								"description"	=>	__("Select background settings for your icon.", "hgr_lang"),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Color:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbackcolor",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a background color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_background_type",
										"value"		=>	array( "icon-background-select" ),
									),						
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Hover Background Color:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbackcolor_hover",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a background color for your icon on hover state.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_background_type",
										"value"		=>	array( "icon-background-select" ),
									),						
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Size:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbacksize",
								"value"			=>	60,
								"min"			=>	20,
								"max"			=>	100,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_background_type",
									"value"		=>	array( "icon-background-select" ),
								),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Roundness:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbackroundness",
								"value"			=>	0,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels, example: 0 for square, or 5 for rounded corners.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_background_type",
									"value"		=>	array( "icon-background-select" ),
								),
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon Border Settings:", "hgr_lang"),
								"param_name"	=>	"icon_border_type",
								"value"			=>	array(
										__( 'None', 'hgr_lang' ) => 'none',
										__( 'Set border', 'hgr_lang' ) => 'icon-border-select',
									),
								"save_always" => true,
								"description"	=>	__("Select border settings for your icon.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"icon_background_type",
									"value"		=>	array( "icon-background-select" ),
								),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Border Color:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbordercolor",
								"value"			=>	"",
								"description"	=>	__("Pick a border color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_border_type",
										"value"		=>	array( "icon-border-select" ),
									),						
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Hover Border Color:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbordercolor_hover",
								"value"			=>	"",
								"description"	=>	__("Pick a border color for your icon on hover state.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_border_type",
										"value"		=>	array( "icon-border-select" ),
									),						
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Border Size:", "hgr_lang"),
								"param_name"	=>	"icntxt_icnbordersize",
								"value"			=>	1,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"icon_border_type",
										"value"		=>	array( "icon-border-select" ),
									),
							),
							array(
								 "type"			=>	"dropdown",
								 "class"		=>	"",
								 "heading"		=>	__("Link", "hgr_lang"),
								 "param_name"	=>	"custom_link",
								 "value"			=>	array(
										__( 'No Link', 'hgr_lang' ) => 'no-link',
										__( 'Add custom link to box', 'hgr_lang' ) => 'yes-link',
									),
								 "save_always" => true,
								 "description"	=>	__("You can add / remove custom link.", "hgr_lang")
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("Link ","hgr_lang"),
								 "param_name"	=>	"icntxt_link",
								 "value"		=>	"",
								 "description"	=>	__("You can add or remove the existing link from here.", "hgr_lang"),
								 "dependency"	=>	array(
								 		"element"	=>	"custom_link",
										"value"		=>	array("yes-link"),
									),
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Icon extra class:", "hgr_lang"),
								"param_name"	=>	"icntxt_extraclass",
								"value"			=>	"",
								"description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang")					
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_ICON;
}