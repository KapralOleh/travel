<?php
/*
* Add-on Name: HGR Button
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_BUTTON')) {
	class HGR_VC_BUTTON {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_button_init'));
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function hgr_button_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Button", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_button",
					   "class"				=>	"",
					   "icon"				=>	"hgr_button",
					   "description"		=>	__("Very configurable button", "hgr_lang"),
					   "category"			=>	__("HighGrade Extender", "hgr_lang"),
					   "content_element"	=>	true,
					   "params"	=>	array(
						   array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Text on the button", "hgr_lang"),
								"param_name"	=>	"hgr_buttontext",
								"value"			=>	__("Buy now!", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Text size (pixels)", "hgr_lang"),
								"param_name"	=>	"hgr_buttontextsize",
								"value"			=>	"14",
								"save_always" 	=>	true,
							),
							array(
								 "type"			=>	"vc_link",
								 "class"		=>	"",
								 "heading"		=>	__("Button action URL","hgr_lang"),
								 "param_name"	=>	"hgr_buttonurl",
								 "value"		=>	"",
								 "description"	=>	__("Set button link here.", "hgr_lang"),
								 "save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button text color", "hgr_lang"),
								"param_name"	=>	"hgr_buttontextcolor",
								"value"			=>	"#808080",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button text color on hover", "hgr_lang"),
								"param_name"	=>	"hgr_buttontexthovercolor",
								"value"			=>	"#808080",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button color", "hgr_lang"),
								"param_name"	=>	"hgr_buttoncolor",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button color on hover", "hgr_lang"),
								"param_name"	=>	"hgr_buttoncolorhover",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Button width", "hgr_lang"),
								"description"	=>	__("Insert only numeric values",'hgr_lang'),
								"param_name"	=>	"hgr_buttonwidth",
								"value"			=>	"100",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Button width units", "hgr_lang"),
								"param_name"	=>	"hgr_buttonwidthunits",
								"value"			=>	array(	
									__( 'Pixels', 'hgr_lang' )	=> 'px',
									__( 'Percent', 'hgr_lang' )	=> '%',
									__( 'Ems', 'hgr_lang' )		=> 'em',
								),
								"save_always" 	=> true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Button height", "hgr_lang"),
								"description"	=>	__("Insert only numeric values",'hgr_lang'),
								"param_name"	=>	"hgr_buttonheight",
								"value"			=>	"60",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Button height units", "hgr_lang"),
								"param_name"	=>	"hgr_buttonheightunits",
								"value"			=>	array(
									__( 'Pixels', 'hgr_lang' ) 	=> 'px',
									__( 'Percent', 'hgr_lang' )	=> '%',
									__( 'Ems', 'hgr_lang' )		=> 'em',
								),
								"save_always" 	=> true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Button border weight", "hgr_lang"),
								"description"	=>	__("Insert only numeric values. Pixels will be used.",'hgr_lang'),
								"param_name"	=>	"hgr_buttonborderweight",
								"value"			=>	"1",	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button border color", "hgr_lang"),
								"param_name"	=>	"hgr_buttonbodercolor",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"colorpicker",
								"class"			=>	"",
								"heading"		=>	__("Button border color on hover", "hgr_lang"),
								"param_name"	=>	"hgr_buttonbordercolorhover",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Button roundness", "hgr_lang"),
								"description"	=>	__("Insert only numeric values",'hgr_lang'),
								"param_name"	=>	"hgr_buttonroundness",
								"value"			=>	"4",	
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon", "hgr_lang"),
								"param_name"	=>	"hgr_hasicon",
								"value"			=>	array(
									__( 'No icon', 'hgr_lang' ) 	=> 'noicon',
									__( 'Use icon', 'hgr_lang' )	=> 'withicon',
								),
								"save_always" 	=> true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon position", "hgr_lang"),
								"param_name"	=>	"hgr_iconposition",
								"value"			=>	array(
									__( 'Left', 'hgr_lang' ) 	=> 'left',
									__( 'Right', 'hgr_lang' )	=> 'right',
								),
								"save_always" 	=>	true,
								"dependency"	=>	array(
									"element"	=>	"hgr_hasicon",
									"value"		=>	array( "withicon")
								),
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon type", "hgr_lang"),
								"param_name"	=>	"hgr_button_icontype",
								"value"			=>	array(
									__( 'Font Icon Browser', 'hgr_lang' ) 	=> 'selector',
									__( 'Custom Image Icon', 'hgr_lang' )	=> 'custom',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Use an existing font icon or upload a custom image.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"hgr_hasicon",
									"value"		=>	array( "withicon" )
								),
							),
							array(
								"type"			=>	"icon_browser",
								"class"			=>	"",
								"heading"		=>	__("Select Icon ","hgr_lang"),
								"param_name"	=>	"hgr_button_icon",
								"value"			=>	"icon",
								"description"	=>	__("Click on an icon to select it.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"hgr_button_icontype",
									"value"		=>	array( "selector" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Upload Image Icon:", "hgr_lang"),
								"param_name"	=>	"hgr_button_img",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload the custom image icon.", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"hgr_button_icontype",
									"value"		=>	array( "custom" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Icon animation", "hgr_lang"),
								"param_name"	=>	"hgr_button_iconanimation",
								"value"			=>	array(
									__( 'No animation', 'hgr_lang' ) 	=> 'noanimation',
									__( 'Spin', 'hgr_lang' )				=> 'hgr_fa-spin',
									__( 'Rotate 90', 'hgr_lang' )		=> 'hgr_fa-rotate-90',
									__( 'Rotate 180', 'hgr_lang' )		=> 'hgr_fa-rotate-180',
									__( 'Rotate 270', 'hgr_lang' )		=> 'hgr_fa-rotate-270',
									__( 'Flip horizontal', 'hgr_lang' )	=> 'hgr_fa-flip-horizontal',
									__( 'Flip vertical', 'hgr_lang' )	=> 'hgr_fa-flip-vertical',
								),
								"save_always" 	=>	true,
								"description"	=>	__("Does not apply to all icons!", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"hgr_hasicon",
									"value"		=>	array( "withicon" )
								),
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Animate icon on", "hgr_lang"),
								"param_name"	=>	"hgr_button_iconanimationon",
								"value"			=>	array(
									__( 'Always', 'hgr_lang' ) 	=> 'always',
									__( 'On hover', 'hgr_lang' )	=> 'onhover',
								),
								"save_always" 	=> true,
								"description"	=>	__("Does not apply to all icons/animations!", "hgr_lang"),
								"dependency"	=>	array(
										"element"		=>	"hgr_button_iconanimation",
										"value"		=>	array(
											"hgr_fa-spin",
											"hgr_fa-rotate-90",
											"hgr_fa-rotate-180",
											"hgr_fa-rotate-270",
											"hgr_fa-flip-horizontal",
											"hgr_fa-flip-vertical",
										)
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Icon size", "hgr_lang"),
								"param_name"	=>	"hgr_button_iconsize",
								"value"			=>	"",
								"description"	=>	__("Enter value in pixels, example: 24", "hgr_lang"),
								"dependency"	=>	array(
									"element"	=>	"hgr_hasicon",
									"value"		=>	array( "withicon" )
								),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Extra class", "hgr_lang"),
								"param_name"	=>	"hgr_button_extraclass",
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
	new HGR_VC_BUTTON;
}