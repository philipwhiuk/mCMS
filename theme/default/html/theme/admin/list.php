<?php

class Template_Theme_Default_HTML_Theme_Admin_List extends Template {
	public function display(){
?>		
<div class="admin-list theme-admin-list">
	<h1><?php echo $this->title; ?></h1>
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous theme-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next theme-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing=0 cellpadding=0> 
<?php 
		$a = 0;
		foreach($this->themes as $theme){
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $theme['title']; ?> 
			</td>
			<td>
				<?php echo $theme['parent']; ?> 
			</td>			
			<td class="link">
				<a href="<?php echo $theme['edit']; ?>">
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
	<a class="admin-list-previous theme-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next theme-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}
