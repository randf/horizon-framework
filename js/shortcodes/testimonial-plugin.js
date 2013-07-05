(function() {  
    tinymce.create('tinymce.plugins.testimonial', {  
        init : function(ed, url) {  
            ed.addButton('testimonial', {  
                title : 'Insert Testimonial',  
                image : url + "/images/testimonial.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[testimonial type="SLIDER | STATIC" category="CATEGORY SLUG" num_posts="5"]ON THE FLY TESTIMONIAL TEXT. REMOVE THIS IF USING CUSTOM POST TYPE[/testimonial]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('testimonial', tinymce.plugins.testimonial);  
})();
