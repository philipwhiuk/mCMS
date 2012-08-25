<?php

class Template_Theme_Flix_HTML_Form extends Template {
	public $fields = array();
	function display(){
?>
	<div class='form'>
		<form method='post' action='<?php echo $this->url; ?>' class='form'>
			<ol>
<?php 
	foreach($this->fields as $field) {
?> 
				<li>
<?php 
		$field->display();
?> 
				</li>
<?php
	} 
?>
			</ol>
		</form>
	</div>
<?php 
	}
	
}