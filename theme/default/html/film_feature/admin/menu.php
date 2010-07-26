<?php

class Template_Theme_Default_HTML_Film_Feature_Admin_Menu extends Template {
	public function display(){
?>		
<div class="admin-menu-item">
	<a href="<?php echo $this->url; ?>"><?php echo $this->name; ?></a>
	<ul><li><a href="<?php echo $this->slist_url; ?>"><?php echo $this->slist_name; ?></a></li></ul>
</div>
<?php	
	}	
}
