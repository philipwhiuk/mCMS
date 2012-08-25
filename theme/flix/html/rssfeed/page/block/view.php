<?php

class Template_Theme_Flix_HTML_RSSFeed_Page_Block_View extends Template {
	public function display(){
?>		
<div class="rssfeed page-block-rssfeed">
	<img src="/theme/flix/images/rssfeed/industry RSS.gif" />
	<div class="rssfeed-items">
		<?php foreach($this->items as $item) { ?>
		<div class="item">
			<div class="title"><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></div>
		</div>		
		<?php }		?>
	</div>
</div>
<?php	
	}	
}