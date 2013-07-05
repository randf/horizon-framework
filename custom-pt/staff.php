<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Staff Post Type
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */
	
	add_action( 'init', 'register_staff' );
	function register_staff() {
		
		$labels = array(
			'name' => __('Staff'),
			'singular_name' => __('Employee'),
			'add_new' => __('Add New', 'Add New Employee Name'),
			'add_new_item' => __('Add New Employee'),
			'all_items' => __('All Staff'),
			'edit_item' => __('Edit Employee'),
			'new_item' => __('New Employee'),
			'search_items' => __('Search Staff'),
			'not_found' =>  __('No staff found.'),
			'not_found_in_trash' => __('No staff found in Trash.'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','editor', 'thumbnail'),
			'rewrite' => false,
		  ); 
		  
		register_post_type( 'staff' , $args);
		
		register_taxonomy(
			"staff-category", array("staff"), array(
				"hierarchical" => true,
				"label" => "Staff Categories",
				"singular_label" => "Staff Category", 
				"rewrite" => true));
		register_taxonomy_for_object_type('staff-category', 'staff');
		
		// Add custom columns
		add_filter( 'manage_edit-staff_columns', 'custom_staff_columns' ) ;
		function custom_staff_columns( $columns ) {
		
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __( 'Name' ),
				'category' => __( 'Category' ),
				'date' => __( 'Date' )
			);
		
			return $columns;
		}
		
		// Add custom columns
		add_action( 'manage_staff_posts_custom_column', 'content_custom_staff_columns', 10, 2 );
		function content_custom_staff_columns( $column, $post_id ) {
			global $post;
		
			switch( $column ) {
		
				case 'category' :
					$categories = get_the_terms($post_id, 'staff-category');
					if ( empty( $categories ) ) echo __( 'Not categorised.' ); 
					else foreach($categories as $category){
						echo '<a href="'.get_bloginfo( 'url' ).'/wp-admin/edit.php?staff-category='.$category->slug.'&post_type=staff
">'.$category->name.'</a>';
					}
					break;
					
				// Just break out of the switch statement for everything else
				default :
					break;
			}
		}						
		
	}
	
	$staff_tabs = array(
		"Employee Info" => "employee-info"
	);
	
	$staff_meta_boxes = array(
		"employee-info" => array(
			"Role" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_staff_role",
				"title" => __("STAFF ROLE"),
				"default" => "Employee",
			),
			"Email" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_staff_email",
				"no_hr" => true,
				"title" => __("STAFF EMAIL"),
				"default" => "",
			),
			"Phone" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_staff_phone",
				"no_hr" => true,
				"title" => __("STAFF PHONE"),
				"default" => "",
			),
			"Website" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_staff_website",
				"no_hr" => true,
				"title" => __("STAFF WEBSITE"),
				"default" => "",
			),
			"Twitter" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_staff_twitter",
				"no_hr" => true,
				"title" => __("STAFF TWITTER HANDLE"),
				"default" => "",
				"description" => "Format - username, @username or http://www.twitter.com/username"
			),
		),
	);
	
	// Add page options with the add_meta_boxes hook
	add_action( 'add_meta_boxes', 'add_staff_options' );
	function add_staff_options(){
		add_meta_box( 'custom_meta_boxes', __('Staff Options'), 'build_staff_options', 'staff', 'normal', 'high' );
	}

	// Let's build the custom page options!
	function build_staff_options() {
		// Get the post details and also all of our custom boxes we'll need
		global $post, $staff_tabs, $staff_meta_boxes;
		
		echo"<div class='horizon_over_wrap'>";
		echo"<div class='horizon_over_content'>";
		
		echo '<div class="meta_box_tabs">';
			echo '<ul>';
				$i=0;
				foreach($staff_tabs as $tab_name => $tab_id){
					$status = $i==0 ? 'active' : '';
					echo '<li class="'.$status.'" rel="'.$tab_id.'">'.$tab_name.'</li>';
					$i++;
				}
			echo '</ul>';
		echo '</div>';
		
		// Loop through custom options to display them
		$i=0;
		foreach ($staff_meta_boxes as $tab => $elements):
			
			$status = $i==0 ? 'active' : '';		
			echo '<div id="'.$tab.'" class="meta_panel '.$status.'">';
			
				foreach($elements as $meta_box):
			
				// Init the meta box name
				$meta_box['name'] = isset($meta_box['name']) ? $meta_box['name'] : '';
				$meta_box['value'] = get_post_meta($post->ID, $meta_box['name'], true);
							
				echo "<div class='meta_box'>";
					echo sort_meta_boxes($meta_box);
				echo "</div>";
				
				echo "<div class='clear'></div>";
				
				if (empty($meta_box['no_hr'])){
					if( $meta_box['type'] != 'opendiv' && $meta_box['type'] != 'closediv'){
						echo '<hr class="separator mt20">';
					}
				}
				
				endforeach;
			
			echo '</div>';
			
		endforeach;
		
		echo"</div>";
		echo"</div>";
		
	}
	
	function save_staff_options ($id) {
		global $staff_meta_boxes;
		
		$tabs = $staff_meta_boxes;

		foreach($tabs as $meta_boxes):
		
			foreach($meta_boxes as $meta_box):
		
				if(isset($_POST[$meta_box['name']])) {
					$new_meta = stripslashes($_POST[$meta_box['name']]);
				} else {
					$new_meta = '';
				}
				
				$old_meta = get_post_meta($id, $meta_box['name'], true);	
				save_meta_data($id, $new_meta, $old_meta, $meta_box['name']);
				
			endforeach;
			
		endforeach;		
	}
	

?>