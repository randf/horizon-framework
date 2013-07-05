<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Price Table Post Type
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */
	
	add_action( 'init', 'register_price_tables' );
	function register_price_tables() {
		
		$labels = array(
			'name' => __('Price Tables'),
			'singular_name' => __('Price Table'),
			'add_new' => __('Add New', 'Add New Price Table Name'),
			'add_new_item' => __('Add New Price Table'),
			'all_items' => __('All Price Tables'),
			'edit_item' => __('Edit Price Table'),
			'new_item' => __('New Price Table'),
			'search_items' => __('Search Price Tables'),
			'not_found' =>  __('No price tables found.'),
			'not_found_in_trash' => __('No price tables found in Trash.'),
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
			'supports' => array('title','editor'),
			'rewrite' => false,
		  ); 
		  
		register_post_type( 'price-table' , $args);
		
		register_taxonomy(
			"price-table-category", array("price-table"), array(
				"hierarchical" => true,
				"label" => "Price Table Categories",
				"singular_label" => "Price Table Category", 
				"rewrite" => true));
		register_taxonomy_for_object_type('price-table-category', 'price-table');
		
		// Add custom columns
		add_filter( 'manage_edit-price-table_columns', 'custom_price_table_columns' ) ;
		function custom_price_table_columns( $columns ) {
		
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __( 'Title' ),
				'category' => __( 'Category' ),
				'date' => __( 'Date' )
			);
		
			return $columns;
		}
		
		// Add custom columns
		add_action( 'manage_price-table_posts_custom_column', 'content_custom_price_table_columns', 10, 2 );
		function content_custom_price_table_columns( $column, $post_id ) {
			global $post;
		
			switch( $column ) {
		
				case 'category' :
					$categories = get_the_terms($post_id, 'price-table-category');
					if ( empty( $categories ) ) echo __( 'Not categorised.' ); 
					else foreach($categories as $category){
						echo '<a href="'.get_bloginfo( 'url' ).'/wp-admin/edit.php?price-table-category='.$category->slug.'&post_type=price-table
">'.$category->name.'</a>';
					}
					break;
					
				// Just break out of the switch statement for everything else
				default :
					break;
			}
		}						
		
	}
	
	$price_table_tabs = array(
		"Price Table Options" => "price-table-options"
	);
	
	$price_table_meta_boxes = array(
		"price-table-options" => array(
			"Order" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_price_table_order",
				"title" => __("ORDER"),
				"default" => "",
				"description" => "Packages will display in ascending order. E.g. 1 - 2 - 3"
			),
			"Featured" => array(
				"type" => "checktoggle",
				"name" => THEME_SHORT_NAME. "_options_price_table_featured",
				"title" => __("FEATURED"),
				"default" => "No",
				"selected_value" => "Yes",
			),
			"Price" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_price_table_price",
				"no_hr" => true,
				"title" => __("PRICE"),
				"default" => "",
			),
			"Price Suffix" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_price_table_suffix",
				"title" => __("PRICE SUFFIX"),
				"default" => "per month",
			),
			"Button Link" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_price_table_button_link",
				"no_hr" => true,
				"title" => __("BUTTON LINK"),
				"default" => "#",
			),
			"Button Text" => array(
				"type" => "input",
				"name" => THEME_SHORT_NAME. "_options_price_table_button_text",
				"no_hr" => true,
				"title" => __("BUTTON TEXT"),
				"default" => "Read More",
			),
		),
	);
	
	// Add page options with the add_meta_boxes hook
	add_action( 'add_meta_boxes', 'add_price_table_options' );
	function add_price_table_options(){
		add_meta_box( 'custom_meta_boxes', __('Price Table Options'), 'build_price_table_options', 'price-table', 'normal', 'high' );
	}

	// Let's build the custom page options!
	function build_price_table_options() {
		// Get the post details and also all of our custom boxes we'll need
		global $post, $price_table_tabs, $price_table_meta_boxes;
		
		echo"<div class='horizon_over_wrap'>";
		echo"<div class='horizon_over_content'>";
		
		echo '<div class="meta_box_tabs">';
			echo '<ul>';
				$i=0;
				foreach($price_table_tabs as $tab_name => $tab_id){
					$status = $i==0 ? 'active' : '';
					echo '<li class="'.$status.'" rel="'.$tab_id.'">'.$tab_name.'</li>';
					$i++;
				}
			echo '</ul>';
		echo '</div>';
		
		$i=0; 
		foreach($price_table_meta_boxes as $tab=>$elements):
		
			// Loop through custom options to display them
			$status = $i==0 ? 'active' : '';
			echo '<div id="'.$tab.'" class="meta_panel '.$status.'">';
			
				foreach ($elements as $meta_box):
								
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
	
	function save_price_table_options ($id) {
		global $price_table_meta_boxes;
		
		$tabs = $price_table_meta_boxes;

		foreach($tabs as $meta_boxes):
		
			foreach($meta_boxes as $meta_box):
		
				if(isset($_POST[$meta_box['name']])) {
					$new_meta = stripslashes($_POST[$meta_box['name']]);
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