(function() {  
    tinymce.create('tinymce.plugins.quote', {  
        init : function(ed, url) {  
            ed.addButton('quote', {  
                title : 'Insert Quote',  
                image : url + "/images/quote.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[quote align="LEFT | CENTER | RIGHT"]BLOCKQUOTE TEXT[/quote]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('quote', tinymce.plugins.quote);  
})();
