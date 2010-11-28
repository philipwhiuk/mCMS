<?php

class Template_Theme_Default_HTML_Video_Admin_Menu extends Template {
	public function display(){
?>		
<div class="video-admin-menu">
	<?php echo $this->name; ?>
	<ul>
		<li><a href="<?php echo $this->url; ?>">Add a video</a></li>
		<li><a href="<?php echo $this->url; ?>">Manage videos</a></li>
		<li><a href="<?php echo $this->url; ?>">Permissions</a></li>
	</ul>
</div>
<?php	
	}	
}
