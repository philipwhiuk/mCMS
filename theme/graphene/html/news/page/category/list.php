<?php

class Template_Theme_Graphene_HTML_News_Page_Category_List extends Template {
	
	public $categories = array();
	public $articles = array();
	
	public function display(){
?>		
<div class="news page-news news-category-list page-news-category-list">
	<h1 class="news-archive-title">Category: <?php echo $this->category['title']; ?></h1>
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
	<div class="news-category-list-articles">
		<?php foreach($this->articles as $article){ ?> 
		<div class="news-article<?php echo $article['id']; ?> news-article">
			<div class="news-article-entry clearfix">
				<div class="date updated alpha ">
					<span class="value-title" title="2012-07-18T23:31">
					<p class="default_date">
					<span class="month">Jul</span>
					<span class="day">18</span>
					</p>
					</span>
				</div>
				<h2 class="news-article-title"><a href="<?php echo $article['furl']; ?>" rel="bookmark" title="Permalink to <?php echo $article['title']; ?>"><?php echo $article['title']; ?></a></h2>				
				<div class="news-article-meta clearfix">
					<span class="printonly">Categories: </span>
					<p class="meta-categories">
					<?php if(count($article['categories']) > 0) {
						foreach($article['categories'] as $category) { ?>
							<a href="<?php echo $category['url']; ?>" title="View all posts in Updates" rel="category"><?php echo $category['title']; ?></a>
						<?php }
					} else { ?>
						<a href="<?php echo $this->uncategorised['url']; ?>" title="View all uncategorised posts" rel="category"><?php echo $this->uncategorised['title']; ?></a>
					<?php } ?>
					</p>
					<p class="edit-post">(<a class="news-article-edit-link" href="<?php echo $article['editurl']; ?>" title="Edit Post">Edit Post</a>)</p>
					<p class="news-article-author author vcard">by <span class="fn nickname"><a href="<?php echo $article['authorurl']; ?>" class="url" rel="author"><?php echo $article['author']; ?></a></span></p>
				</div>
				<div class="news-article-content clearfix"><?php echo $article['body']; ?> </div> 
				<div class="news-article-footer clearfix">
					<p class="post-tags">This post has no tag</p>
					<p class="comment-link"><span class="comments-link">Comments off</span></p>
				</div>
					
			</div>
		</div>
		<?php } ?> 
	</ul>
	<?php } ?>  
</div>
<?php	
	}
	
}