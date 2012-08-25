<?php

class Template_Theme_Default_HTML_News_Page_Block_Article_View extends Template {
	public function display(){
?>		
<div class="news page-news news-article-view page-news-article-view">
	<a href="<?php echo $this->surl; ?>"><h2><?php echo $this->b_title; ?></h2></a>
	<div class="news-article-date">
		<?php echo $this->time; ?> 
	</div>
	<div class="news-article-text">
		<?php echo $this->b_body; ?> 
		<p>
			<a href="<?php echo $this->surl; ?>">To read more, click here.</a>
	</div> 
</div>
<?php	
	}	
}
