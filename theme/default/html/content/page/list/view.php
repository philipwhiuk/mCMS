<?php

class Template_Theme_Default_HTML_Content_Page_List_View extends Template {
	
	public $content = array();
	
	public function display(){
?>		
<div class="content page-content page-view content-list list-view page-content-view page-content-list page-content-list-view">
	<div class="content-head">
		<h1	<?php if(count($this->modes) > 1){ ?> class="content-modes" <?php } ?>><?php echo $this->title; ?></h1>
		<?php if(count($this->modes) > 1){ ?>
		<ul class="content-modes">
			<?php foreach($this->modes as $mode){ ?> 
			<li <?php if($mode['selected']){ ?>class="content-mode-selected"<?php } ?>>
				<a href="<?php echo $mode['url']; ?>"><?php echo $mode['label']; ?></a>
			</li>
			<?php } ?> 
		</ul>
	<?php } ?> 
	</div>
	<div class="content-text">
		<ul>
			<?php foreach($this->content as $content){ ?>
			<li><a href="<?php echo $content['view_url']; ?>"><?php echo $content['title']; ?></a></li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php	
	}	
}