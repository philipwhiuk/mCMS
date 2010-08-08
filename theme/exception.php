<?php

class Theme_Exception extends CMS_Exception {}

class Theme_Unavailable_Exception extends Theme_Exception {}
class Theme_Not_Found_Exception extends Theme_Exception {}
class Theme_Template_Not_Found_Exception extends Theme_Exception {
	public function message(){
		return 'Template Not Found: ' . $this->data[0]->message();
	}	
}
