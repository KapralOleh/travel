<?php
/*
	Shortcode: gMap element
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode('hgr_gmap', 'hgr_g_map');
function hgr_g_map($atts) {
			
			/*
				 Empty vars declaration
			*/
			$output = $gmap_name = $gmap_latitude = $gmap_longitude = $gmap_zoom = $gmap_style = $gmap_width = $gmap_height = $gmap_disablezoom = $scrollwheel = $gmap_extra_class = $gmap_style_var = $marker_url = $marker_img = '';
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts( array(
				'gmap_name'				=>	'',
				'gmap_latitude'			=>	'',
				'gmap_longitude'			=>	'',
				'gmap_zoom'				=>	'',
				'gmap_width'				=>	'',
				'gmap_height'				=>	'',
				'gmap_disablezoom'			=>	'',
				'gmap_extra_class'			=>	'',
				'gmap_style'				=>	'',
				'gmap_marker_settings'	=>	'',
				'marker_image'				=>	'',
			),$atts));
			
			switch($gmap_style){
				case 'gmap_style_greyscale':
					$gmap_style_var = 'var featureOpts = [
											{
											  stylers: [
												{ "visibility": "on" },
												{ "weight": 1 },
												{ "saturation": -100 },
												{ "lightness": -8 },
												{ "gamma": 1.18 }
											  ]
											}
										];';
				break;
				
				case 'gmap_style_normal':
					$gmap_style_var = 'var featureOpts = [
											{
											  stylers: [
												{ "visibility": "on" },
												{ "weight": 1.1 },
												{ "saturation": 1 },
												{ "lightness": 1 },
												{ "gamma": 1 }
											  ]
											}
										];';
				break;
			}
			
			if($gmap_marker_settings == "gmap_marker_plugin"){
				$marker_url = plugins_url("../includes/gfx/elements-images/gmap-marker-hgr.png",__FILE__);
			} elseif($gmap_marker_settings == "gmap_marker_default"){
				$marker_url = "";
			} elseif($gmap_marker_settings == "gmap_marker_custom") {
				$marker_img = wp_get_attachment_image_src( $marker_image, 'large');
				$marker_url = $marker_img[0];
			}
			
			if($gmap_disablezoom == 'yes')
			{
				$scrollwheel = 'false';
			}
			elseif($gmap_disablezoom !== 'yes')
			{
				$scrollwheel = 'true';
			}
			
			$id = "hgr".uniqid();
			$output .= '<script>
							var map_'.$id.';
							var gmap_location_'.$id.' = new google.maps.LatLng('.$gmap_latitude.', '.$gmap_longitude.');

							var GMAP_MODULE_'.$id.' = "custom_style";

							function initialize() {
								
								'.$gmap_style_var.'

								var mapOptions = {
									zoom: '.$gmap_zoom.',
									scrollwheel: '.$scrollwheel.',
									center: gmap_location_'.$id.',
									mapTypeControlOptions: {
										mapTypeIds: [google.maps.MapTypeId.ROADMAP, GMAP_MODULE_'.$id.']
									},
									mapTypeId: GMAP_MODULE_'.$id.'
								};

								map_'.$id.' = new google.maps.Map(document.getElementById("'.$id.'"), mapOptions);
								
								marker_'.$id.' = new google.maps.Marker({
									map: map_'.$id.',
									draggable: false,
									animation: google.maps.Animation.DROP,
									position: gmap_location_'.$id.',
									icon: "'.$marker_url.'"
								  });

								google.maps.event.addListener(marker_'.$id.', "click", function() {
									if (marker_'.$id.'.getAnimation() != null) {
										marker_'.$id.'.setAnimation(null);
									} else {
										marker_'.$id.'.setAnimation(google.maps.Animation.BOUNCE);
									}
								});

								var styledMapOptions = {
									name: "'.$gmap_name.'"
								};

								var customMapType_'.$id.' = new google.maps.StyledMapType(featureOpts, styledMapOptions);

								map_'.$id.'.mapTypes.set(GMAP_MODULE_'.$id.', customMapType_'.$id.');
							}

							google.maps.event.addDomListener(window, "load", initialize);

						</script>';

			$output .= '<div id="'.$id.'" class="hgr-map-canvas '.$gmap_extra_class.'" style="width:'.$gmap_width.';height:'.$gmap_height.';"></div>';
			
			/*
				Return the output
			*/
			return $output;		
		}
?>