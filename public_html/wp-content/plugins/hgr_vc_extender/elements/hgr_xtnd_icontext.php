<?php
/*
* Add-on Name: Icon Text
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Add-on Author: Eugen Petcu
* Update & Bug fixes: Bogdan Costescu
*/
if(!class_exists('HGR_VC_ICONTEXT')) {
	class HGR_VC_ICONTEXT {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_icontext_init'));
			
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
		function hgr_icontext_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"			=>	__("HGR Icon Text", "hgr_lang"),
					   "base"			=>	"hgr_icontext",
					   "class"			=>	"",
					   "icon"			=>	"hgr_icon_text",
					   "category"		=>	__("HighGrade Extender", "hgr_lang"),
					   "description"	=>	__("Title and paragraph with icon.", "hgr_lang"),
					   "params" => array(
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Display icon:", "hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' )	=> 'selector',
										__( 'Custom Image Icon', 'hgr_lang' )	=> 'custom',
										//__( 'No icon', 'hgr_lang' ) 				=> 'no-icon',
									),
								"save_always" => true,
								"description"	=>	__("Select icon source.", "hgr_lang")
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon:", "hgr_lang"),
								"param_name"	=>	"icon",
								"value"			=>	"",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array( "selector" ),
									),
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
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),
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
										"element"		=>	"icon_type",
										"value"			=>	array( "custom" ),
									),
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
								"description"	=>	__("Provide image width", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("custom"),
									),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Color:", "hgr_lang"),
								"param_name"	=>	"icon_color",
								"value"			=>	"#222222",
								"description"	=>	__("Select prefered icon color.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array( "selector" ),
									),						
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Settings:", "hgr_lang"),
								"param_name"	=>	"icon_background_type",
								"value"			=>	array(
										__( 'None', 'hgr_lang' ) 					=> 'none',
										__( 'Select background color', 'hgr_lang' )	=> 'icon-background-select',
									),
								"save_always" 		=> true,
								"description"	=>	__("Select background settings for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array( "selector" ),
									),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Color:", "hgr_lang"),
								"param_name"	=>	"icon_background_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a background color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_background_type",
										"value"			=>	array("icon-background-select"),
									),						
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Size:", "hgr_lang"),
								"param_name"	=>	"icon_background_size",
								"value"			=>	60,
								"min"			=>	20,
								"max"			=>	100,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_background_type",
										"value"			=>	array( "icon-background-select" ),
									),
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Background Roundness:", "hgr_lang"),
								"param_name"	=>	"icon_background_roundness",
								"value"			=>	0,
								"min"			=>	0,
								"max"			=>	10,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels, example: 0 for square, or 5 for rounded corners.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_background_type",
										"value"			=>	array( "icon-background-select" ),
									),
							),
							/* Since 1.0.3.4 */
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Background border width:", "hgr_lang"),
								"param_name"	=>	"icon_background_border_width",
								"value"			=>	0,
								"min"			=>	1,
								"max"			=>	6,
								"suffix"		=>	"px",
								"description"	=>	__("Enter value in pixels.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_background_type",
										"value"			=>	array( "icon-background-select" ),
									),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Border Color:", "hgr_lang"),
								"param_name"	=>	"icon_border_color",
								"value"			=>	"#333333",
								"description"	=>	__("Pick a border color for your icon background.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"icon_background_border_width",
										"value"			=>	array("1", "2", "3", "4", "5", "6"),
									),						
							),
							/* END Since 1.0.3.4 */
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon position:", "hgr_lang"),
								"param_name"	=>	"contb_icon_position",
								"value"			=>	array(
										__( 'Top', 'hgr_lang' ) 		=> 'contb-icon-top',
										__( 'Bottom', 'hgr_lang' )	=> 'contb-icon-bottom',
										__( 'Left', 'hgr_lang' )		=> 'contb-icon-left',
										__( 'Right', 'hgr_lang' )	=> 'contb-icon-right',
									),
								"save_always" 	=> true,
								"description"	=>	__("Select icon position.", "hgr_lang"),
								"dependency"	=> 	array(
										"element"		=>	"icon_type",
										"value"			=>	array( "selector","custom" ),
									),
							),
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Element Title text:", "hgr_lang"),
								 "param_name"	=>	"content_title",
								 "value"		=>	"Optimized for speed",
								 "description"	=>	__("Insert title text here.", "hgr_lang")
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Title color:", "hgr_lang"),
								"param_name"	=>	"content_title_color",
								"value"			=>	"#222222",
								"description"	=>	__("Color of title text.", "hgr_lang"),
							),
							array(
								 "type"			=>	"textarea",
								 "class"		=>	"",
								 "heading"		=>	__("Element Description text:", "hgr_lang"),
								 "param_name"	=>	"content_description",
								 "value"		=>	"Careful attention to detail and clean, well structured code ensures a smooth user experience for all your visitors.",
								 "description"	=>	__("Insert description text here.", "hgr_lang")
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Description color:", "hgr_lang"),
								"param_name"	=>	"content_desc_color",
								"value"			=>	"#222222",
								"description"	=>	__("Color of description text.", "hgr_lang"),
							),
							array(
								 "type"			=>	"dropdown",
								 "class"		=>	"",
								 "heading"		=>	__("Link text settings:","hgr_lang"),
								 "param_name"	=>	"custom_link",
								 "value"		=>	array(
										__( 'No Link', 'hgr_lang' ) 				=> '',
										__( 'Add custom link text', 'hgr_lang' )	=> 'custom-link-on',
									),
								 "save_always" 	=> true,
								 "description"	=>	__("You can add / remove custom link.", "hgr_lang"),
								 "dependency"	=>	array(
								 		"element"		=>	"contb_icon_position",
										"value"			=>	array( "contb-icon-top","contb-icon-left","contb-icon-right" ),
									),
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("Link to:", "hgr_lang"),
								 "param_name"	=>	"address_link",
								 "value"		=>	"",
								 "description"	=>	__("Set the address to link to.", "hgr_lang"),
								 "dependency"	=>	array(
								 		"element"		=>	"custom_link", 
										"not_empty"	=>	true, 
										"value"			=>	array( "custom-link-on" ),
									),
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Link Text:","hgr_lang"),
								"param_name"	=>	"link_text",
								"value"			=>	"Read more",
								"description"	=>	__("Make sure the text clearly calls for a specific action.","hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"custom_link",
										"not_empty"	=>	true,
										"value"			=>	array( "custom-link-on" ),
									),
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Link Text Color:", "hgr_lang"),
								"param_name"	=>	"link_color",
								"value"			=>	"#222222",
								"description"	=>	__("Select the color for button text.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"custom_link",
										"not_empty"	=>	true,
										"value"			=>	array( "custom-link-on" ),
									),
							),
							array(
								 "type"			=>	"textfield",
								 "class"		=>	"",
								 "heading"		=>	__("Extra class:", "hgr_lang"),
								 "param_name"	=>	"contb_extra_class",
								 "value"		=>	"",
								 "description"	=>	__("Add extra class name. You can use this class for your customizations.", "hgr_lang")
							),
						),
					)
				);
			}
		}
	}
	new HGR_VC_ICONTEXT;
}