<?php

class Template_Theme_Flix_HTML_TinyMCE_Field extends Template {
	
	public $label;
	
	public function __construct($data){
		parent::__construct($data);
		$this->html->head('jquery',
'<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
		$this->html->head('tinymce',
'<script type="text/javascript" language="javascript" src="' . $this->theme->url('js/tinymce/jquery.tinymce.js') . '"></script>
<script type="text/javascript" language="javascript" src="' . $this->theme->url('js/tinymce.js') . '"></script>
<script type="text/javascript" language="javascript">
	tinymce_init(
		\'' . $this->theme->url('js/tinymce/tiny_mce.js') . '\', 
		\'' . $this->filebrowser . '\', 
		\'' . $this->theme->url('css/tinymce.css') . '\'
	);
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