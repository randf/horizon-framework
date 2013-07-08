<?php
	add_action( 'widgets_init', 'register_twitter_feed_widget' ); 
	function register_twitter_feed_widget() {  
    	register_widget( 'horizon_twitter_widget' );  
    }  
    
    class horizon_twitter_widget extends WP_Widget {
	    function horizon_twitter_widget(){
			$widget_ops = array( 'classname' => 'twitter-feed', 'description' => __('Display the tweets of a given Twitter username.', 'lt-admin') );
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter-feed' );
			
			$this->WP_Widget( 'twitter-feed', __('Twitter Feed', 'lt-admin'), $widget_ops, $control_ops );
	    }
	    
		function widget( $args, $instance ) {
			global $tweet;
			extract( $args );
	
			//Our variables from the widget settings.
			$title = apply_filters('widget_title', $instance['title'] );
			$num = $instance['num'];
			$username = str_replace("@", "", $instance['username']);
			
			$tweets = json_decode(get_file('https://api.twitter.com/1.1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name='.$username.'&count='.$num));
			
			echo $before_widget;
	
			// Display the widget title 
			if ( $title )
				echo $before_title . $title . $after_title;
			
			get_template_part( TEMPLATE_PATH.'/widgets/twitter/before-twitter-widget' );
			foreach($tweets as $tweet){
				get_template_part( TEMPLATE_PATH.'/widgets/twitter/tweet' );
			}
			get_template_part( TEMPLATE_PATH.'/widgets/twitter/after-twitter-widget' );
			
			echo $after_widget;
			
			return;
		}
	
		//Update the widget 
		 
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			//Strip tags from title and name to remove HTML 
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = strip_tags( $new_instance['username'] );
			$instance['num'] = strip_tags( $new_instance['num'] );
	
			return $instance;
		}
	
		
		function form( $instance ) {
	
			//Set up some default widget settings.
			$defaults = array( 'title' => '', 'num' => '3', 'category' => 'All' );
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$html .= '<p>';
				$html .= '<label for="'.$this->get_field_id( 'title' ).'">'.__('Title:', 'lt-admin').'</label>';
				$html .= '<input id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" value="'.$instance['title'].'" type="text" style="width:100%;" />';
			$html .= '</p>';
			
			$html .= '<p>';
		        $html .= '<label for="'.$this->get_field_id('username').'">'.__('Twitter Username:', 'lt-admin').'</label><br />';
		        $html .= '<input type="text" name="'.$this->get_field_name('username').'" id="'.$this->get_field_id('username').'" value="'.$instance['username'].'" />';
		    $html .= '</p>';
						
			$html .= '<p>';
		        $html .= '<label for="'.$this->get_field_id('num').'">'.__('Twitter Count:', 'lt-admin').'</label><br />';
		        $html .= '<input type="text" name="'.$this->get_field_name('num').'" id="'.$this->get_field_id('num').'" value="'.$instance['num'].'" />';
		    $html .= '</p>';
						
			echo $html;

		}
    }
?>