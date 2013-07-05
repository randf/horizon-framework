(function() {  
    tinymce.create('tinymce.plugins.youtube', {  
        init : function(ed, url) {  
            ed.addButton('youtube', {  
                title : 'Insert YouTube Video',  
                image : url + "/images/youtube.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[youtube height="315" width="560" title="TITLE"]YOUTUBE VIDEO URL[/youtube]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('youtube', tinymce.plugins.youtube);  
})();
