<?php

class Template_Theme_Flix_HTML_Film_Page_List extends Template {
	
	public $film = array();
	
	public function display(){
?>		
<div class="page-view film page-film film-list page-film-list">
	<h1><?php echo $this->title; ?></h1>
	<ul>
		<?php foreach($this->film as $film){ ?>
		<li><a href="<?php echo $film['url']; ?>"><?php echo $film['name']; ?></a></li>
		<?php } ?>
	</ul> 
</div>
<?php	
	}	
}