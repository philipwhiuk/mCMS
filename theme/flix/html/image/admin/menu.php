<?php

class Template_Theme_Flix_HTML_Image_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?></li>
		<li><a href="<?php echo $this->url; ?>">Add an image</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage images</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
