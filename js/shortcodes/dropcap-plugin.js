(function() {  
    tinymce.create('tinymce.plugins.dropcap', {  
        init : function(ed, url) {  
            ed.addButton('dropcap', {  
                title : 'Insert Dropcap',  
                image : url + "/images/dropcap.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[dropcap background="#BACKGROUND_HEX" color="#FONT_HEX" type="circle"]DROPCAP TEXT[/dropcap]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('dropcap', tinymce.plugins.dropcap);  
})();
