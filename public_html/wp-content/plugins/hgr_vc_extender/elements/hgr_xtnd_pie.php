<?php
/*
* Add-on Name: Pie Chart
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Based on Rendro Easy Pie Chart: https://github.com/rendro/easy-pie-chart
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_PIE')) {
	class HGR_VC_PIE {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_pie_init'));
		}
		
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/	
		function hgr_pie_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Pie Chart", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_pie_chart",
					   "class"				=>	"",
					   "icon"				=>	"hgr_pie_chart",
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "description"		=>	__("Animated pie chart", "hgr_lang"),
					   "front_enqueue_js"	=>	"",
					   "content_element"	=>	true,
					   "params"			=>	array(
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Pie title", "hgr_lang"),
								"param_name"	=>	"pie_title",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textarea_html",
								"class"			=>	"",
								"heading"		=>	__("Pie text", "hgr_lang"),
								"param_name"	=>	"pie_text",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("Pie link to","hgr_lang"),
								 "param_name"	=>	"gotourl",
								 "value"		=>	"",
								 "description"	=>	__("Link pie text to URL.", "hgr_lang"),
								 "save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Pie size", "hgr_lang"),
								"param_name"	=>	"pie_size",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Bar width", "hgr_lang"),
								"param_name"	=>	"bar_width",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Pie percent", "hgr_lang"),
								"param_name"	=>	"pie_percent",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Pie percent font size", "hgr_lang"),
								"param_name"	=>	"hgr_pie_percent_size",
								"value"			=>	"30",
								"description"	=>	__("Enter value in pixels, example: 30", "hgr_lang")	,
								"save_always" 	=>	true,		
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Back line color:", "hgr_lang"),
								"param_name"	=>	"back_line_color",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Front line color:", "hgr_lang"),
								"param_name"	=>	"front_line_color",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Scale color:", "hgr_lang"),
								"param_name"	=>	"scale_color",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon to display:", "hgr_lang"),
								"param_name"	=>	"icon_type",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' ) => 'selector',
										__( 'Custom Image Icon', 'hgr_lang' ) => 'custom',
									),
								"save_always"	=> true,
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon", "hgr_lang"),
								"param_name"	=>	"icon",
								"value"			=>	"",
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
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
										"element"		=>	"icon_type",
										"value"			=>	array("custom"),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon color:", "hgr_lang"),
								"param_name"	=>	"icon_color",
								"value"			=>	"#808080",
								"dependency"	=>	array(
										"element"		=>	"icon_type",
										"value"			=>	array("selector"),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Icon size", "hgr_lang"),
								"param_name"	=>	"hgr_pie_icnsize",
								"value"			=>	"",
								"description"	=>	__("Enter value in pixels, example: 30", "hgr_lang")	,
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra class", "hgr_lang"),
								"param_name"	=>	"hgr_pie_extraclass",
								"value"			=>	"",
								"description"	=>	__("Enter a extra css class for this element, if you wish to override default css settings", "hgr_lang"),
								"save_always" 	=>	true,
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_PIE;
}