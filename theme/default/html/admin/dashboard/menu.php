<?php

class Template_Theme_Default_HTML_Admin_Dashboard_Menu extends Template {
	public function display(){
?>		
<div class="admin-dashboard-menu">
	<a href="<?php echo $this->url; ?>"><?php echo $this->name; ?></a>
</div>
<?php	
	}	
}
