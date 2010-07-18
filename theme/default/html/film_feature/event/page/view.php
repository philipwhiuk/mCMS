<?php
class Template_Theme_Flix_HTML_Film_Feature_Event_Page_View extends Template {
	public $films = array();
	public function __construct($parent) {
		parent::__construct($parent);
	}
	public function display() {
		foreach($this->films as $film) {
			$film->display();
		}
	}
}
	