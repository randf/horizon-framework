(function() {  
    tinymce.create('tinymce.plugins.list', {  
        init : function(ed, url) {  
            ed.addButton('list', {  
                title : 'Insert List',  
                image : url + "/images/list.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[list type="check"]<br />\
					<ul>\
					<li>LIST ITEM</li>\
					<li>LIST ITEM</li>\
					<li>LIST ITEM</li>\
					</ul>\
					[/list]<br />');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('list', tinymce.plugins.list);  
})();
