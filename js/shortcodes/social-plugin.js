(function() {  
    tinymce.create('tinymce.plugins.social', {  
        init : function(ed, url) {  
            ed.addButton('social', {  
                title : 'Insert Social Media',  
                image : url + "/images/social.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[social media="MEDIA TYPE" size="SMALL | MEDIUM | LARGE"]MEDIA_LINK[/social]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('social', tinymce.plugins.social);  
})();
