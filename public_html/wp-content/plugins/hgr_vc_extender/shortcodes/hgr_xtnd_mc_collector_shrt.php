<?php
/*
	Shortcode: mailChimp Collector element
	Based on MailChimp API, version 1.3
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_mailchimpcollector', 'hgr_mchimp_collector' );
function hgr_mchimp_collector ($atts) {
			/*
				Incldue the MC API
			*/
			require_once( plugin_dir_path( dirname(__FILE__) ).'includes/apis/MCAPI.class.php');
			// plugins_url('../includes/gfx/',__FILE__);
			
			
			/*
				Empty vars declaration
			*/
			$output = $hgr_mc_apikey = $hgr_mc_listid = $hgr_mc_enable_disclaimer = $hgr_mc_collect_name = $hgr_mc_collect_lastname = 
			$hgr_mc_collect_inputbgcolor = $hgr_mc_collect_inputstextcolor = $hgr_mc_collect_btnbgcolor = $hgr_mc_collect_btntextcolor = 
			$hgr_mc_collect_nstextcolor = $extra_class = $inputs_style = $submit_style = $texts_style = '';

			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'hgr_mc_apikey'					=>	'',
				'hgr_mc_listid'					=>	'',
				'hgr_mc_enable_disclaimer'		=>	'',
				'hgr_mc_collect_name'				=>	'',
				'hgr_mc_collect_lastname'			=>	'',
				'hgr_mc_collect_inputbgcolor'	=>	'',
				'hgr_mc_collect_inputstextcolor'	=>	'',
				'hgr_mc_collect_btnbgcolor'		=>	'',
				'hgr_mc_collect_btntextcolor'	=>	'',
				'hgr_mc_collect_nstextcolor'		=>	'',
				'extra_class'						=>	'',
			), $atts));
			
			if( empty($hgr_mc_apikey) ) {return 'Please insert your MailChimp API Key!';}	
			if( empty($hgr_mc_listid) ) {return 'Please insert your MailChimp list ID!';}
			
			/*
				Text inputs color & background color
			*/
			if(!empty($hgr_mc_collect_inputbgcolor)) {
				$inputs_style .= ' background-color:'.$hgr_mc_collect_inputbgcolor.'; ';
			}
			if(!empty($hgr_mc_collect_inputstextcolor)) {
				$inputs_style .= ' color:'.$hgr_mc_collect_inputstextcolor.'; ';
			}
			/*
				Submit btn color and text color
			*/
			if(!empty($hgr_mc_collect_btnbgcolor)) {
				$submit_style .= ' background-color:'.$hgr_mc_collect_btnbgcolor.'; ';
			}
			if(!empty($hgr_mc_collect_btntextcolor)) {
				$submit_style .= ' color:'.$hgr_mc_collect_btntextcolor.'; ';
			}
			/*
				No-spam and response text color
			*/
			if(!empty($hgr_mc_collect_nstextcolor)) {
				$texts_style .= ' color:'.$hgr_mc_collect_nstextcolor.'; ';
			}
			
			if(isset($_GET['submit'])) { 
			
				$mc_response = storeAddress($hgr_mc_apikey,$hgr_mc_listid,$_GET['hgr_mc_name'],$_GET['hgr_mc_lastname'] );
				
				
			
				$output .= '<!-- Begin MailChimp Signup Form -->
					<div class="hgr_mc_collector '.$extra_class.'">
						<form id="hgr_mc_signup_'.$hgr_mc_listid.'" action="#" method="get">	  
							<span id="hgr_mc_response" class="hgr_mc_response" style="'.$texts_style.'">'.$mc_response.'</span>
							'.($hgr_mc_collect_name == 'yes' ? '<input type="text" name="hgr_mc_name" id="hgr_mc_name" class="hgr_mc_name" placeholder="'.__("Your name", 'hgr_lang').'" style="'.$inputs_style.'" />' : '<input type="hidden" name="hgr_mc_name" id="hgr_mc_name" class="hgr_mc_name" value="" style="'.$inputs_style.'" />').'
							'.($hgr_mc_collect_lastname == 'yes' ? '<input type="text" name="hgr_mc_lastname" id="hgr_mc_lastname" class="hgr_mc_lastname" placeholder="'.__("Your last name", 'hgr_lang').'" style="'.$inputs_style.'" />' : '<input type="hidden" name="hgr_mc_lastname" id="hgr_mc_lastname" class="hgr_mc_lastname" value="" />').'
							<input type="text" name="hgr_mc_email" id="hgr_mc_email" class="hgr_mc_email" placeholder="'.__("Email Address", 'hgr_lang').'" style="'.$inputs_style.'" />
							<input type="submit" name="submit" value="'.__("Join",'hgr_lang').'" class="hgr_mc_btn" style="'.$submit_style.'" />
							'.($hgr_mc_enable_disclaimer == 'yes' ? '<div class="hgr_mc_no_spam" style="'.$texts_style.'">'.__('We\'ll never spam or give this address away','hgr_lang').'</div>' :'').'
						</form>
					</div>
					<!--End mc_embed_signup-->';
			}
			else{
				$output .= '<!-- Begin MailChimp Signup Form -->
				<div class="hgr_mc_collector '.$extra_class.'">
					<form id="hgr_mc_signup_'.$hgr_mc_listid.'" action="#" method="get">	  
						'.($hgr_mc_collect_name == 'yes' ? '<input type="text" name="hgr_mc_name" id="hgr_mc_name" class="hgr_mc_name" placeholder="'.__("Your name", 'hgr_lang').'" style="'.$inputs_style.'" />' : '<input type="hidden" name="hgr_mc_name" id="hgr_mc_name" class="hgr_mc_name" value="" style="'.$inputs_style.'" />').'
						'.($hgr_mc_collect_lastname == 'yes' ? '<input type="text" name="hgr_mc_lastname" id="hgr_mc_lastname" class="hgr_mc_lastname" placeholder="'.__("Your last name", 'hgr_lang').'" style="'.$inputs_style.'" />' : '<input type="hidden" name="hgr_mc_lastname" id="hgr_mc_lastname" class="hgr_mc_lastname" value="" />').'
						<input type="text" name="hgr_mc_email" id="hgr_mc_email" class="hgr_mc_email" placeholder="'.__("Email Address", 'hgr_lang').'" style="'.$inputs_style.'" />
						<input type="submit" name="submit" value="'.__("Join",'hgr_lang').'" class="hgr_mc_btn" style="'.$submit_style.'" />
						'.($hgr_mc_enable_disclaimer == 'yes' ? '<div class="hgr_mc_no_spam" style="'.$texts_style.'">'.__('We\'ll never spam or give this address away','hgr_lang').'</div>' :'').'
					</form>
				</div>
				<!--End mc_embed_signup-->';
			}
			return $output;
		}
		
function storeAddress($your_apikey,$my_list_unique_id, $name, $surname){
		
		/*
			Validation
		*/
		if(!$_GET['hgr_mc_email']){ return "No email address provided"; } 
	
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['hgr_mc_email'])) {
			return "Email address is invalid"; 
		}
	
		/*
			Grab an API Key from http://admin.mailchimp.com/account/api/
		*/
		$api = new MCAPI($your_apikey);
		
		/*
			Grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
			Click the "settings" link for the list - the Unique Id is at the bottom of that page.
		*/ 
		
		$merge_vars = array('FNAME'=>$name, 'LNAME'=>$surname);
		
		/*
			Return the succes or error message
		*/
		if($api->listSubscribe($my_list_unique_id, $_GET['hgr_mc_email'], $merge_vars) === true) {
			/*
				It worked!
			*/
			return esc_html__("Success! Check your email to confirm sign up.", "hgr_lang");
		}else{
			/*
				An error ocurred, return error message	
			*/
			return esc_html__("Error: %s", $api->errorMessage, "hgr_lang");
		}
		
	}
?>