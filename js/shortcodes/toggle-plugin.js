(function() {  
    tinymce.create('tinymce.plugins.toggle', {  
        init : function(ed, url) {  
            ed.addButton('toggle', {  
                title : 'Insert Toggle',  
                image : url + "/images/toggle.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[toggle]<br />\
						[toggle_item active="active" title="TOGGLE TITLE"]TOGGLE CONTENT[/toggle_item]<br />\
						[toggle_item title="TOGGLE TITLE"]TOGGLE CONTENT[/toggle_item]<br />\
						[toggle_item title="TOGGLE TITLE"]TOGGLE CONTENT[/toggle_item]<br />\
					[/toggle]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('toggle', tinymce.plugins.toggle);  
})();
