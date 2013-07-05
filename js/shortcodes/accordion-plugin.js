(function() {  
    tinymce.create('tinymce.plugins.accordion', {  
        init : function(ed, url) {  
            ed.addButton('accordion', {  
                title : 'Insert Accordion',  
                image : url + "/images/accordion.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[accordion]<br />\
							[acc_item active="active" title="ACCORDION TITLE HERE"]ACCORDION CONTENT[/acc_item]<br />\
							[acc_item title="ACCORDION TITLE HERE"]ACCORDION CONTENT[/acc_item]<br />\
							[acc_item title="ACCORDION TITLE HERE"]ACCORDION CONTENT[/acc_item]<br />\
						[/accordion]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);  
})();
