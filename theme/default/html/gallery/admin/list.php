<?php

class Template_Theme_Default_HTML_Gallery_Admin_List extends Template {
	public $galleries = array();

	public function display(){
?>		
<div class="admin-list gallery-admin-list">
	<h1><?php echo $this->title; ?></h1>
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous gallery-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next gallery-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing=0 cellpadding=0> 
<?php 
		$a = 0;
		foreach($this->galleries as $gallery){
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $gallery['title']; ?> 
			</td>
			<td class="link">
				<a href="<?php echo $gallery['edit']; ?>">
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
	<a class="admin-list-previous gallery-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next gallery-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}
