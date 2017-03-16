<?php
/*
* Add-on Name: HGR Progress Bar
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Based on Bootstrap
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_PROGRESSBAR')) {
	class HGR_VC_PROGRESSBAR {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_progressbar_init'));
			
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
		function hgr_progressbar_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Progress Bar", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_progressbar",
					   "class"				=>	"",
					   "icon"				=>	"hgr_progressbar",
					   "description"		=>	__("Progress bar with advanced parameters", "hgr_lang"),
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "content_element"	=>	true,
					   "params"				=>	array(
						   array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon Type:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_icontype",
								"value"			=>	array(
										__( 'Font Icon Browser', 'hgr_lang' )	=> 'selector',
										__( 'Custom Image Icon', 'hgr_lang' )	=> 'custom',
									),
								"save_always" 	=> true,
								"description"	=>	__("Use an existing font icon or upload a custom image.", "hgr_lang"),
							),
							array(
								"type"			=>	 "icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_icon",
								"value"			=>	"icon",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"hgr_progressbar_icontype",
										"value"			=>	array( "selector" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Icon Size:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_icnsize",
								"value"			=>	25,
								"min"			=>	12,
								"max"			=>	72,
								"suffix"		=>	"px",
								"description"	=>	__("Select icon size.", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"hgr_progressbar_icontype",
										"value"			=>	array( "selector" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Icon Color:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_icncolor",
								"value"			=>	"#222222",
								"description"	=>	__("Select prefered color for your icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"hgr_progressbar_icontype",
										"value"		=>	array( "selector" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload Image Icon:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"hgr_progressbar_icontype",
										"value"		=>	array( "custom" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Image Icon Width:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_imgwidth",
								"value"			=>	48,
								"min"			=>	16,
								"max"			=>	512,
								"suffix"		=>	"px",
								"description"	=>	__("Provide image width.", "hgr_lang"),
								"dependency"	=>	array(
										"element"	=>	"hgr_progressbar_icontype",
										"value"		=>	array( "custom" ),
									),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Title:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_title",
								"value"			=>	"Awesome Progress Bar",
								"description"	=>	__("Title for progress bar.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Title Color:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_title_color",
								"value"			=>	"#808080",
								"description"	=>	__("Select color for progress bar title.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Base Color:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_basecolor",
								"value"			=>	"#808080",
								"description"	=>	__("Bar background color.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Fill Color:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_color",
								"value"			=>	"#F9464A",
								"description"	=>	__("Bar fill color.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Value:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_value",
								"value"			=>	50,
								"min"			=>	0,
								"max"			=>	100,
								"suffix"		=>	"%",
								"description"	=>	__("Progress bar filling value %.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Filling Time:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_filltime",
								"value"			=>	1,
								"min"			=>	1,
								"max"			=>	15,
								"suffix" 		=>	"seconds",							
								"description"	=>	__("Filling duration measured in seconds.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"number",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Weight:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_weight",
								"value"			=>	3,
								"min"			=>	1,
								"max"			=>	30,
								"suffix"		=>	"px",
								"description"	=>	__("The bar weight in pixels.", "hgr_lang"),	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Progress Bar Style:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_type",
								"value"			=>	array(
										__( 'Simple', 'hgr_lang' )					=> '',
										__( 'With Stripes', 'hgr_lang' )				=> 'hgr_striped',
										__( 'With Animated Stripes', 'hgr_lang' )	=> 'hgr_striped hgr_animated_striped',
									),
								"save_always" 	=> true,
								"description"	=>	__("Select progress bar style from the dropdown.", "hgr_lang"),
							),
							array(
								"type"			=>	"checkbox",
								"heading"		=>	__("Hide progress bar value marker:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_marker",
								"description"	=>	__("If checked this will hide value marker.", "hgr_lang"),
								"value"			=>	array( esc_html__("Yes, please", "hgr_lang") => "yes" ),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra Class:", "hgr_lang"),
								"param_name"	=>	"hgr_progressbar_extraclass",
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
	new HGR_VC_PROGRESSBAR;
}
