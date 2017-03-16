<?php
/*
* Add-on Name: Blog POsts
* Add-on URI: http://highgradelab.com/plugins/highgrade-extender/
* Since: 1.0
* Author: Eugen Petcu
*/
if(!class_exists('HGR_VC_BLOGPOSTS')) {
	class HGR_VC_BLOGPOSTS {

		function __construct() {
			add_action('admin_init', array($this, 'hgr_posts_init'));
		}
		
		/*
			Visual Composer mapping function
			Public API
			Refference:	http://kb.wpbakery.com/index.php?title=Vc_map
			Example:		http://kb.wpbakery.com/index.php?title=Visual_Composer_tutorial
		*/
		function hgr_posts_init() {
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   "name"				=>	__("HGR Blog Posts",'hgr_lang'),
					   "holder"			=>	"div",
					   "base"				=>	"hgr_blog_posts",
					   "class"				=>	"",
					   "icon"				=>	"hgr_blog_posts",
					   "category"			=>	__("HighGrade Extender",'hgr_lang'),
					   "description"		=>	__("Grid style blog posts.","hgr_lang"),
					   "content_element"	=>	true,
					   "params"			=>	array(
								array(
									"type"			=>	"textfield",
									"class"			=>	"",
									"heading"		=>	__("How many posts to fetch?", "hgr_lang"),
									"param_name"	=>	"posts_number",
									"value"			=>	"",
									"description"	=>	__("Enter the desired number of posts to fetch from blog. Recomended: 6", "hgr_lang"),
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"textfield",
									"class"			=>	"",
									"heading"		=>	__("How many posts to display on a row?", "hgr_lang"),
									"param_name"	=>	"posts_columns",
									"value"			=>	"",
									"description"	=>	__("Enter the desired number of posts to display on each row.", "hgr_lang"),
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"dropdown",
									"class"			=>	"",
									"heading"		=>	__("Display order", "hgr_lang"),
									"param_name"	=>	"display_order",
									"value"			=>	array(
										__( 'Image > Title > Text', 'hgr_lang' ) => 'img_title_txt',
										__( 'Title > Text', 'hgr_lang' ) => 'title_txt',
									),
									"save_always"	=>	true,
									"description"	=>	__("How to display posts", "hgr_lang")
								),
								array(
									"type"			=>	"dropdown",
									"class"			=>	"",
									"heading"		=>	__("Order posts by", "hgr_lang"),
									"param_name"	=>	"display_by",
									"value"			=>	array(
										__( 'Publish date', 'hgr_lang' ) => 'ordr_by_publish_date',
										__( 'Title', 'hgr_lang' ) => 'ordr_by_date',
									),
									"save_always"	=>	true,
								),
								array(
									"type"			=>	"dropdown",
									"class"			=>	"",
									"heading"		=>	__("Order", "hgr_lang"),
									"param_name"	=>	"order",
									"value"			=>	array(
										__( 'Ascending', 'hgr_lang' ) => 'ascending',
										__( 'Descending', 'hgr_lang' ) => 'descending',
									),
									"save_always"	=>	true,
								),
								array(
									"type"			=>	"dropdown",
									"class"			=>	"",
									"heading"		=>	__("Blog post title size", "hgr_lang"),
									"param_name"	=>	"blog_post_title_size",
									"value"			=>	array(
										__( 'H1', 'hgr_lang' ) => 'h1',
										__( 'H2', 'hgr_lang' ) => 'h2',
										__( 'H3', 'hgr_lang' ) => 'h3',
										__( 'H4', 'hgr_lang' ) => 'h4',
										__( 'H5', 'hgr_lang' ) => 'h5',
										__( 'H6', 'hgr_lang' ) => 'h6',
									),
									"save_always"	=>	true,
								),
								array(
									"type"			=>	"dropdown",
									"class"			=>	"",
									"heading"		=>	__("Blog post footer type", "hgr_lang"),
									"param_name"	=>	"blogpost_footer",
									"value"			=>	array(
										__( 'Icon based', 'hgr_lang' ) => 'iconbased',
										__( 'Compact', 'hgr_lang' ) => 'compact',
										__( 'Simple', 'hgr_lang' ) => 'simple',
									),
									"save_always"	=>	true,
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"hgr_left_floated",
									"heading"		=>	__("Footer background color:", "hgr_lang"),
									"param_name"	=>	"footer_bg_color",
									"value"			=>	"",	
									"dependency"	=>	array(
										"element"		=>	"blogpost_footer",
										"value"			=>	array("compact")
									),
									"save_always" 	=>	true,				
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Footer border & separators color:", "hgr_lang"),
									"param_name"	=>	"footer_sep_border_color",
									"value"			=>	"",	
									"dependency"	=>	array(
										"element"		=>	"blogpost_footer",
										"value"			=>	array("compact")
									),
									"save_always" 	=>	true,					
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Links color:", "hgr_lang"),
									"param_name"	=>	"links_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"colorpicker",
									"class"			=>	"",
									"heading"		=>	__("Background color:", "hgr_lang"),
									"param_name"	=>	"bg_color",
									"value"			=>	"",
									"save_always" 	=>	true,
								),
								array(
									"type"			=>	"textfield",
									"class"			=>	"",
									"heading"		=>	__("Extra class", "hgr_lang"),
									"param_name"	=>	"extra_class",
									"value"			=>	"",
									"description"	=>	__("Extra CSS class for custom CSS", "hgr_lang")	,
									"save_always" 	=>	true,
								),
					   )
					) 
				);
			}
		}
	}
	new HGR_VC_BLOGPOSTS;
}