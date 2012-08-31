<?php

class Template_Theme_Default_HTML_Film_Page_Genre extends Template {
	public function display(){
?>		
<div class="page-view film-genre page-film-genre film-genre-view page-film-genre-view"  style="border: 1px solid #444;">
	<h1><?php echo $this->title; ?></h1>
    <?php foreach($this->films as $film) { ?>
    <div class="film_title_box_outer">
		<div class="film_title_box" <?php if(isset($film['titleIMG'])) { ?>style="background-image: url('<?php echo $film['titleIMG']; ?>');"<?php } ?>>
			<a href="<?php echo $film['titleURL']; ?>"><?php echo $film['title']; ?></a>
		</div>
	</div>
    <?php } ?>
</div>
<?php	
	}	
}