(function() {  
    tinymce.create('tinymce.plugins.column', {  
        init : function(ed, url) {  
            ed.addButton('column', {  
                title : 'Insert Column',  
                image : url + "/images/column.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[column col="1/3"]COLUMN TEXT[/column]<br />\
						[column col="1/3"]COLUMN TEXT[/column]<br />\
						[column col="1/3" last="true"]COLUMN TEXT[/column]<br />\
						[space]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('column', tinymce.plugins.column);  
})();
