
function tinymce_init(tinymce, filemanager, css){ 
	$().ready(function() {
		
		var tinymce_filebrowser = function(field_name, url, type, win){
			
			var wurl = filemanager + '?output=inline&tinymce[type]=' + type + '&tinymce[url]=' + url;
			
			tinyMCE.activeEditor.windowManager.open({
		        file : wurl,
		        title : 'My File Browser',
		        width : 700,  // Your dimensions may differ - toy around with them!
		        height : 400,
		        resizable : "yes",
		        popup_css : false,
		        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
		        close_previous : "no"
		    }, {
		        window : win,
		        input : field_name
		    });
			
			return false;
			
		};
		
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : tinymce,
			theme : "advanced",
			plugins : "safari,style,layer,table,save,advhr,advimage,advlink,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,visualchars,nonbreaking,xhtmlxtras",
			
			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,advhr,|,print,|,ltr,rtl",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "center",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			
			inline : true,
			
			file_browser_callback : tinymce_filebrowser,
			
			// URLs
			
			relative_urls : false,
			
			// Example content CSS (should be your site CSS)
			content_css : css
			
			// Drop lists for link/image/media/template dialogs"
		});
	});
}
