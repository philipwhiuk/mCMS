<?php

class Template_Theme_Default_HTML_TinyMCE extends Template {
	
	public $label;
	
	public function __construct($data){
		parent::__construct($data);
		$this->html->head('jquery',
'<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
		$this->html->head('tinymce',
'<script type="text/javascript" language="javascript" src="' . $this->theme->url('js/tinymce/jquery.tinymce.js') . '"></script>
<script type="text/javascript" language="javascript">
	$().ready(function() {
		$(\'textarea.tinymce\').tinymce({
			// Location of TinyMCE script
			script_url : \'' . $this->theme->url('js/tinymce/tiny_mce.js') . '\',
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
			theme_advanced_resize_horizontal : false,
			
			// URLs
			
			relative_urls : false,
			
			// Example content CSS (should be your site CSS)
			content_css : "' . $this->theme->url('css/tinymce.css') . '",
			
			// Drop lists for link/image/media/template dialogs"
		});
	});
</script>'); 
	}
	
	public function id(){
		return 'form-field-' . implode($this->id, '-');
	}
	
	public function name(){
		$first = true;
		$return = '';
		foreach($this->id as $id){
			if($first){
				$return .= $id;
			} else {
				$return .= "[{$id}]";
			}
			$first = false;
		}
		return $return;
	}
	
	public function display(){
?> 
	<div class="form-field form-field-tinymce tinymce">
<?php 
		if(isset($this->label)){
?>
		<div class="form-field-label">
			<label for="<?php echo $this->id(); ?>"><?php echo $this->label; ?></label>
		</div>
<?php 
		}
?>
		<div class="form-field-input">
			<div class="form-field-input-inner">
				<textarea id="<?php echo $this->id(); ?>" name="<?php echo $this->name(); ?>" class="form-field form-field-tinymce tinymce"><?php echo $this->value; ?></textarea>
			</div>
		</div>
	</div>
<?php 	
	}
	
}