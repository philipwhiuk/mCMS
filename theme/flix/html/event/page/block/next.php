<?php

class Template_Theme_Flix_HTML_Event_Page_Block_Next extends Template {
	public $objects = array();
	public function display($location = null){
?>		
<div class="page-view event page-block-event event-next page-block-event-next">
	<?php 
	switch($location) {
		case 'crt':
			$height = null;
			$width = 475;
			break;
		case 'crbl':
			$height = 200;
			$width = null;
			break;
		case 'crbr':
			$height = 200;
			$width = null;
			break;
		default:
		case 'cl':
			$height = 450;
			$width = null;
			break;
	}
	
	foreach($this->objects as $object) {
		$object->display($height,$width);
	}
	?>
</div>
<?php	
	}	
}