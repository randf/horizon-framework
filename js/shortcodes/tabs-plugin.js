(function() {  
    tinymce.create('tinymce.plugins.tabs', {  
        init : function(ed, url) {  
            ed.addButton('tabs', {  
                title : 'Insert Tabs',  
                image : url + "/images/tabs.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[tabs]<br />\
						[tab_item title="TAB TITLE"]TAB CONTENT[/tab_item]<br />\
						[tab_item title="TAB TITLE"]TAB CONTENT[/tab_item]<br />\
						[tab_item title="TAB TITLE"]TAB CONTENT[/tab_item]<br />\
					[/tabs]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('tabs', tinymce.plugins.tabs);  
})();
