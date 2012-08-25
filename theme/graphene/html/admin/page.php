<?php

class Template_Theme_Graphene_HTML_Admin_Page extends Template {
	public function display(){
?>		
<div class="admin page-admin">
	<div class="admin-menu-back"></div>
	<div class="admin-menu-wrap">
		<div class="admin-menu-shadow"></div>
		<ul class="admin-menu" role="navigation">
		<?php $first = true;
			foreach($this->menu as $item){ ?>
			<li class="<?php 
				if($first) { ?>wp-first-item <?php } 
				if($item['hasSubItems']) { ?>wp-has-submenu <?php }
				if($item['selected'] && $item['hasSubItems']) {?>wp-has-current-submenu <?php }
				if(!$item['selected'] && $item['hasSubItems']) {?>wp-not-current-submenu <?php }
				?>menu-top menu-icon-<?php echo $item['module']; ?>"><?php $item['value']->display(); ?></li>
		<?php 
			$first = false;
		} ?>
		</ul>
	</div>
	<div class="admin-panel">
		<?php $this->panel->display(); ?>
	</div>
</div>
<?php	
	}	
}
