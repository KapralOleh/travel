<?php
/*
	Shortcode: Minimal Form
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;
		
		/**
		 * Custom function AJAX wp_mail
		 */
		 
		// Logged in users have access to this function
			add_action('wp_ajax_mail_before_submit', 'send_AJAX_mail_before_submit');
		// Non logged in users have access to this function
			add_action('wp_ajax_nopriv_mail_before_submit', 'send_AJAX_mail_before_submit');
		
		function send_AJAX_mail_before_submit() {
			//$email_param = WPBMap::getParam('hgr_minimal_form', 'email_form');
			
			$to = get_option('admin_email');
			$form_fields = $_POST['whatever'];
			
			$subject = 'E-mail sent through Minimal Form on '.get_site_url();
			$message = 'Got this response from a visitor through Minimal Form on your site:'."\r\n \r\n";
			
			foreach($form_fields as $key => $value){
				$message .= $key.': '.$value."\r\n";
			}
			
			check_ajax_referer('my_email_ajax_nonce');
			if (isset($_POST['action']) && $_POST['action'] == "mail_before_submit") {
				// send email  
				wp_mail( $to, $subject, $message, $headers, $attachments );
			}
		}

		add_shortcode( 'hgr_minimal_form', 'hgr_minimal_form');
		function hgr_minimal_form($atts, $content = null ) {
			
			/*
				Include required scripts
			*/
			wp_enqueue_script('hgr-vc-modernizr');
			wp_enqueue_script('hgr-vc-classie');
			wp_enqueue_script('hgr-vc-stepsform');
			
			
			/*
				Empty vars declaration
			*/
			$output = $form_size = $form_style = $form_size_class = $label_text_size = $label_text_color = $input_text_color = $next_icon_color = $confirmation_text = $confirmation_text_size = $confirmation_text_color = $steps_text_color = $form_input_color = $progress_bar_bgcolor = $email_form = $confirmation_text_style = $progress_bar_style = $steps_text_style = $next_icon_style = $label_text_style = $input_text_style = $form_input_style = $hgr_minimal_sendmail = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'form_size'						=>	'',
				'form_style'					=>	'',
				'label_text_size'				=>	'',
				'label_text_color'				=>	'',
				'input_text_color'				=>	'',
				'next_icon_color'				=>	'',
				'confirmation_text'				=>	'',
				'confirmation_text_size'		=>	'',
				'confirmation_text_color'		=>	'',
				'steps_text_color'				=>	'',
				'form_input_color'				=>	'',
				'progress_bar_bgcolor'			=>	'',
				'email_form'					=>	''
			), $atts));
			
			switch($form_size){
				case 'large':
					$form_size_class = 'simform-large';
				break;
				
				case 'medium':
					$form_size_class = 'simform-medium';
				break;
				
				case 'small':
					$form_size_class = 'simform-small';
				break;
			}
			
			switch($form_style){
				case 'standard':
					$confirmation_text_style = '';
					$progress_bar_style = '';
					$steps_text_style = '';
					$next_icon_style = '';
					$label_text_style = '';
					$input_text_style = '';
					$form_input_style = 'rgba(0,0,0,0.1)';
				break;
				
				case 'advanced':					
					$confirmation_text_style = 'style="'.($confirmation_text_size !== '' ? 'font-size:'.$confirmation_text_size.'px;' : '').''.($confirmation_text_color !== '' ? 'color:'.$confirmation_text_color.';' : '').'"';
					$progress_bar_style = 'style="'.($progress_bar_bgcolor !== '' ? 'background:'.$progress_bar_bgcolor : '').'"';
					$steps_text_style = 'style="'.($steps_text_color !== '' ? 'color:'.$steps_text_color : '').'"';
					$next_icon_style = 'style="'.($next_icon_color !== '' ? 'color:'.$next_icon_color : '').'"';
					$label_text_style = 'style="'.($label_text_size !== '' ? 'font-size:'.$label_text_size.'px;' : '').''.($label_text_color !== '' ? 'color:'.$label_text_color.';' : '').'"';
					$input_text_style = 'style="'.($input_text_color !== '' ? 'color:'.$input_text_color : '').'"';
					$form_input_style = ($form_input_color !== '' ? $form_input_color : 'rgba(0,0,0,0.1)');
				break;
			}
			
			
			
			$GLOBALS['hgr_label_style'] = $label_text_style;
			$GLOBALS['hgr_input_text_style'] = $input_text_style;
			$GLOBALS['hgr_minimal_sendmail'] = $email_form;
			
			
			
			$output .= '<script>
				jQuery( document ).ready(function() {
					//Add form size class
					jQuery("#theForm").addClass("'.$form_size_class.'");
					
					//Add form background color
					jQuery("head").append("<style>.hgr-minimal-form .simform ol:before{background:'.$form_input_style.';}</style>");
					
					var theForm = document.getElementById( "theForm" );
					new stepsForm( theForm, {
						onSubmit : function( form ) {
							classie.addClass( theForm.querySelector( ".simform-inner" ), "hide" );
							var messageEl = theForm.querySelector( ".final-message" );
							messageEl.innerHTML = "'.$confirmation_text.'";
							classie.addClass( messageEl, "show" );
						}
					} );
					
					// Submits the form
					stepsForm.prototype._submit = function() {
						// get all the inputs into an array.
						var $inputs = jQuery("#theForm :input");

						var values = {};
						$inputs.each(function() {
							if( jQuery(this).val() != "" ) {
								values[jQuery(this).attr("data-question")] = jQuery(this).val();
							}
						});

						// send email
						var data = {
							action: "mail_before_submit",
							whatever: values,
							_ajax_nonce: "'.wp_create_nonce( "my_email_ajax_nonce" ).'"
						};

						jQuery.post("'. get_bloginfo("url").'/wp-admin/admin-ajax.php", data);
						
						// show confirmation text
						this.options.onSubmit( this.el );
					}
				});
			</script>';
			
				$output .= '<div class="hgr-minimal-form">';
					$output .= '<form id="theForm" class="simform" autocomplete="off">';
						$output .= '<div class="simform-inner">';
							$output .= '<ol class="questions">';
								$output .= do_shortcode($content);
							$output .= '</ol><!-- /questions -->';
							$output .= '<button class="submit" type="submit">Send answers</button>';
							$output .= '<div class="controls" '.$progress_bar_style.'>';
								$output .= '<button class="hgr-next-button" '.$next_icon_style.'></button>';
								$output .= '<div class="progress"></div>';
								$output .= '<span class="number" '.$steps_text_style.'>';
									$output .= '<span class="number-current"></span>';
									$output .= '<span class="number-total"></span>';
								$output .= '</span>';
								$output .= '<span class="error-message"></span>';
							$output .= '</div><!-- / controls -->';
						$output .= '</div><!-- /simform-inner -->';
						$output .= '<span class="final-message" '.$confirmation_text_style.'></span>';
					$output .= '</form><!-- /simform -->';
				$output .= '</div>';
			
			/*
				Return the output
			*/
			return $output;
		}
		
		add_shortcode( 'hgr_minimal_input', 'hgr_minimal_input');
		function hgr_minimal_input($atts,$content = null) {
			
			
			/*
				Empty vars declaration
			*/
			$output = $label_text = $input_type = $input_type_front = $hgr_question_id = $input_validate = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'label_text'			=>	'',
				'input_type'			=>	''
			), $atts));
			
			/*
				Shortcode content output
			*/
			switch($input_type){
				case 'text':
					$input_type_front = 'text';
					$input_validate = 'data-validate="none"';
				break;
				
				case 'e-mail':
					$input_type_front = 'email';
					$input_validate = 'data-validate="email"';
				break;
				
				case 'telephone':
					$input_type_front = 'tel';
					$input_validate = 'data-validate="none"';
				break;
			}
			
			$hgr_question_id = "q-".uniqid();

			$output .= '<li>';
				$output .= '<span><label for="'.$hgr_question_id.'"><h2 '.$GLOBALS["hgr_label_style"].'>'.$label_text.'</h2></label></span>';
				$output .= '<input id="'.$hgr_question_id.'" name="'.$hgr_question_id.'" type="'.$input_type_front.'" '.$GLOBALS["hgr_input_text_style"].' '.$input_validate.' data-question="'.$label_text.'"/>';
			$output .= '</li>';
			
			/*
				Return the output
			*/
			return $output;
		}
		
	if(class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_hgr_minimal_form extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_send_AJAX_mail_before_submit extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_hgr_minimal_input extends WPBakeryShortCode {}
	}
?>