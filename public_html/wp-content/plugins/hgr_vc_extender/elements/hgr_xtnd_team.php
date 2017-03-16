<?php
/*
* Add-on Name: Team Pack
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
* Update & Bug fixes: Bogdan Costescu
*/
if(!class_exists('HGR_VC_TEAM')) {
	class HGR_VC_TEAM {
		var $team_nav_color;
		var $team_nav_min_height;
		
		function __construct() {
			add_action('admin_init', array($this, 'add_team'));
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/	
		function add_team() {
			if(function_exists('vc_map')) {
				/*
					parent element
				*/
				vc_map(
					array(
					   "name"						=>	__("Team", "hgr_lang"),
					   "base"						=>	"hgr_team",
					   "class"						=>	"",
					   "icon"						=>	"hgr_team",
					   "category"					=>	__("HighGrade Extender", "hgr_lang"),
					   "as_parent"					=>	array( "only" => "hgr_team_member" ),
					   "description"				=>	__("Team block", "hgr_lang"),
					   "content_element"			=>	true,
					   "show_settings_on_create"	=>	true,
					   "params"						=>	array(
							array(
								"type"				=>	"colorpicker",
								"class"				=>	"",
								"heading"			=>	__("Team nav bar color:", "hgr_lang"),
								"param_name"		=>	"team_nav_color",
								"value"				=>	"#e2e1dc",
								"dependency"		=>	array( 
										"not_empty"=>	true 
									),
								"save_always" 	=>	true,
							),
							array(
								"type"				=>	"colorpicker",
								"class"				=>	"",
								"heading"			=>	__("Team dominant color:", "hgr_lang"),
								"param_name"		=>	"team_dominant_color",
								"value"				=>	"#80c8ac",
								"dependency"		=>	array(
										"not_empty"=>	true
									),
								"save_always" 	=>	true,
							),
							array(
								"type"				=>	"textfield",
								"class"				=>	"",
								"heading"			=>	__("Social icons size size (pixels)", "hgr_lang"),
								"param_name"		=>	"hgr_team_iconsize",
								"value"				=>	"24",
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"checkbox",
								"heading"			=>	__("Contained team", "hgr_lang"),
								"param_name"		=>	"hgr_team_contained",
								"description"		=>	__("If checked, team members will be contained, else, will be full page width. This does not apply to nav bar holding members names.", "hgr_lang"),
								"value"				=>	array( esc_html__("Yes, please", "hgr_lang") => "yes" ),
								"save_always" 		=>	true,
						    ),
							array(
								"type"				=>	"textfield",
								"class"				=>	"",
								"heading"			=>	__("Extra class", "hgr_lang"),
								"param_name"		=>	"extra_class",
								"value"				=>	"",
								"description"		=>	__("Optional extra CSS class", "hgr_lang"),
								"save_always" 		=>	true,
							),
							array(
								"type"				=>	"heading",
								"sub_heading"		=>	"This is a global setting page for the whole \"Team\" block. Add some \"Team Members\" in the container row to make it complete.",
								"param_name"		=>	"notification",
							),
					),
					"js_view"	=>	"VcColumnView"
				));
				
				
				/*
					Child element
				*/
				vc_map(
					array(
					   "name"				=>	__("Team Member", "hgr_lang"),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_team_member",
					   "class"				=>	"",
					   "icon"				=>	"",
					   "content_element"	=>	true,
					   "as_child"			=>	array( "only" => "hgr_team" ),
					   "params"			=>	array(
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Member name", "hgr_lang"),
								"param_name"	=>	"member_name",
								"value"			=>	"",
								"description"	=>	__("Provide a team member name.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Member position", "hgr_lang"),
								"param_name"	=>	"member_position",
								"value"			=>	"",
								"description"	=>	__("Member position in company", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"attach_image",
								"class"			=>	"",
								"heading"		=>	__("Member image:", "hgr_lang"),
								"param_name"	=>	"member_image",
								"admin_label"	=>	true,
								"value"			=>	"",
								"description"	=>	__("Upload member photo.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"dropdown",
								"class"			=>	"",
								"heading"		=>	__("Image style","hgr_lang"),
								"param_name"	=>	"image_style",
								"value"			=>	array(
										"Full image"		=>	"img-full",
										"Circle image"		=>	"img-circle",
										"Rounded image"	=>	"img-rounded",
									),
								"description"	=>	__("For Circle or Rounded image we reccomend a square image of 265 pixels.", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textarea_html",
								"class"			=>	"",
								"heading"		=>	__("Member intro text", "hgr_lang"),
								"param_name"	=>	"content",
								"value"			=>	"",
								"description"	=>	__("Description about this member", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Member skills", "hgr_lang"),
								"param_name"	=>	"member_skills",
								"value"			=>	"",
								"description"	=>	__( "photoshop,80|wordpress,95|php,99", "hgr_lang"),
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Dribbble", "hgr_lang"),
								"param_name"	=>	"member_dribbble",
								"value"			=>	"",
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Twitter", "hgr_lang"),
								"param_name"	=>	"member_twitter",
								"value"			=>	"",
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Facebook", "hgr_lang"),
								"param_name"	=>	"member_facebook",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Skype", "hgr_lang"),
								"param_name"	=>	"member_skype",
								"value"			=>	 "",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("LinkedIN", "hgr_lang"),
								"param_name"	=>	"member_linkedin",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Vimeo", "hgr_lang"),
								"param_name"	=>	"member_vimeo",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Yahoo", "hgr_lang"),
								"param_name"	=>	"member_yahoo",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Youtube", "hgr_lang"),
								"param_name"	=>	"member_youtube",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Picasa", "hgr_lang"),
								"param_name"	=>	"member_picasa",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("DeviantArt", "hgr_lang"),
								"param_name"	=>	"member_deviantart",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Pinterest", "hgr_lang"),
								"param_name"	=>	"member_pinterest",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("SoundCloud", "hgr_lang"),
								"param_name"	=>	"member_soundcloud",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Behance", "hgr_lang"),
								"param_name"	=>	"member_behance",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Instagram", "hgr_lang"),
								"param_name"	=>	"member_instagram",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
							array(
								"type"			=>	"textfield",
								"class"			=>	"",
								"heading"		=>	__("Google Plus", "hgr_lang"),
								"param_name"	=>	"member_googleplus",
								"value"			=>	"",
								"save_always" 	=>	true,
							),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_TEAM;
}