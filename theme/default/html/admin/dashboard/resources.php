<?php

class Template_Theme_Default_HTML_Admin_Dashboard_Resources extends Template {
	public $resources = array();

	public function display(){
?>		
<div class="admin-list admin-dashboard-resources">
	<h1><?php echo $this->title; ?></h1>
	<?php if(($this->page > 1) && ($this->page <= $this->page_count)){ ?>
	<a class="admin-list-previous admin-dashboard-resources-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } else if($this->page > 1) { ?>
	<a class="admin-list-previous admin-dashboard-resources-previous" href="<?php echo $this->pages[count($this->pages)]; ?>">
		<div>&laquo;<?php echo count($this->pages); ?></div>
	</a>
	<?php }?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next admin-dashboard-resources-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing=0 cellpadding=0> 
		<tr class="odd">
			<th><?php echo $this->resourcePath; ?></th>		
			<th><?php echo $this->edit; ?></th>
		</tr>
	<?php 
		$a = 0;
		foreach($this->resources as $resource){
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $resource['path']; ?> 
			</td>
			<td class="link">
				<a href="<?php echo $module['edit']; ?>">
					<?php echo $this->edit; ?> 
				</a>
			</td>
		</tr> 
<?php
			$a = ($a + 1) % 2;
		}
?> 
	</table>
	<?php if(($this->page > 1) && ($this->page < $this->page_count)){ ?>
	<a class="admin-list-previous admin-dashboard-modules-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } else if($this->page > 1) { ?>
	<a class="admin-list-previous admin-dashboard-modules-previous" href="<?php echo $this->pages[count($this->pages)]; ?>">
		<div>&laquo;<?php echo count($this->pages); ?></div>
	</a>
	<?php }?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next admin-dashboard-modules-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}