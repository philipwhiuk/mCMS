<?php

class Template_Theme_Default_HTML_Menu_Admin_Menu extends Template {
	public function display(){
?>		
<div class="menu-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?></li>
		<li><a href="<?php echo $this->url; ?>">Add a menu</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage menus</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
