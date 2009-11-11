<?php

class Template_Theme_Default_HTML_News_Page_Category_List extends Template {
	
	public $categories = array();
	public $articles = array();
	
	public function display(){
?>		
<div class="news page-news news-category-list page-news-category-list">
	<h1><?php echo $this->category['title']; ?></h1>
	<div class="news-category-list-desc">
		<?php echo $this->category['body']; ?> 
	</div>
	<?php if(count($this->categories) > 0){ ?> 
	<ul class="news-category-list-categories">
		<?php foreach($this->categories as $category){ ?> 
		<li>
			<h2><a href="<?php echo $category['url']; ?>"><?php echo $category['title']; ?></a></h2>
			<?php echo $category['body']; ?> 
		</li>
		<?php } ?> 
	</ul>
	<?php } ?> 
	<?php if(count($this->articles) > 0){ ?> 
	<ul class="news-category-list-articles">
		<?php foreach($this->articles as $article){ ?> 
		<li>
			<div class="news-article">
				<h2><a href="<?php echo $article['url']; ?>"><?php echo $article['title']; ?></a></h2>
				<div class="news-date"><?php echo $article['time']; ?></div>
				<div class="news-article-text">
					<?php echo $article['body']; ?> 
				</div> 
			</div>
		</li>
		<?php } ?> 
	</ul>
	<?php } ?>  
</div>
<?php	
	}
	
}