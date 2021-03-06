<?php

	// Add page options with the add_meta_boxes hook
	add_action( 'add_meta_boxes', 'add_post_options' );
	function add_post_options(){
		add_meta_box( 'custom_meta_boxes', __('Post Options'), 'horizon_build_post_options', 'post', 'normal', 'high' );
	}
	
	// Let's build the custom page options!
	function horizon_build_post_options() {
		// Get the post details and also all of our custom boxes we'll need
		global $post, $post_tabs, $post_meta_boxes;
		
		echo"<div class='horizon_over_wrap'>";
			echo"<div class='horizon_over_content'>";
			
				echo '<div class="meta_box_tabs">';
					echo '<ul>';
						$i=0;
						foreach($post_tabs as $tab_name => $tab_id){
							$status = $i==0 ? 'active' : '';
							if(!isset($active_tab_id)){ 
								$active_tab_id = $tab_id;
							}
							echo '<li class="'.$status.'" rel="'.$tab_id.'">'.$tab_name.'</li>';
							$i++;
						}
					echo '</ul>';
				echo '</div>';
			
				// Loop through custom options to display them
				$i=0;
				foreach ($post_meta_boxes as $tab => $elements):
					
					$status = $tab == $active_tab_id ? 'active' : '';
					echo '<div id="'.$tab.'" class="meta_panel '.$status.'">';
				
					foreach($elements as $meta_box):
				
						// Init the meta box name
						$meta_box['name'] = isset($meta_box['name']) ? $meta_box['name'] : '';
						$meta_box['value'] = get_post_meta($post->ID, $meta_box['name'], true);
									
						echo sort_meta_boxes($meta_box);
						
						if (empty($meta_box['no_hr'])){
							if( $meta_box['type'] != 'open' && $meta_box['type'] != 'close'){
								echo '<hr class="separator mt20">';
							}
						}
					
					endforeach;
					
					echo '</div>';
					$i++;
					
				endforeach;
			
			echo"</div>";
		echo"</div>";
		
	}
	
	function save_post_options ($id) {
		global $post_meta_boxes;
		
		$tabs = $post_meta_boxes;

		foreach($tabs as $meta_boxes):
		
			foreach($meta_boxes as $meta_box):
				$arraystring = '';
				if(isset($_POST[$meta_box['name']])) {
					if(gettype($_POST[$meta_box['name']])=="array"){
						foreach ($_POST[$meta_box['name']] as $key){
							$arraystring .= $key . ', ';
						}
						$new_meta = stripslashes($arraystring);
					} else {
						$new_meta = stripslashes($_POST[$meta_box['name']]);
					}
				} else {
					if($meta_box['type'] == "checktoggle"){
						$new_meta = 'No';
					} else {
						$new_meta = '';
					}
				}
				
				$old_meta = get_post_meta($id, $meta_box['name'], true);	
				save_meta_data($id, $new_meta, $old_meta, $meta_box['name']);
				
			endforeach;
			
		endforeach;		
	}

?>