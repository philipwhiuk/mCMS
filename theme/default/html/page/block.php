<?php

class Template_Theme_Default_HTML_Page_Block extends Template {
	public function display(){
?>		
<div class="page_block">
<?php
	$this->main->display();
?>
</div>
<?php	
	}	
}