<?php

class Template_Theme_Default_HTML_File_Admin_Menu extends Template {
	public function display(){
?>		
<div class="file-admin-menu">
	<a href="<?php echo $this->url; ?>"><?php echo $this->name; ?></a>
</div>
<?php	
	}	
}
