<?php 

	/*
	 *
	 * HORIZON FRAMEWORK
	 * AJAX Switchboard
	 *
	 * @copyright 2013 Joe McKie
	 * @version 1.0
	 * @author Joe McKie
	 * @link http://joemck.ie/
	 *
	 */

	function ajax_function() {
		switch($_REQUEST['fn']):
			case "save_theme_options": 
				$output = save_theme_options(json_encode($_POST['string'])); // This is found on the theme-options.php page
				break;
			case "switch_google_font_css": 
				$output = get_file($_POST['string']);
				break;
			default:
				$output = "No function specified. Please check the jQuery.ajax() call!";
				break;
		endswitch;
		
		$output = json_encode($output);
		if(is_array($output)){
			print_r($output);
		} else {
			echo $output;
		};
		
		die;
						
	}
			
?>