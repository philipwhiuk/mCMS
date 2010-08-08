<?php

class Template_Theme_Default_HTML_Gallery_Admin_Menu extends Template {
	public function display(){
?>		
<div class="gallery-admin-menu">
	<?php echo $this->name; ?>
	<ul>
		<li><a href="<?php echo $this->url; ?>">Add a gallery</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage galleries</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
	<?php echo $this->nameb; ?>
	<ul>
		<li><a href="<?php echo $this->url; ?>">Add an image</a></li>
		<li><a href="<?php echo $this->url; ?>">Add a video</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage items</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
