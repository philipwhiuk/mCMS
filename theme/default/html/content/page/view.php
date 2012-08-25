<?php

class Template_Theme_Default_HTML_Content_Page_View extends Template {
	public function display(){
?>		
<div class="content page-content content-view page-content-view">
	<div class="content-head">
		<h1	class="content-title <?php if(count($this->modes) > 1){ ?>content-title-modes<?php } ?>" ><?php echo $this->title; ?></h1>
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
		<?php echo $this->body; ?> 
	</div> 
</div>
<?php	
	}	
}
