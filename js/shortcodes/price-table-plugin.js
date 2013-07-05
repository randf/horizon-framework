(function() {  
    tinymce.create('tinymce.plugins.price_table', {  
        init : function(ed, url) {  
            ed.addButton('price_table', {  
                title : 'Insert Price Table',  
                image : url + "/images/price-table.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[price_table category="PRICE TABLE CATEGORY SLUG" num="3"]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('price_table', tinymce.plugins.price_table);  
})();
