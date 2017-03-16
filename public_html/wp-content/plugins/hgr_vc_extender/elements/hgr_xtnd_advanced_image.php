<?php
/*
* Add-on Name: Advanced Image
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_ADVIMAGE')) {
	class HGR_VC_ADVIMAGE {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_advimage_init'));
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function hgr_advimage_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Advanced Image", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_advimage",
					   "class"				=>	"",
					   "icon"				=>	"hgr_advimage",
					   "description"		=>	__("Image with advanced parameters", "hgr_lang"),
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "content_element"	=>	true,
					   "params"			=>	array(
					   		array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Image:", "hgr_lang"),
								"param_name"	=>	"hgr_advimage_image",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload or select image to use", "hgr_lang"),
								"save_always" 	=>	true,
							),
						   array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Image overlay color:", "hgr_lang"),
								"param_name"	=>	"hgr_advimage_overlaycolor",
								"value"			=>	"",
								"description"	=>	__("Select overlay color on mouseover image.", "hgr_lang"),
								"save_always" 	=>	true,					
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Overlay text color:", "hgr_lang"),
								"param_name"	=>	"hgr_advimage_overlaytextcolor",
								"value"			=>	"#000000",
								"description"	=>	__("Select overlay text color.", "hgr_lang"),
								"save_always" 	=>	true,				
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("General link on overlay","hgr_lang"),
								 "param_name"	=>	"hgr_advimage_overlaylink",
								 "value"		=>	"",
								 "description"	=>	__("Optional link on overlay","hgr_lang"),
								 "save_always" 	=>	true,
							),
							array(
								 "type"			=>	"textarea",
								 "class"		=>	"",
								 "heading"		=>	__("Overlay content:","hgr_lang"),
								 "param_name"	=>	"hgr_advimage_overlaycontent",
								 "value"		=>	"",
								 "description"	=>	__("Insert the content to be displayed on image hover.","hgr_lang"),
								 "save_always" 	=>	true,
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_ADVIMAGE;
}