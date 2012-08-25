<?php
class Template_Theme_Flix_HTML_Film_Feature_Film_Festival_Event_Page_Block_Next extends Template {
	public $films = array();
	public $id;
	public $parentID;
	public function display() {
		foreach($this->films as $film) {
			$film->display();
		}
		?><div class="festival-feature-showings"><?php
		foreach($this->showings as $showing) {
			?><a href="<?php echo $this->url; ?>"><?php
			echo date("jS M Y",$showing[0]); ?></a><?php
		}
		?></div><?php
	}
}
	