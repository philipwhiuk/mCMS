<?php

class Template_Theme_Default_HTML_Film_Festival_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<a href="<?php echo $this->url; ?>"><?php echo $this->name; ?></a>
</div>
<?php	
	}	
}
