<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Gallery Post Type
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */
	
	add_action( 'init', 'register_gallery' );
	function register_gallery() {
		
		$labels = array(
			'name' => __('Gallery'),
			'singular_name' => __('Gallery'),
			'add_new' => __('Add New', 'Add New Gallery'),
			'add_new_item' => __('Add New Gallery'),
			'all_items' => __('All Galleries'),
			'edit_item' => __('Edit Galleries'),
			'new_item' => __('New Gallery'),
			'search_items' => __('Search Galleries'),
			'not_found' =>  __('No galleries found.'),
			'not_found_in_trash' => __('No galleries found in Trash.'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'exclude_from_search' => true,
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'gallery', "with_front"=>false),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','thumbnail'),
		  ); 
		  
		register_post_type( 'gallery' , $args);
		
	}
	
	$gallery_tabs = array(
		"Images" => "images",
	);
	
	$gallery_meta_boxes = array(
		"images" => array( 
			"Lightbox Thumbnail" => array(
				"type" => "checktoggle",
				"name" => "post_meta_lightbox_thumbnail",
				"title" => __("LIGHTBOX THUMBNAIL"),
				"default" => "Yes",
				"selected_value" => "Yes",
			),
			"Images" => array(
				"type" => "mediagallery",
				"name" => "post_meta_gallery_images",
				"title" => __("IMAGES"),
				"image_size" => "post_slider_thumbnail",
				"no_hr" => true
			),
		),
	);
	
	// Add page options with the add_meta_boxes hook
	add_action( 'add_meta_boxes', 'add_gallery_options' );
	function add_gallery_options(){
		add_meta_box( 'custom_meta_boxes', __('Gallery Options'), 'build_gallery_options', 'gallery', 'normal', 'high' );
	}

	// Let's build the custom page options!
	function build_gallery_options() {
		// Get the post details and also all of our custom boxes we'll need
		global $post, $gallery_tabs, $gallery_meta_boxes;
		
		echo"<div class='horizon_over_wrap'>";
		echo"<div class='horizon_over_content'>";
		
		echo '<div class="meta_box_tabs">';
			echo '<ul>';
				$i=0;
				foreach($gallery_tabs as $tab_name => $tab_id){
					$status = $i==0 ? 'active' : '';
					echo '<li class="'.$status.'" rel="'.$tab_id.'">'.$tab_name.'</li>';
					$i++;
				}
			echo '</ul>';
		echo '</div>';
		
		// Loop through custom options to display them
		$i=0;
		foreach ($gallery_meta_boxes as $tab => $elements):
		
			$status = $i==0 ? 'active' : '';
			echo '<div id="'.$tab.'" class="meta_panel '.$status.'">';
			
			foreach($elements as $meta_box):
		
				// Init the meta box name
				$meta_box['name'] = isset($meta_box['name']) ? $meta_box['name'] : '';
				$meta_box['value'] = get_post_meta($post->ID, $meta_box['name'], true);
							
				echo sort_meta_boxes($meta_box);
				
				if (empty($meta_box['no_hr'])){
					if( $meta_box['type'] !== 'open' && $meta_box['type'] !== 'close'){
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
	
	function save_gallery_options ($id) {
		global $gallery_meta_boxes;
		
		$tabs = $gallery_meta_boxes;

		foreach($tabs as $meta_boxes):
		
			foreach($meta_boxes as $meta_box):
		
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
					$new_meta = '';
				}
				
				$old_meta = get_post_meta($id, $meta_box['name'], true);	
				save_meta_data($id, $new_meta, $old_meta, $meta_box['name']);
				
			endforeach;
			
		endforeach;		
	}
	

?>