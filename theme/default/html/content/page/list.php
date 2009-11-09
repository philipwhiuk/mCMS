<?php

class Template_Theme_Default_HTML_Content_Page_List extends Template {
	
	public $content = array();
	
	public function display(){
?>		
<div class="content page-content content-list page-content-list">
	<h1><?php echo $this->title; ?></h1>
	<ul>
		<?php foreach($this->content as $content){ ?>
		<li><a href="<?php echo $content['url']; ?>"><?php echo $content['name']; ?></a></li>
		<?php } ?>
	</ul> 
</div>
<?php	
	}	
}