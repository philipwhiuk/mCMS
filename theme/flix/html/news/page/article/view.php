<?php

class Template_Theme_Flix_HTML_News_Page_Article_View extends Template {
	public function display(){
?>		
<div class="page-view news page-news news-article-view page-news-article-view">
	<h2><?php echo $this->title; ?></h2>
	<div class="news-article-date">
		<?php echo $this->time; ?> 
	</div>
	<div class="news-article-text">
		<?php echo $this->body; ?> 
	</div>
    <?php if(count($this->modes) > 1){ ?>
		<ul class="news-article-modes">
			<?php foreach($this->modes as $mode){ ?> 
			<li <?php if($mode['selected']){ ?>class="news-article-mode-selected"<?php } ?>>
				<a href="<?php echo $mode['url']; ?>"><?php echo $mode['label']; ?></a>
			</li>
			<?php } ?> 
		</ul>
    <?php } ?> 
</div>
<?php	
	}	
}