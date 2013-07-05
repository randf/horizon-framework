<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Portfolio Post Type
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */
	
	add_action( 'init', 'register_portfolios' );
	function register_portfolios() {
		
		$labels = array(
			'name' => __('Portfolio'),
			'singular_name' => __('Portfolio Item'),
			'add_new' => __('Add New', 'Add New Portfolio Name'),
			'add_new_item' => __('Add New Portfolio Item'),
			'all_items' => __('All Portfolio Items'),
			'edit_item' => __('Edit Portfolio Item'),
			'new_item' => __('New Portfolio Item'),
			'search_items' => __('Search Portfolio Items'),
			'not_found' =>  __('No portfolio items found.'),
			'not_found_in_trash' => __('No portfolio items found in Trash.'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'portfolio', "with_front"=>false),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','editor', 'thumbnail', 'comments'),
		  ); 
		  
		register_post_type( 'portfolio' , $args);
		
		register_taxonomy(
			"portfolio-category", array("portfolio"), array(
				"hierarchical" => true,
				"label" => "Portfolio Categories",
				"singular_label" => "Portfolio Category", 
				"rewrite" => true));
		register_taxonomy_for_object_type('portfolio-category', 'portfolio');
		
		register_taxonomy(
			"portfolio-tag", array("portfolio"), array(
				"hierarchical" => false,
				"label" => "Portfolio Tags",
				"singular_label" => "Portfolio Tag", 
				"rewrite" => true));
		register_taxonomy_for_object_type('portfolio-tag', 'portfolio');
		
		// Add custom columns
		add_filter( 'manage_edit-portfolio_columns', 'custom_portfolio_columns' ) ;
		function custom_portfolio_columns( $columns ) {
		
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __( 'Title' ),
				'category' => __( 'Category' ),
				'date' => __( 'Date' )
			);
		
			return $columns;
		}
		
		// Add custom columns
		add_action( 'manage_portfolio_posts_custom_column', 'content_custom_portfolio_columns', 10, 2 );
		function content_custom_portfolio_columns( $column, $post_id ) {
			global $post;
		
			switch( $column ) {
		
				case 'category' :
					$categories = get_the_terms($post_id, 'portfolio-category');
					if ( empty( $categories ) ) echo __( 'Not categorised.' ); 
					else foreach($categories as $category){
						echo '<a href="'.get_bloginfo( 'url' ).'/wp-admin/edit.php?portfolio-category='.$category->slug.'&post_type=portfolio">'.$category->name.'</a>';
					}
					break;
					
				// Just break out of the switch statement for everything else
				default :
					break;
			}
		}						
		
	}
		
	// Add page options with the add_meta_boxes hook
	add_action( 'add_meta_boxes', 'add_portfolio_options' );
	function add_portfolio_options(){
		add_meta_box( 'custom_meta_boxes', __('Portfolio Options'), 'build_portfolio_options', 'portfolio', 'normal', 'high' );
	}

	// Let's build the custom page options!
	function build_portfolio_options() {
		// Get the post details and also all of our custom boxes we'll need
		global $post, $portfolio_tabs, $portfolio_meta_boxes;
		
		echo"<div class='horizon_over_wrap'>";
		echo"<div class='horizon_over_content'>";
		
		echo '<div class="meta_box_tabs">';
			echo '<ul>';
				$i=0;
				foreach($portfolio_tabs as $tab_name => $tab_id){
					$status = $i==0 ? 'active' : '';
					echo '<li class="'.$status.'" rel="'.$tab_id.'">'.$tab_name.'</li>';
					$i++;
				}
			echo '</ul>';
		echo '</div>';
		
		// Loop through custom options to display them
		$i=0;
		foreach ($portfolio_meta_boxes as $tab => $elements):
		
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
	
	function save_portfolio_options ($id) {
		global $portfolio_meta_boxes;
		
		$tabs = $portfolio_meta_boxes;

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