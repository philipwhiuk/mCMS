<?php

class Template_Theme_Default_HTML_Form_Field_Textarea extends Template {
	
	public $label;
	
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
	<div class="form-field form-field-textarea">
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
				<textarea id="<?php echo $this->id(); ?>" name="<?php echo $this->name(); ?>" class="form-field form-field-textarea"><?php echo $this->value; ?></textarea>
			</div>
		</div>
	</div>
<?php 	
	}
	
}