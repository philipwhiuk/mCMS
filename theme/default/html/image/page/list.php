<?php

class Template_Theme_Default_HTML_Image_Page_List extends Template {
	
	public $images = array();
	
	public function display(){
?>		
<div class="image page-image image-list page-image-list">
	<h1><?php echo $this->title; ?></h1>
	<ul>
		<?php foreach($this->images as $image){ ?>
		<li><a href="<?php echo $image['url']; ?>"><?php echo $image['name']; ?></a></li>
		<?php } ?>
	</ul> 
</div>
<?php	
	}	
}