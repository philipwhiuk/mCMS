<?php

class Template_Theme_Flix_HTML_Film_Page_Language extends Template {
	public function display(){
?>		
<div class="page-view film-language page-film-language film-language-view page-film-language-view"  style="border: 1px solid #444;">
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