<?php

class Template_Theme_Flix_HTML_File_Admin_Menu extends Template {
	public function display(){
?>		
<div class="file-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?></li>
		<li><a href="<?php echo $this->url; ?>">Add file</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage files</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
