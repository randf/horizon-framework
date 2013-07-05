<?php

	/*
	 *
	 * HORIZON FRAMEWORK
	 * Register Functions
	 *
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */

	if(function_exists('add_theme_support')){
		$horizon_theme_support = array( 'menus', 'widgets', 'post-thumbnails' );
		foreach ($horizon_theme_support as $support):
			add_theme_support( $support );
		endforeach;
	}
	
	// Register sidebars
	if(function_exists( 'register_sidebar' )) {
		
		// Custom sidebar loop
		$horizon_sidebar_attr = array(
			'name' => '',
			'before_widget' => '<div class="custom-sidebar">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="custom-sidebar-title">',
			'after_title' => '</h3>'
		);
		
		$sidebar_id = 0;
		$horizon_sidebars = array(
			"Left Sidebar" => "This sidebar will show to the left of your website.",
			"Right Sidebar" => "This sidebar will show to the right of your website.",
			"Footer 1" => "First widgetised column of the footer.",
			"Footer 2" => "Second widgetised column of the footer.",
			"Footer 3" => "Third widgetised column of the footer (used in 3 and 4 column footer).",
			"Footer 4" => "Fourth widgetised column of the footer (used in 4 column footer only).",
		);
				
		foreach( $horizon_sidebars as $sidebar_name => $sidebar_desc ){
			$horizon_sidebar_attr['name'] = $sidebar_name;
			$horizon_sidebar_attr['description'] = $sidebar_desc;
			$horizon_sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;
			register_sidebar($horizon_sidebar_attr);
		}
		
		$custom_sidebars_string = get_option( THEME_SHORT_NAME. '_options_custom_sidebars');
		$custom_sidebars = explode(",", $custom_sidebars_string);
		for($i=0; $i<sizeof($custom_sidebars)-1; $i++){
			$horizon_sidebar_attr['name'] = $custom_sidebars[$i];
			$horizon_sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++;	
			$horizon_sidebar_attr['description'] = "This is a custom sidebar added via the admin panel.";			
			register_sidebar($horizon_sidebar_attr);			
		}

	}

	// Add Admin Panel
	add_action( 'admin_menu', 'horizon_add_theme_options' );
	function horizon_add_theme_options() {
		if(current_user_can('manage_options')){
			add_menu_page( 'Theme Options', THEME_NAME , 'manage_options', 'horizon-theme-options', 'horizon_theme_options' );
		}
	}
	// Add Admin Bar Button
	add_action( 'wp_before_admin_bar_render', 'add_admin_bar_buttons' );
	function add_admin_bar_buttons() {
		global $wp_admin_bar;
		if(current_user_can('manage_options')){
			$wp_admin_bar->add_menu( array(
				'id' => 'theme_options',
				'title' => __('Theme Options'),
				'href' => admin_url( 'admin.php?page=horizon-theme-options')
			));	
		}
    }
			
?>