<?php

class Template_Theme_Default_HTML_Team_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<ul>
		<li class="header"><?php echo $this->name; ?></li>
		<li><a href="<?php echo $this->url; ?>">Add a team</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage teams</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
