<?php

class Template_theme_flix_html_film_festival_event_page_main_view extends Template {
	public $features = array();
	public $featureNames = array();
	public function __construct($data) {
		parent::__construct($data);
		// $this->html->head('domtab','<script type="text/javascript" src="/theme/flix/js/domtab.js"></script>');
	}
	public function display() {
		?>
		<div class="page-view event page-event page-event-film_festival page-event-film_festival-view">
			<h1 class="film_festival_title"><?php echo $this->title; ?></h1>
			<?php foreach($this->features as $feature) {
				$feature->display(); 	
			} ?>
		</div>
		<?php
	}
}
