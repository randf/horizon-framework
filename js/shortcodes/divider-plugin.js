(function() {  
    tinymce.create('tinymce.plugins.divider', {  
        init : function(ed, url) {  
            ed.addButton('divider', {  
                title : 'Insert Divider',  
                image : url + "/images/divider.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[divider scroll_text="SCROLL TEXT HERE"]<br />[space height="20"]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('divider', tinymce.plugins.divider);  
})();
