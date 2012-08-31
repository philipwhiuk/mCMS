<?php

class Template_Theme_Default_HTML_Event_Page_Block_Next extends Template {
	public $objects = array();
	public function display(){
?>		
<div class="page-view event page-block-event event-next page-block-event-next">
	<?php foreach($this->objects as $object) {
		$object->display();
	}
	?>
</div>
<?php	
	}	
}