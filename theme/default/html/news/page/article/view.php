<?php

class Template_Theme_Default_HTML_News_Page_Article_View extends Template {
	public function display(){
?>		
<div class="news page-news news-article-view page-news-article-view">
	<h1><?php echo $this->title; ?></h1>
	<div class="news-article-date">
		<?php echo $this->time; ?> 
	</div>
	<div class="news-article-text">
		<?php echo $this->body; ?> 
	</div> 
</div>
<?php	
	}	
}