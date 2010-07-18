<?php
class Template_Theme_Default_HTML_Film_Feature_Film_Festival_Event_Page_Block_Next extends Template {
	public $films = array();
	public $id;
	public $parentID;
	public function display() {
		foreach($this->films as $film) {
			$film->display();
		}
		?>
		<br />
		<span class='nextevent-festival-feature-showinghdr'>Showings</span>
		<?php
		foreach($this->showings as $showing) {
			?><span class='nextevent-festival-feature-showingday'><?php
			echo date("jS M Y",$showing[0]); ?></span><?php
			$first = true;
			foreach($showing as $date) {
				?><span class='nextevent-festival-feature-showingtime'><?php
				echo date("g:iA",$date);
				?></span><br /><?php
			}			
		}
	}
}
	