(function() {  
    tinymce.create('tinymce.plugins.button', {  
        init : function(ed, url) {  
            ed.addButton('button', {  
                title : 'Insert Button',  
                image : url + "/images/button.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[button background="#BACKGROUND_HEX" colour="#TEXT_COLOUR_HEX" rounded="rounded" size="SMALL | MEDIUM | LARGE" hover_bg="#HOVER_BG_HEX" hover_color="#HOVER_COLOR_HEX"]BUTTON_TEXT[/button]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('button', tinymce.plugins.button);  
})();
