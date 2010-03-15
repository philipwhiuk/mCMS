<?php

class Template_RSS_Main extends Template {

	public function display(){

// DUMB XML / PHP CLASH
echo'<?xml version="1.0" encoding="utf-8" ?>'; 
?> 
<rss version="2.0">
	<?php 
		$this->main->display();
	?> 
</rss>
<?php
	}

}


