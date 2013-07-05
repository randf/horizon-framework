(function() {  
    tinymce.create('tinymce.plugins.space', {  
        init : function(ed, url) {  
            ed.addButton('space', {  
                title : 'Insert Space',  
                image : url + "/images/space.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[space]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('space', tinymce.plugins.space);  
})();
