<?php

class Template_Theme_Default_HTML_Film_Feature_Page_View extends Template {
	public $showings = array();
	public $films = array();
	public function display(){
?>
<div>		
<div class="film_feature page-film_feature film_feature-view page-film_feature-view" style="border: 1px solid #444; width: 890px; padding-left 5px; padding-right: 5px; margin: auto;
	<?php if(isset($this->backgroundImage)) { ?>background-image: url(<?php echo $this->backgroundImage; ?>);<?php } ?>">
	<h1 class="film_title">film: <?php echo $this->title; ?></h1>
	<?php
		foreach($this->films as $film) {
        		if(isset($film->tagline)) { ?>
				<div class="tagline">"<?php echo $film->tagline; ?>"</div>
			<?php }
		}
	?>
    <div class="showingsbox">
	<div class="showings_hdr">Showings</div>
	    <?php foreach($this->showings as $showing) { ?>
    	<div class="showing"><?php echo date("l jS M Y",$showing); ?>, <?php echo date("g:iA",$showing); ?></div>
        <?php } ?>
    </div>
	<?php foreach($this->films as $film) {
		$film->display();
	}
	?>
    </div>
</div>
</div>
<?php	
	}	
}