<?php

class Template_theme_flix_html_film_festival_event_page_block_next extends Template {
	public $features = array();
	public $featureNames = array();
	public function __construct($data) {
		parent::__construct($data);
		$this->html->head('domtab','<script type="text/javascript" src="/theme/flix/js/domtab.js"></script>');
	}
	public 	function display($height=null,$width=null) {
		 ?>
		<div class="festival-display" <?php
			if(isset($this->features[0])) {			
				if(isset($this->features[0]->smallImage)) { 
					if($height != null && $width != null) {
						?>style="background-image: url('<?php echo $this->features[0]->smallImage->raw_url('max/'.$height.'/'.$width); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
					}
					elseif($height != null) {
						?>style="background-image: url('<?php echo $this->features[0]->smallImage->raw_url('height/'.$height); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
					}
					elseif($width != null) {
						?>style="background-image: url('<?php echo $this->features[0]->smallImage->raw_url('width/'.$width); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
					}
				}
			} 
		?>>
			<div class="festival-info">
				<h3><?php echo $this->title; ?></h3>
				<div class="festival-feature"><?php if(isset($this->features[0])) { $this->features[0]->display(); } ?></div>
			</div>
		</div>
		<?php
	}
}
