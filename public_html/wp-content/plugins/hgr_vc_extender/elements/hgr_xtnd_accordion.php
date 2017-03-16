<?php
/*
* Add-on Name: HGR Accordion
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
* Update & Bug fixes: Bogdan Costescu
*/
if(!class_exists('HGR_VC_ACCORDION')) {
	class HGR_VC_ACCORDION {
		
		function __construct() {
			add_action('admin_init', array($this, 'add_accordion'));
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function add_accordion() {
			if(function_exists('vc_map')) {
				/*
					Accordion: Parent element
				*/
				vc_map(
					array(
					   "name"						=>	__("HGR Accordion","hgr_lang"),
					   "base"						=>	"hgr_accordion",
					   "class"						=>	"",
					   "icon"						=>	"hgr_accordion",
					   "category"					=>	__("HighGrade Extender","hgr_lang"),
					   "as_parent"					=>	array( 'only'	=>	'hgr_accordion_element' ),
					   "description"				=>	__("Accordion block","hgr_lang"),
					   "content_element"			=>	true,
					   "show_settings_on_create"	=>	true,
					   "params" => array(
							array(
								"type" 			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Panels header background color:", "hgr_lang"),
								"param_name"	=>	"acc_panel_color",
								"value"			=>	"#fff",
								"dependency"	=>	array( "not_empty" => true ),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Panels body background color:", "hgr_lang"),
								"param_name"	=>	"acc_panelbody_color",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Panels header text color:", "hgr_lang"),
								"param_name"	=>	"acc_panelheader_textcolor",
								"value"			=>	"#000",
								"dependency"	=>	array( "not_empty"	=>	true ),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Panels body text color:", "hgr_lang"),
								"param_name"	=>	"acc_panelbody_textcolor",
								"value"			=>	"#000",
								"dependency"	=>	array( "not_empty" => true ),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Panel header height","hgr_lang"),
								"param_name"	=>	"acc_panel_header_height",
								"value"			=>	"30",
								"description"	=>	__("Panel header height in pixels","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Panel header roundness","hgr_lang"),
								"param_name"	=>	"acc_panel_header_roundness",
								"value"			=>	"",
								"description"	=>	__("Panel header roundness in pixels. Example: 4","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra class","hgr_lang"),
								"param_name"	=>	"extra_class",
								"value"			=>	"",
								"description"	=>	__("Optional extra CSS class","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Unique ID for this accordion","hgr_lang"),
								"param_name"	=>	"acc_unique_id",
								"value"			=>	'accid'.mt_rand(999, 9999999),
								"description"	=>	__("Unique ID for this accordion, useful for extra CSS or JS customnization. This is auto-generated or you can enter your own.","hgr_lang"),
								"dependency"	=>	array( "not_empty" => true ),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"heading",
								"sub_heading"	=>	__("This is a global setting page for the whole \"Accordion\" block. Add some \"Accordion elements (tabs)\" in the container row to make it complete.", "hgr_lang"),
								"param_name"	=>	"notification",
							),
						),
						"js_view" => 'VcColumnView'
					)
				);
				
				
				/*
					Accordion: Child element
				*/
				vc_map(
					array(
					   "name"				=>	__("Accordion element","hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_accordion_element",
					   "class"				=>	"",
					   "icon"				=>	"",
					   "content_element"	=>	true,
					   "as_child"			=>	array( "only"	=>	"hgr_accordion" ),
					   "params"			=>	array(
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon type", "hgr_lang"),
								"param_name"	=>	"hgr_accordion_icontype",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' ) 	=> 'selector',
										__( 'Custom Image Icon', 'hgr_lang' )	=> 'custom',
									),
								"save_always" 	=> true,
								"description"	=>	__("Use an existing font icon or upload a custom image.", "hgr_lang")
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon ","hgr_lang"),
								"param_name"	=>	"hgr_accordion_icon",
								"value"			=>	"icon",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
									"element"		=>	"hgr_accordion_icontype",
									"value"			=>	array("selector")
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon color:", "hgr_lang"),
								"description"	=>	__("Icon color","hgr_lang"),
								"param_name"	=>	"acc_icon_color",
								"value"			=>	"#80c8ac",
								"dependency"	=>	array(
									"not_empty"	=>	true,
									"element"		=>	"hgr_accordion_icontype",
									"value"			=>	array( "selector" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Icon size", "hgr_lang"),
								"param_name"	=>	"hgr_accordion_icnsize",
								"value"			=>	"",
								"description"	=>	__("Enter value in pixels, example: 30", "hgr_lang"),
								"dependency"	=>	array(
									"element"		=>	"hgr_accordion_icontype",
									"value"			=>	array( "selector" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload Image Icon:", "hgr_lang"),
								"param_name"	=>	"hgr_accordion_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
									"element"		=>	"hgr_accordion_icontype",
									"value"			=>	array( "custom" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Panel Title","hgr_lang"),
								"param_name"	=>	"panel_title",
								"value"			=>	"Panel Title",
								"description"	=>	__("Provide a unique title for this panel","hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textarea_html",
								"class"			=>	"",
								"heading"		=>	__("Panel content","hgr_lang"),
								"param_name"	=>	"content",
								"value"			=>	"Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
								"description"	=>	__("Content to be visible when proper tab is selected","hgr_lang"),
								"save_always" 	=>	true,
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_ACCORDION;
}