(function() {  
    tinymce.create('tinymce.plugins.message', {  
        init : function(ed, url) {  
            ed.addButton('message', {  
                title : 'Insert Message',  
                image : url + "/images/message.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[message type="ALERT | INFO | SUCCESS | WARNING" title="MESSAGE TITLE" rounded="true"]MESSAGE_TEXT[/message]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('message', tinymce.plugins.message);  
})();
