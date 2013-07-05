jQuery(document).ready(function($){
	
     var form = $("#horizon-theme-options-form");
     var submit_button = $(".horizon-theme-options-submit");
     var reset_button = $(".horizon-theme-options-reset");
	 var overlay = $("#theme-options .overlay");
	 var message_box = $("#theme-options #message_box");
	 
     submit_button.click(function(){
		 showLoader();
         doAjaxRequest();
     });
	 
     /* reset_button.click(function(){
		 setWarningMessage();
		  showLoader();
     }); */
	 
	 overlay.click(function(e){
		 hideLoader();
	 });
	 
	function doAjaxRequest(){
		 $.ajax({
			  url: page_data.ajaxurl,
			  data:{
				action: 'do_ajax',
				fn: 'save_theme_options',
				security: page_data.nonce_secure,
				string: form.serializeArray()
			  },
			  dataType: 'json',
			  type: 'POST',
			  beforeSend: function(){
			  	message_box.animate({
					top: $(window).scrollTop()+100,
					width: message_box.children("span").outerWidth(),
				}, 300);
			}
		 }).
		 done(function(data){
			 message_box.children("span").html(data.message);
			 message_box.animate({
				 top: $(window).scrollTop()+100,
				 width: message_box.children("span").outerWidth(),
			 }, 300);
    	 }).
		 fail( function(errorThrown){
			 message_box.children("span").html(errorThrown.message);
			 message_box.animate({
				 top: $(window).scrollTop()+100,
				 width: message_box.children("span").outerWidth(),
			 }, 300);
			console.log(errorThrown);
		 })
	}
	
	function showLoader() {
		overlay.show().animate({
			opacity : 0.9
		}, 300)
	}
	
	function hideLoader() {
		overlay.animate({
			opacity:0
		}, 300,function() {
			overlay.hide();
			message_box.children("span").html('<span><img src="'+page_data.root+'/_horizon/images/ajax/bar.gif" /></span>');
			message_box.css("width", message_box.find("img").outerWidth());
		});
	}
	
	function setWarningMessage() {
		message_box.children("span").html("WARNING! You are about to reset all of the options to this theme.");
	}
	
});