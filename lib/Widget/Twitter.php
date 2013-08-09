<?php

class Theme_Widget_Twitter extends WP_Widget
{
  public function __construct()
  {
    
    $this->options = array(
			array(
				'label' => __( 'Twitter Authentication options', 'wse' ),
				'type'	=> 'separator', 	'notes' => __('Get them creating your Twitter Application', 'wse' ).' <a href="https://dev.twitter.com/apps" target="_blank">'.__('here', 'wse' ).'</a><br /><br />'	),
			array(
				'name'	=> 'consumer_key',	'label'	=> 'Consumer Key',
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'consumer_secret',	'label'	=> 'Consumer Secret',
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'access_token',	'label'	=> 'Access Token',
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'access_token_secret',	'label'	=> 'Access Token Secret',
				'type'	=> 'text',	'default' => ''			),
			array(
				'label' => __( 'Twitter data options', 'wse' ),
				'type'	=> 'separator'			),
			array(
				'name'	=> 'username',		'label'	=> __( 'Twitter Username', 'wse' ),
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'num',			'label'	=> __( 'Show # of Tweets', 'wse' ),
				'type'	=> 'text',	'default' => '5'			),
			array(
				'name'	=> 'skip_text',		'label'	=> __( 'Skip tweets containing this text', 'wse' ),
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'skip_replies',		'label'	=> __( 'Skip replies', 'wse' ),
				'type'	=> 'checkbox',	'default' => true	),
			array(
				'name'	=> 'skip_retweets',		'label'	=> __( 'Skip retweets', 'wse' ),
				'type'	=> 'checkbox',	'default' => false	),
			array(
				'label' => __( 'Widget title options', 'wse' ),
				'type'	=> 'separator'			),
			array(
				'name'	=> 'title',	'label'	=> __( 'Title', 'wse' ),
				'type'	=> 'text',	'default' => __( 'Last Tweets', 'wse' )			),
			array(
				'name'	=> 'title_icon',	'label'	=> __( 'Show Twitter icon on title', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'name'	=> 'link_title',	'label'	=> __( 'Link above Title with Twitter user', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'label' => __( 'Links and display options', 'wse' ),
				'type'	=> 'separator'			),
			array(
				'name'	=> 'linked',		'label'	=> __( 'Show this linked text at the end of each Tweet', 'wse' ),
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'update',	'label'	=> __( 'Show timestamps', 'wse' ),
				'type'	=> 'checkbox',	'default' => true			),
			array(
				'name'	=> 'thumbnail',	'label'	=> __( 'Include thumbnail before tweets', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),			
			array(
				'name'	=> 'thumbnail_retweets',	'label'	=> __( 'Use author thumb for retweets', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),			
			array(
				'name'	=> 'hyperlinks',	'label'	=> __( 'Find and show hyperlinks', 'wse' ),
				'type'	=> 'checkbox',	'default' => true			),
			array(
				'name'	=> 'replace_link_text',	'label'	=> __( 'Replace hyperlinks text inside tweets with fixed text (e.g. "-->")', 'wse' ),
				'type'	=> 'text',	'default' => ''			),
			array(
				'name'	=> 'twitter_users',	'label'	=> __( 'Find Replies in Tweets', 'wse' ),
				'type'	=> 'checkbox',	'default' => true			),
			array(
				'name'	=> 'link_target_blank',	'label'	=> __( 'Create links on new window / tab', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'label' => __( 'Widget footer options', 'wse' ),
				'type'	=> 'separator'			),
			array(
				'name'	=> 'link_user',		'label'	=> __( 'Show a footer link to the Twitter user profile', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'name'	=> 'link_user_text',	'label'	=> __( 'Text for footer link', 'wse' ),
				'type'	=> 'text',	'default' => 'Follow me on Twitter'			),
			array(
				'label' => __( 'Debug options', 'wse' ),
				'type'	=> 'separator'			),
			array(
				'name'	=> 'debug',	'label'	=> __( 'Show debug info', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'name'	=> 'erase_cached_data',	'label'	=> __( 'Erase cached data (use it only for a few minutes, when having issues)', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
			array(
				'name'	=> 'encode_utf8',	'label'	=> __( 'Force UTF8 Encode (use it only if having issues)', 'wse' ),
				'type'	=> 'checkbox',	'default' => false			),
		);

    $control_ops = array('width' => 400);
    parent::__construct(false, 'Twitter Feed', array('description' => 'Twitter Feed - modified from Really Simple Twitter Feed'), $control_ops);
  }

  /** @see WP_Widget::widget */
  function widget($args, $instance) {
    
    $view = new Snap_Wordpress_View('wse.front', 'widget/twitter');
    $view->set($args);
    $view->set('instance', $instance);
    
    extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
    $view->set('title', $title);
		echo $before_widget;  
		
    if ($instance['username'] == '') {
			echo __('Twitter username is not configured','wse');
      return;
		} 
		if (!is_numeric($instance['num']) or $instance['num']<=0) {
			echo __('Number of tweets is not valid','wse');
      return;
		}
		if ($instance['consumer_key'] == '' or $instance['consumer_secret'] == '' or $instance['access_token'] == '' or $instance['access_token_secret'] == '') {
			echo __('Twitter Authentication data is incomplete','wse');
      return;
		}
    
		$view->set('tweets', $this->get_tweets($instance));
    $view->render();
		echo $after_widget;
  }

  /** @see WP_Widget::update */
  function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		foreach ($this->options as $val) {
			if ($val['type']=='text') {
				$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
			} else if ($val['type']=='checkbox') {
				$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
			}
		}
    return $instance;
  }

  /** @see WP_Widget::form */
  function form($instance) {
		if (empty($instance)) {
			foreach ($this->options as $val) {
				if ($val['type']=='separator') {
					continue;
				}
				$instance[$val['name']] = $val['default'];
			}
		}					
	
		// CHECK AUTHORIZATION
		if (!function_exists('curl_init')) {
			echo __('CURL extension not found. You need enable it to use this Widget');
			return;
		}
		
		foreach ($this->options as $val) {
			if ($val['type']=='separator') {
				if ($val['label']!='') {
					echo '<h3>'.$val['label'].'</h3>';
				} else {
					echo '<hr />';
				}
				if ($val['notes']!='') {
					echo '<span class="description">'.$val['notes'].'</span>';
				}
			} else if ($val['type']=='text') {
				$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
				echo '<p>'.$label.'<br />';
				echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
			} else if ($val['type']=='checkbox') {
				$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
				$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
				echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
			}
		}
	}


	protected function debug ($options, $text) {
		if ($options['debug']) {
			echo $text."\n";
		}
	}
  
  protected function get_tweets( $options )
  {
    require_once( Theme_VENDOR_DIR.'/mynetx/codebird-php/src/codebird.php');
    
    \Codebird\Codebird::setConsumerKey($options['consumer_key'], $options['consumer_secret']); // static, see 'Using multiple Codebird instances'
    $this->cb = \Codebird\Codebird::getInstance();	
		$this->cb->setToken($options['access_token'], $options['access_token_secret']);
		
		// From Codebird documentation: For API methods returning multiple data (like statuses/home_timeline), you should cast the reply to array
		$this->cb->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);

		// SET THE NUMBER OF ITEMS TO RETRIEVE - IF "SKIP TEXT" IS ACTIVE, GET MORE ITEMS
		$max_items_to_retrieve = $options['num'];
		if ($options['skip_text']!='' or $options['skip_replies'] or $options['skip_retweets']) {
			$max_items_to_retrieve *= 3;
		}
		// TWITTER API GIVES MAX 200 TWEETS PER REQUEST
		if ($max_items_to_retrieve>200) {
			$max_items_to_retrieve = 200;
		}
	
		$transient_name = 'twitter_data_'.$options['username'].$options['skip_text'].'_'.$options['num'];

		if ($options['erase_cached_data']) {
			$this->debug($options, '<!-- '.__('Fetching data from Twitter').'... -->');
			$this->debug($options, '<!-- '.__('Erase cached data option enabled').'... -->');
			delete_transient($transient_name);
			delete_transient($transient_name.'_status');
			delete_option($transient_name.'_valid');
			
			try {
        $twitter_data =  $this->cb->statuses_userTimeline(array(
							'screen_name'=>$options['username'], 
							'count'=>$max_items_to_retrieve,
							'exclude_replies'=>$options['skip_replies'],
							'include_rts'=>(!$options['skip_retweets'])
					));
			} catch (Exception $e) { return __('Error retrieving tweets','wse'); }

			if (isset($twitter_data['errors'])) {
				$this->debug($options, __('Twitter data error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
			}
		} else {
	
			// USE TRANSIENT DATA, TO MINIMIZE REQUESTS TO THE TWITTER FEED
	
			$timeout = 10 * 60; //10m
			$error_timeout = 5 * 60; //5m
    
			$twitter_data = get_transient($transient_name);
			$twitter_status = get_transient($transient_name.'_status');
    
			// Twitter Status
			if(!$twitter_status || !$twitter_data) {
				try {
					$twitter_status = $this->cb->application_rateLimitStatus();
					set_transient($transient_name."_status", $twitter_status, $error_timeout);
				} catch (Exception $e) { 
					$this->debug($options, __('Error retrieving twitter rate limit').'<br />');
				}
			}
    
			// Tweets

			if (empty($twitter_data) or count($twitter_data)<1 or isset($twitter_data['errors'])) {
				$calls_limit   = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['limit'];
				$remaining     = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['remaining'];
				$reset_seconds = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['reset']-time();

				$this->debug($options, '<!-- '.__('Fetching data from Twitter').'... -->');
				$this->debug($options, '<!-- '.__('Requested items').' : '.$max_items_to_retrieve.' -->');
				$this->debug($options, '<!-- '.__('API calls left').' : '.$remaining.' of '.$calls_limit.' -->');
				$this->debug($options, '<!-- '.__('Seconds until reset').' : '.$reset_seconds.' -->');

				if($remaining <= 7 and $reset_seconds >0) {
				    $timeout       = $reset_seconds;
				    $error_timeout = $reset_seconds;
				}

				try {
					$twitter_data =  $this->cb->statuses_userTimeline(array(
							'screen_name'=>$options['username'], 
							'count'=>$max_items_to_retrieve, 
							'exclude_replies'=>$options['skip_replies'],
							'include_rts'=>(!$options['skip_retweets'])
						));
				} catch (Exception $e) { return __('Error retrieving tweets','wse'); }

				if(!isset($twitter_data['errors']) and (count($twitter_data) >= 1) ) {
				    set_transient($transient_name, $twitter_data, $timeout);
				    update_option($transient_name."_valid", $twitter_data);
				} else {
				    set_transient($transient_name, $twitter_data, $error_timeout);	// Wait 5 minutes before retry
					if (isset($twitter_data['errors'])) {
						$this->debug($options, __('Twitter data error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
					}
				}
			} else {
				$this->debug($options, '<!-- '.__('Using cached Twitter data').'... -->');

				if(isset($twitter_data['errors'])) {
					$this->debug($options, __('Twitter cache error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
				}
			}
    
			if (empty($twitter_data) and false === ($twitter_data = get_option($transient_name."_valid"))) {
			    return __('No public tweets','wse');
			}

			if (isset($twitter_data['errors'])) {
				// STORE ERROR FOR DISPLAY
				$twitter_error = $twitter_data['errors'];
			    if(false === ($twitter_data = get_option($transient_name."_valid"))) {
					$debug = ($options['debug']) ? '<br /><i>Debug info:</i> ['.$twitter_error[0]['code'].'] '.$twitter_error[0]['message'].' - username: "'.$options['username'].'"' : '';
				    return __('Unable to get tweets'.$debug,'wse');
				}
			}
		}
    
    return $this->process_tweets( $twitter_data );
  }
  
  protected function process_tweets( $twitter_data )
  {
    
    foreach( $twitter_data as $key => &$tweet ){
      
      if( $key === 'httpstatus' ) continue;
      if( !is_array( $tweet ) ) continue;
      
      $tweet['html'] = 
        // match protocol://address/path/file.extension?some=variable&another=asf%
        preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" target=\"_blank\">$1</a>", $tweet['text']);
      $tweet['html'] =
        // match www.something.domain/path/file.extension?some=variable&another=asf%
        preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" target=\"_blank\">$1</a>", $tweet['html']);
				
			//preg_match('#(^|\s+)(@([a-zA-Z0-9_\.]+?)?)(\s+|$)\b#i', $tweet['html'], $matches );
			
			$tweet['html'] =
				preg_replace('#(^|\s+)(@([a-zA-Z0-9_\.]+?)?)([\s,\'"]+|$)#i', '$1<a href="http://twitter.com/$3" target="_blank">$2</a>$4', $tweet['html']);
			
			$tweet['html'] =
				preg_replace('/(^|\s+)(#([a-zA-Z0-9_\.]+?)?)([\s,\'"]+|$)/i', '$1<a href="http://twitter.com/search?q=%23$3&amp;src=hash" target="_blank">$2</a>$4', $tweet['html']);
			
			  
      $time = strtotime( $tweet['created_at'] );
      $tweet['posted_time'] =
        ( ( abs( time() - $time) ) < 86400 ) ?
          sprintf( __('%s', 'rstw'), human_time_diff( $time )) :
          date(__('M d', 'rstw'), $time);
      
      $tweet['timestamp'] = date( 'Y/m/d h:i a', $time );
      $tweet['link'] = 'http://twitter.com/'.$tweet['user']['screen_name'].'/status/'.$tweet['id'];
    }
    
    return $twitter_data;
  }
	

	// Display Twitter messages
	protected function really_simple_twitter_messages($options) {
	
		// CHECK OPTIONS

		if ($options['username'] == '') {
			return __('Twitter username is not configured','wse');
		} 
		if (!is_numeric($options['num']) or $options['num']<=0) {
			return __('Number of tweets is not valid','wse');
		}
		if ($options['consumer_key'] == '' or $options['consumer_secret'] == '' or $options['access_token'] == '' or $options['access_token_secret'] == '') {
			return __('Twitter Authentication data is incomplete','wse');
		} 

		if (!class_exists('Codebird')) {
			require ('lib/codebird.php');
		}
    \Codebird\Codebird::setConsumerKey($instance['consumer_key'], $instance['consumer_secret']); // static, see 'Using multiple Codebird instances'
    $this->cb = \Codebird\Codebird::getInstance();	
		$this->cb->setToken($instance['access_token'], $instance['access_token_secret']);
		
		// From Codebird documentation: For API methods returning multiple data (like statuses/home_timeline), you should cast the reply to array
		$this->cb->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);

		// SET THE NUMBER OF ITEMS TO RETRIEVE - IF "SKIP TEXT" IS ACTIVE, GET MORE ITEMS
		$max_items_to_retrieve = $options['num'];
		if ($options['skip_text']!='' or $options['skip_replies'] or $options['skip_retweets']) {
			$max_items_to_retrieve *= 3;
		}
		// TWITTER API GIVES MAX 200 TWEETS PER REQUEST
		if ($max_items_to_retrieve>200) {
			$max_items_to_retrieve = 200;
		}
	
		$transient_name = 'twitter_data_'.$options['username'].$options['skip_text'].'_'.$options['num'];

		if ($options['erase_cached_data']) {
			$this->debug($options, '<!-- '.__('Fetching data from Twitter').'... -->');
			$this->debug($options, '<!-- '.__('Erase cached data option enabled').'... -->');
			delete_transient($transient_name);
			delete_transient($transient_name.'_status');
			delete_option($transient_name.'_valid');
			
			try {
				$twitter_data =  $this->cb->statuses_userTimeline(array(
							'screen_name'=>$options['username'], 
							'count'=>$max_items_to_retrieve,
							'exclude_replies'=>$options['skip_replies'],
							'include_rts'=>(!$options['skip_retweets'])
					));
			} catch (Exception $e) { return __('Error retrieving tweets','wse'); }

			if (isset($twitter_data['errors'])) {
				$this->debug($options, __('Twitter data error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
			}
		} else {
	
			// USE TRANSIENT DATA, TO MINIMIZE REQUESTS TO THE TWITTER FEED
	
			$timeout = 10 * 60; //10m
			$error_timeout = 5 * 60; //5m
    
			$twitter_data = get_transient($transient_name);
			$twitter_status = get_transient($transient_name.'_status');
    
			// Twitter Status
			if(!$twitter_status || !$twitter_data) {
				try {
					$twitter_status = $this->cb->application_rateLimitStatus();
					set_transient($transient_name."_status", $twitter_status, $error_timeout);
				} catch (Exception $e) { 
					$this->debug($options, __('Error retrieving twitter rate limit').'<br />');
				}
			}
    
			// Tweets

			if (empty($twitter_data) or count($twitter_data)<1 or isset($twitter_data['errors'])) {
				$calls_limit   = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['limit'];
				$remaining     = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['remaining'];
				$reset_seconds = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['reset']-time();

				$this->debug($options, '<!-- '.__('Fetching data from Twitter').'... -->');
				$this->debug($options, '<!-- '.__('Requested items').' : '.$max_items_to_retrieve.' -->');
				$this->debug($options, '<!-- '.__('API calls left').' : '.$remaining.' of '.$calls_limit.' -->');
				$this->debug($options, '<!-- '.__('Seconds until reset').' : '.$reset_seconds.' -->');

				if($remaining <= 7 and $reset_seconds >0) {
				    $timeout       = $reset_seconds;
				    $error_timeout = $reset_seconds;
				}

				try {
          print_r(array(
							'screen_name'=>$options['username'], 
							'count'=>$max_items_to_retrieve, 
							'exclude_replies'=>$options['skip_replies'],
							'include_rts'=>(!$options['skip_retweets'])
						));
					$twitter_data =  $this->cb->statuses_userTimeline(array(
							'screen_name'=>$options['username'], 
							'count'=>$max_items_to_retrieve, 
							'exclude_replies'=>$options['skip_replies'],
							'include_rts'=>(!$options['skip_retweets'])
						));
				} catch (Exception $e) { return __('Error retrieving tweets','wse'); }

				if(!isset($twitter_data['errors']) and (count($twitter_data) >= 1) ) {
				    set_transient($transient_name, $twitter_data, $timeout);
				    update_option($transient_name."_valid", $twitter_data);
				} else {
				    set_transient($transient_name, $twitter_data, $error_timeout);	// Wait 5 minutes before retry
					if (isset($twitter_data['errors'])) {
						$this->debug($options, __('Twitter data error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
					}
				}
			} else {
				$this->debug($options, '<!-- '.__('Using cached Twitter data').'... -->');

				if(isset($twitter_data['errors'])) {
					$this->debug($options, __('Twitter cache error:','wse').' '.$twitter_data['errors'][0]['message'].'<br />');
				}
			}
    
			if (empty($twitter_data) and false === ($twitter_data = get_option($transient_name."_valid"))) {
			    return __('No public tweets','wse');
			}

			if (isset($twitter_data['errors'])) {
				// STORE ERROR FOR DISPLAY
				$twitter_error = $twitter_data['errors'];
			    if(false === ($twitter_data = get_option($transient_name."_valid"))) {
					$debug = ($options['debug']) ? '<br /><i>Debug info:</i> ['.$twitter_error[0]['code'].'] '.$twitter_error[0]['message'].' - username: "'.$options['username'].'"' : '';
				    return __('Unable to get tweets'.$debug,'wse');
				}
			}
		}


		if (empty($twitter_data) or count($twitter_data)<1) {
		    return __('No public tweets','wse');
		}
		$link_target = ($options['link_target_blank']) ? ' target="_blank" ' : '';
		
		$out = '
			<ul class="really_simple_twitter_widget">';

		$i = 0;
		foreach($twitter_data as $message) {

			// CHECK THE NUMBER OF ITEMS SHOWN
			if ($i>=$options['num']) {
				break;
			}

			$msg = $message['text'];
			
			// RECOVER ORIGINAL MESSAGE FOR RETWEETS
			if (count($message['retweeted_status'])>0) {
				$msg = 'RT @'.$message['retweeted_status']['user']['screen_name'].': '.$message['retweeted_status']['text'];

				if ($options['thumbnail_retweets']) {
					$message = $message['retweeted_status'];
				}
			}
		
			if ($msg=='') {
				continue;
			}
			if ($options['skip_text']!='' and strpos($msg, $options['skip_text'])!==false) {
				continue;
			}
			if($options['encode_utf8']) $msg = utf8_encode($msg);
				
			$out .= '<li>';
			
			// TODO: LINK
			if ($options['thumbnail'] and $message['user']['profile_image_url_https']!='') {
				$out .= '<img src="'.$message['user']['profile_image_url_https'].'" />';
			}
			if ($options['hyperlinks']) {
				if ($options['replace_link_text']!='') {
					// match protocol://address/path/file.extension?some=variable&another=asf%
					$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$link_target." title=\"$1\">".$options['replace_link_text']."</a>", $msg);
					// match www.something.domain/path/file.extension?some=variable&another=asf%
					$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$link_target." title=\"$1\">".$options['replace_link_text']."</a>", $msg);    
				} else {
					// match protocol://address/path/file.extension?some=variable&another=asf%
					$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
					// match www.something.domain/path/file.extension?some=variable&another=asf%
					$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);    
				}
				// match name@address
				$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
				//NEW mach #trendingtopics
				//$msg = preg_replace('/#([\w\pL-.,:>]+)/iu', '<a href="http://twitter.com/#!/search/\1" class="twitter-link">#\1</a>', $msg);
				//NEWER mach #trendingtopics
				$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/#!/search/%23\2" class="twitter-link" '.$link_target.'>#\2</a>', $msg);
			}
			if ($options['twitter_users'])  { 
				$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$link_target.">@$2</a>$3 ", $msg);
			}
          					
			$link = 'http://twitter.com/#!/'.$options['username'].'/status/'.$message['id_str'];
			if($options['linked'] == 'all')  { 
				$msg = '<a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$msg.'</a>';  // Puts a link to the status of each tweet 
			} else if ($options['linked'] != '') {
				$msg = $msg . ' <a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$options['linked'].'</a>'; // Puts a link to the status of each tweet
			} 
			$out .= $msg;
		
			if($options['update']) {				
				$time = strtotime($message['created_at']);
				$h_time = ( ( abs( time() - $time) ) < 86400 ) ? sprintf( __('%s ago', 'wse'), human_time_diff( $time )) : date(__('M d', 'wse'), $time);
				$out .= '<span class="wse_comma">,</span> <span class="twitter-timestamp" title="' . date(__('Y/m/d H:i', 'wse'), $time) . '">' . $h_time . '</span>';
			}          
                  
			$out .= '</li>';
			$i++;
		}
		$out .= '</ul>';
	
		if ($options['link_user']) {
			$out .= '<div class="wse_link_user"><a href="http://twitter.com/' . $options['username'] . '" '.$link_target.'>'.$options['link_user_text'].'</a></div>';
		}
		return $out;
  }
  
}
