(function() {  
    tinymce.create('tinymce.plugins.highlight', {  
        init : function(ed, url) {  
            ed.addButton('highlight', {  
                title : 'Insert Highlighted Text',  
                image : url + "/images/highlight.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[highlight background="#BACKGROUND_HEX" color="#COLOR_HEX]HIGHLIGHTED TEXT[/highlight]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('highlight', tinymce.plugins.highlight);  
})();
