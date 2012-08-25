<?php

class Template_Theme_Flix_HTML_News_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?> Articles</li>
		<li><a href="<?php echo $this->url; ?>">Add an article</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage articles</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
		<li class="header"><?php echo $this->name; ?> Categories</li>
		<li><a href="<?php echo $this->url; ?>">Add an category</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage categories</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
