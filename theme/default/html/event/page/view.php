<?php

class Template_Theme_Flix_HTML_Event_Page_View extends Template {
	public $objects = array();
	public function display(){
		foreach($this->objects as $object) {
			$object->display();
		}
	}	
}