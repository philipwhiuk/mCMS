<?php

class Template_Theme_Flix_HTML_Content_Page_Edit extends Template {
	public function display(){
?>		
<div class="page-edit content page-content content-edit page-content-edit">
	<div class="content-head">
		<h1
			<?php if(count($this->modes) > 1){ ?> 
			class="content-modes"
			<?php } ?> 
		><?php echo $this->title; ?></h1>
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
	<div class="content-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
