<?php
	add_action( 'widgets_init', 'register_flickr_photos_widget' ); 
	function register_flickr_photos_widget() {  
    	register_widget( 'flickr_photos_widget' );  
    }  
    
    class flickr_photos_widget extends WP_Widget {
	    function flickr_photos_widget(){
			$widget_ops = array( 'classname' => 'flickr-photos', 'description' => __('Displays Flickr photos of a given user ID. ', 'lt-admin') );
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'flickr-photos' );
			
			$this->WP_Widget( 'flickr-photos', __('Flickr Photos', 'lt-admin'), $widget_ops, $control_ops );
	    }
	    
		function widget( $args, $instance ) {
			extract( $args );
	
			//Our variables from the widget settings.
			$title = apply_filters('widget_title', $instance['title'] );
			$user_id = $instance['user_id'];
			$num = $instance['num'];
	
			echo $before_widget;
	
			// Display the widget title 
			if ( $title )
				echo $before_title . $title . $after_title;
	
			$params = array(
				'api_key'	=> '99e949cc1b1a1ef6a86415d8aa932b8a',
				'method'	=> 'flickr.photos.search',
				'user_id' 	=> $user_id,
				'per_page'	=> $num,
				'format'	=> 'php_serial',
			);
			
			$encoded_params = array();
			
			foreach ($params as $k => $v){
			
				$encoded_params[] = urlencode($k).'='.urlencode($v);
			}
			
			
			#
			# call the API and decode the response
			#
			
			$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
			
			$rsp = file_get_contents($url);
			
			$rsp_obj = unserialize($rsp);
			
			
			#
			# display the photo title (or an error if it failed)
			#
			
			if ($rsp_obj['stat'] == 'ok'){
			
				foreach($rsp_obj['photos']['photo'] as $photo){
					// Do stuff
				}
			
			}else{
			
				echo "Call failed!";
			}
			
			echo $after_widget;
			
			echo $html;
		}
	
		//Update the widget 
		 
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			//Strip tags from title and name to remove HTML 
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['user_id'] = $new_instance['user_id'];
			$instance['num'] = strip_tags( $new_instance['num'] );
	
			return $instance;
		}
	
		
		function form( $instance ) {
	
			//Set up some default widget settings.
			$defaults = array( 'title' => '', 'num' => '9', 'user_id' => '' );
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$html .= '<p>';
				$html .= '<label for="'.$this->get_field_id( 'title' ).'">'.__('Title:', 'lt-admin').'</label>';
				$html .= '<input id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" value="'.$instance['title'].'" style="width:100%;" />';
			$html .= '</p>';
			
			$html .= '<p>';
				$html .= '<label for="'.$this->get_field_id( 'user_id' ).'">'.__('Flickr ID:', 'lt-admin').'</label>';
				$html .= '<input id="'.$this->get_field_id( 'user_id' ).'" name="'.$this->get_field_name( 'user_id' ).'" value="'.$instance['user_id'].'" style="width:100%;" />';
			$html .= '</p>';
			
			$html .= '<p>';
		        $html .= '<label for="'.$this->get_field_id('num').'">'.__('Photos Count:', 'lt-admin').'</label>';
		        $html .= '<select name="'.$this->get_field_name('num').'" id="'.$this->get_field_id('num').'" class="widefat">';
		            $options = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
		            foreach ($options as $option) {
		                $html .= '<option value="'.$option.'" id="'.$option.'"'; 
		                	$html .= $instance['num'] == $option ? ' selected' : '';
		                $html .= '>';
		                	$html .= $option;
		                $html .= '</option>';
		            }
		        $html .= '</select>';
		    $html .= '</p>';
						
			echo $html;

		}
    }
?>