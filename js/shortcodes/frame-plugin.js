(function() {  
    tinymce.create('tinymce.plugins.frame', {  
        init : function(ed, url) {  
            ed.addButton('frame', {  
                title : 'Insert Frame',  
                image : url + "/images/frame.png",
                onclick : function() {
					ed.focus();
					ed.selection.setContent('[frame align="LEFT | CENTER | RIGHT" caption="IMAGE CAPTION" height="150" lightbox="on" group="GROUP NAME" rounded="rounded" src="IMAGE LINK" video_thumbnail="VIDEO THUMBNAIL IMAGE" width="150"]');
                }
            });
        },
		createControl : function(n, cm) {
			return null;
		}
    });
    tinymce.PluginManager.add('frame', tinymce.plugins.frame);  
})();
