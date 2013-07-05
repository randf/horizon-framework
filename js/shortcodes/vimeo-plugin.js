(function() {  
    tinymce.create('tinymce.plugins.vimeo', {  
        init : function(ed, url) {  
            ed.addButton('vimeo', {  
                title : 'Insert Vimeo Video',  
                image : url + "/images/vimeo.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[vimeo height="315" width="560" title="TITLE"]VIMEO VIDEO URL[/vimeo]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('vimeo', tinymce.plugins.vimeo);  
})();
