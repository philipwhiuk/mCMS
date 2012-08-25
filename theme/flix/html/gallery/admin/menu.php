<?php

class Template_Theme_Flix_HTML_Gallery_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?></li>
		<li><a href="<?php echo $this->url; ?>">Add a gallery</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage galleries</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
		<li class="header"><?php echo $this->name; ?> Items</li>
		<li><a href="<?php echo $this->url; ?>">Add an image</a></li>
		<li><a href="<?php echo $this->url; ?>">Add a video</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage items</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
