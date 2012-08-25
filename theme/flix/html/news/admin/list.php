<?php

class Template_Theme_Flix_HTML_News_Admin_List extends Template {
	public $news_articles = array();
	
	public function display(){
?>		
<div class="admin-list news-admin-list">
	<h1><?php echo $this->title; ?></h1>
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous news-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next news-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing=0 cellpadding=0> 
		<tr class="odd">
			<th>&nbsp;</th>
			<th>Title</th>
			<th>Author</th>
			<th>Categories</th>
			<th>Tags</th>
			<th>Comments</th>
			<th>Date</th>
		</tr> 
		<tr class="even">
			<td><input type="checkbox" /></td>
			<td style="align: left;">Solomon's General Store - Jagex and RWT</td>
			<td>Philip</td>
			<td>Updates</td>
			<td>No Tags</td>
			<td>0</td>
			<td>2012/07/18 Published</td>
		</tr>
<?php 
		$a = 0;
		foreach($this->news_articles as $news_article){
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $news_article['title']; ?> 
			</td>
			<td class="link">
				<a href="<?php echo $news_article['edit']; ?>">
					<?php echo $this->edit; ?> 
				</a>
			</td>
		</tr> 
<?php
			$a = ($a + 1) % 2;
		}
?> 
	</table>
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous news-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next news-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}
