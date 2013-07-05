<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Testimonial Post Type
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */
	
	add_action( 'init', 'register_testimonial' );
	function register_testimonial() {
		
		$labels = array(
			'name' => __('Testimonials'),
			'singular_name' => __('Testimonial'),
			'add_new' => __('Add New', 'Add New Testimonial Name'),
			'add_new_item' => __('Add New Testimonial'),
			'all_items' => __('All Testimonials'),
			'edit_item' => __('Edit Testimonial'),
			'new_item' => __('New Testimonial'),
			'search_items' => __('Search Testimonials'),
			'not_found' =>  __('No testimonials found.'),
			'not_found_in_trash' => __('No testimonials found in Trash.'),
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
		  
		register_post_type( 'testimonial' , $args);
		
		register_taxonomy(
			"testimonial-category", array("testimonial"), array(
				"hierarchical" => true,
				"label" => "Testimonial Categories",
				"singular_label" => "Testimonial Category", 
				"rewrite" => true));
		register_taxonomy_for_object_type('testimonial-category', 'testimonial');
		
		// Add custom columns
		add_filter( 'manage_edit-testimonial_columns', 'custom_testimonial_columns' ) ;
		function custom_testimonial_columns( $columns ) {
		
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __( 'Title' ),
				'content' => __( 'Content' ),
				'category' => __( 'Category' ),
				'date' => __( 'Date' )
			);
		
			return $columns;
		}
		
		// Add custom columns
		add_action( 'manage_testimonial_posts_custom_column', 'content_custom_testimonial_columns', 10, 2 );
		function content_custom_testimonial_columns( $column, $post_id ) {
			global $post;
		
			switch( $column ) {
		
				case 'content' :
					$content = get_the_content();
					if ( empty( $content ) ) echo __( 'Unknown' );
					else printf( __( '%s' ), $content );
					break;
					
				case 'category' :
					$categories = get_the_terms($post_id, 'testimonial-category');
					if ( empty( $categories ) ) echo __( 'Not categorised.' ); 
					else foreach($categories as $category){
						echo '<a href="'.get_bloginfo( 'url' ).'/wp-admin/edit.php?testimonial-category='.$category->slug.'&post_type=testimonial
">'.$category->name.'</a>';
					}
					break;
					
				// Just break out of the switch statement for everything else
				default :
					break;
			}
		}						
	}

?>