<?php

class Template_Theme_Graphene_HTML_Profile_Admin_Menu extends Template {
	public function display(){
?>		
	<div class="wp-menu-image"><a href="" aria-label="<?php echo $this->title; ?>"><br></a></div>
	<div class="wp-menu-arrow"><div></div></div>
	<a href="<?php echo $this->url; ?>" class="wp-first-item wp-has-submenu wp-has-current-submenu wp-menu-open menu-top menu-top-first menu-icon-dashboard menu-top-last" tabindex="1"><?php echo $this->title; ?></a>
		<div class="wp-submenu">
		<div class="wp-submenu-wrap">
			<div class="wp-submenu-head"><?php echo $this->title; ?></div>
			<ul>
				<?php 
				if($this->selected) { 
					$first = true;
					foreach ($this->items as $item) { ?>
						<li class="<?php if($first) { ?>wp-first-item <?php } if($item['current']) { ?>current<?php } ?>">
							<a href="<?php echo $item['url']; ?>" class="<?php if($first) { ?>wp-first-item <?php } if($item['current']) { ?>current<?php } ?>" tabindex="1"><?php echo $item['title']; ?></a>
						</li>
					<?php 
						$first = false;
					}
				}
				?>
			</ul>
	</div>
	</div>
<?php	
	}	
}
