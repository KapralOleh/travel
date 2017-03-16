<?php
/*
	Shortcode: Twitter Feed element
	Based on: https://github.com/J7mbo/twitter-api-php/wiki/Twitter-API-PHP-Wiki
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_twitterfeed', 'hgr_twitter_feed');
function hgr_twitter_feed ($atts) {
	
	/*
		Incldue the TWITTER API
	*/
	require_once( plugin_dir_path( dirname(__FILE__) ).'includes/apis/TwitterAPIExchange.php');
	
	/*
		Include required scripts
	*/
	wp_enqueue_script('hgr-vc-jquery-appear');
	wp_enqueue_script('hgr-vc-tweetfeed');
	
	/*
		Empty vars declaration
	*/
	$output = $hgr_twitter_username = $hgr_tweetfeed_username_color = $hgr_tweetfeed_text_color = $twitter_api_key = 
	$twitter_api_secret = $twitter_acces_token = $twitter_acces_token_secret = $hgr_twitfeed_refresh_time = 
	$hgr_twitfeed_cnct_timeout = $extra_class = '';
	
	
	/*
		WordPress function to extract shortcodes attributes
		Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
	*/
	extract(shortcode_atts(array(
		'hgr_twitter_username'			=>	'',
		'hgr_tweetfeed_username_color'	=>	'',
		'hgr_tweetfeed_text_color'		=>	'',
		'twitter_api_key'					=>	'', 
		'twitter_api_secret'				=>	'',
		'twitter_acces_token'				=>	'',
		'twitter_acces_token_secret'		=>	'',
		'hgr_twitfeed_refresh_time'		=>	'',
		'hgr_twitfeed_cnct_timeout'		=>	'',
		'extra_class'						=>	'',
	), $atts));
	
	if( empty($hgr_twitter_username) ) {
		return 'Please insert your Twitter Username!';
	}

	/*
		Check last update time on database
	*/
	$latest_tweets = get_option( 'hgr_latest_tweets' );
	
	//die(print_r($latest_tweets->errors));
	
	/*
		If no api key provided, exit
	*/
	if( !empty($latest_tweets->errors) ) {
						
						return $latest_tweets->errors[0]->message;
					}
	
	/*
		If no api key provided, exit
	*/
	if( empty($hgr_twitter_username) || empty($twitter_api_key) || empty($twitter_api_secret) || empty($twitter_acces_token) || empty($twitter_acces_token_secret) ) {
		return esc_html__('<p>No API Key! Go to the <a href="https://dev.twitter.com/apps" target="_blank">My applications page</a> on the Twitter website to set up your website as a new Twitter "application". You may need to log-in using your Twitter user name and password.</p>',"hgr_lang");
	}
	
			
	/*
		If no latest tweets or too old...
	*/
	if(!$latest_tweets) {
		/*
			Get the tweets...
		*/
		$get_tweets = hgr_refresh_tweedfeed($hgr_twitter_username, $twitter_api_key, $twitter_api_secret, $twitter_acces_token, $twitter_acces_token_secret);
		
		// It's OK? 
		// TO DO: Format the output...
		$latest_tweets = json_decode($get_tweets);
		
		//die(print_r($latest_tweets));
		
		// Add timestamp to feed...
		$latest_tweets->lastupdate = current_time( 'timestamp' );
		
		// Save it to database...
		update_option('hgr_latest_tweets', $latest_tweets);
	} 
	else {
		// Is OLD? Renew...
		if( $latest_tweets->lastupdate + $hgr_twitfeed_refresh_time < current_time( 'timestamp' ) ){
			// Renew...
			$get_tweets = hgr_refresh_tweedfeed($hgr_twitter_username, $twitter_api_key, $twitter_api_secret, $twitter_acces_token, $twitter_acces_token_secret);
			// It's OK? 
			// TO DO: Format the output...
			$latest_tweets = json_decode($get_tweets);
			
			// Add timestamp to feed...
			$latest_tweets->lastupdate = current_time( 'timestamp' );
			
			// Save it to database...
			update_option('hgr_latest_tweets', $latest_tweets);
		}
		else {
			$latest_tweets = get_option('hgr_latest_tweets');
		}
	}
	
			// Layout the tweets...
			$tweets_array = $latest_tweets;
			

	
			

			$output .='<div class="hgr_tweetfeed '.$extra_class.'">';
				
				if(!empty($tweets_array)) {
					
					if( !empty($tweets_array->errors) ) {
						
						return $tweets_array->errors[0]->message;
					}
					
					$i=0;
					foreach($tweets_array as $tweet) {
						if(!empty($tweet->user->screen_name) && !empty($tweet->text)) {
							$output .= '<div class="hgr_tweet" style="display: '.($i==0?'block':'none').';">';
								$output .= '<div class="hgr_tweet_content"><span class="hgr_tweet_screen_name"><a href="https://twitter.com/'.$tweet->user->screen_name.'" target="_blank" style="color:'.$hgr_tweetfeed_username_color.';">@'.$tweet->user->screen_name.'</a></span> <span style="color:'.$hgr_tweetfeed_text_color.';">... '.HGR_XTND::make_links_clickable($tweet->text, $hgr_tweetfeed_username_color).'</span></div>';
								$output .= '<div class="hgr_tweet_time" style="color:'.$hgr_tweetfeed_username_color.';">About '.HGR_XTND::hgr_xtnd_tes($tweet->created_at).'</div>';
							$output .= '</div>';
						}
						$i++;
					}
				}
				else {
					
					return esc_html__('No available tweets for the moment! Please tweet something first.', "hgr_lang");
				}
			$output .='</div>';
			
			// Return it to browser...
			return $output;
		}
		
function hgr_refresh_tweedfeed($hgr_twitter_username, $twitter_api_key, $twitter_api_secret, $twitter_acces_token, $twitter_acces_token_secret){
		$settings = array(
			'oauth_access_token' => $twitter_acces_token,
			'oauth_access_token_secret' => $twitter_acces_token_secret,
			'consumer_key' => $twitter_api_key,
			'consumer_secret' => $twitter_api_secret
		);
		
		/** Perform a GET request and echo the response **/
		/** Note: Set the GET field BEFORE calling buildOauth(); **/
		//$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		$url = "https://api.twitter.com/1.1/statuses/home_timeline.json";
		$getfield = '?screen_name='.$hgr_twitter_username;
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$echo = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
		
		return $echo;
	}
		
?>