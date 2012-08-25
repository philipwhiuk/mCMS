<?php

class Template_Theme_Graphene_HTML_News_Page_Article_View extends Template {
	public $categories = array();
	public $uncategorised = array();

	public function display(){
?>		
<div class="news page-news news-article-view page-news-article-view">
	<div class="news-article<?php echo $this->id; ?> news-article">
		<div class="news-article-entry clearfix">
			<div class="date updated alpha ">
				<span class="value-title" title="<?php echo $this->time; ?>">
				<p class="default_date">
				<span class="month">Jul</span>
				<span class="day">18</span>
				</p>
				</span>
			</div>
			<h1 class="news-article-title"><a href="<?php echo $this->furl; ?>" rel="bookmark" title="Permalink to <?php echo $this->title; ?>"><?php echo $this->title; ?></a></h2>				
			<div class="news-article-meta clearfix">
				<span class="printonly">Categories: </span>
				<p class="meta-categories">
				<?php if(count($this->categories) > 0) {
					foreach($this->categories as $category) { ?>
						<a href="<?php echo $category['url']; ?>" title="View all posts in Updates" rel="category"><?php echo $category['title']; ?></a>
					<?php }
				} else { ?>
					<a href="<?php echo $this->uncategorised['url']; ?>" title="View all uncategorised posts" rel="category"><?php echo $this->uncategorised['title']; ?></a>
				<?php } ?>
				</p>
				<p class="edit-post">(<a class="news-article-edit-link" href="<?php echo $this->editurl; ?>" title="Edit Post">Edit Post</a>)</p>
				<p class="news-article-author author vcard">by <span class="fn nickname"><a href="<?php echo $this->authorurl; ?>" class="url" rel="author"><?php echo $this->author; ?></a></span></p>
			</div>
			<div class="news-article-content clearfix"><?php echo $this->body; ?> </div> 
			<div class="news-article-footer clearfix">
				<p class="post-tags">This post has no tag</p>
				<p class="comment-link"><span class="comments-link">Comments off</span></p>
			</div>
				
		</div>
	</div>
</div>
<?php	
	}	
}