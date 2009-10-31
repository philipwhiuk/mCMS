<?php

class Template_Theme_Default_HTML_Form_Field_Submit extends Template {
	
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
	<div class="form-field form-field-submit">
		<div class="form-field-input">
			<input type="submit" id="<?php echo $this->id(); ?>" <?php if(isset($this->label)){ ?> value="<?php echo $this->label; ?>" <?php } ?>name="<?php echo $this->name(); ?>" class="form-field form-field-submit">
		</div>
		<br clear='all'>
	</div>
<?php 	
	}
	
}