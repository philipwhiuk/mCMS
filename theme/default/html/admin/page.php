<?php

class Template_Theme_Default_HTML_Admin_Page extends Template {
	public function display(){
?>		
<div class="admin page-admin">
	<div class="admin-menu">
		<ul>
		<?php foreach($this->menu as $item){ ?>
			<li><?php $item->display(); ?></li>
		<?php } ?>
		</ul>
	</div>
	<div class="admin-panel">
		<?php $this->panel->display(); ?>
	</div>
</div>
<?php	
	}	
}
