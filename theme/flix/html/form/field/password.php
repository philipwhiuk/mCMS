<?php

class Template_Theme_Flix_HTML_Form_Field_Password extends Template {

	
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
	<div class="form-field form-field-password">
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
				<input type="password" id="<?php echo $this->id(); ?>" value="" name="<?php echo $this->name(); ?>" class="form-field form-field-password">
			</div>
		</div>
	</div>
<?php 	
	}
	
}