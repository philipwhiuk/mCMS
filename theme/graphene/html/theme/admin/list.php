<?php

class Template_Theme_Graphene_HTML_Theme_Admin_List extends Template {
	public function display(){
?>		
<div class="admin-list theme-admin-list">
	<div id="icon-themes" class="icon32"><br></div>
	<h2 class="nav-tab-wrapper">
		<a href="themes.php" class="nav-tab nav-tab-active"><?php echo $this->title; ?></a><a href="http://philip.whiuk.com/wp-admin/theme-install.php" class="nav-tab"><?php echo $this->install_title; ?></a>
	</h2>
	<div id="current-theme" class="has-screenshot">
		<a href="http://philip.whiuk.com/wp-admin/customize.php" class="load-customize hide-if-no-customize" title="Customize '<?php echo $this->current['title']; ?>'">
			<img src="<?php echo $this->current['image']; ?>" alt="Current theme preview">
		</a>
		<h3>Current Theme</h3>
		<h4><?php echo $this->current['title']; ?></h4>
		<div>
		<ul class="theme-info">
			<li><strong>By:</strong> <a href="<?php echo $this->current['url']; ?>" title="Visit author homepage"><?php echo $this->current['author']; ?></a></li>
			<li><strong>Version:</strong> <?php echo $this->current['version']; ?></li>
			<li><strong>Parent:</strong> <?php echo $this->current['parent']; ?></li>
		</ul>
		<p class="theme-description"><?php echo $this->current['description']; ?></p>
		</div>
		<br class="clear">
		<br class="clear">
		<div class="theme-options">
				<a id="customize-current-theme-link" href="http://philip.whiuk.com/wp-admin/customize.php" class="load-customize hide-if-no-customize" title="Customize '<?php echo $this->current['title']; ?>'">Customize</a>
				<span>Options:</span>
		<ul>
							<li><a href="widgets.php">Widgets</a></li>
							<li><a href="nav-menus.php">Menus</a></li>
							<li><a href="themes.php?page=graphene_options"><?php echo $this->current['title']; ?> Options</a></li>
							<li><a href="themes.php?page=graphene_faq"><?php echo $this->current['title']; ?> FAQs</a></li>
							<li><a href="themes.php?page=custom-header">Header</a></li>
							<li><a href="themes.php?page=custom-background">Background</a></li>
					</ul>
		</div>
	</div>
	<br class="clear">
	<form class="search-form filter-form" action="" method="get">
	<h3 class="available-themes">Available Themes</h3>
	<p class="search-box">
		<label class="screen-reader-text" for="theme-search-input">Search Installed Themes:</label>
		<input type="search" id="theme-search-input" name="s" value="">
		<input type="submit" name="" id="search-submit" class="button" value="Search Installed Themes">	<a id="filter-click" href="?filter=1">Feature Filter</a>
	</p>	
	<br class="clear">
	<div id="availablethemes">
		<?php foreach($this->themes as $theme){ if($theme['id']  != $this->current['id']) { ?>
		<div class="available-theme">
			<a href="<?php echo $theme['preview']; ?>" class="screenshot hide-if-no-customize">
				<img src="<?php echo $theme['image']; ?>" alt="">
			</a>
			<h3><?php echo $theme['title']; ?></h3>
			<div class="theme-author">By <a href="<?php echo $theme['url']; ?>" title="Visit author homepage"><?php echo $theme['author']; ?></a></div>
			<div class="action-links">
				<ul>
					<li><a href="<?php echo $theme['activate']; ?>" class="activatelink" title="Activate “Easel”">Activate</a></li>
					<li><a href="<?php echo $theme['preview']; ?>" class="load-customize hide-if-no-customize">Live Preview</a></li>
					<li class="hide-if-no-js"><a href="#" class="theme-detail" tabindex="4">Details</a></li>
				</ul>
				<div class="delete-theme"><a class="submitdelete deletion" href="<?php echo $theme['delete']; ?>" onclick="return confirm( 'You are about to delete this theme \'Easel\'\n  \'Cancel\' to stop, \'OK\' to delete.' );">Delete</a></div>	
			</div>
			<div class="themedetaildiv hide-if-js">
				<p><strong>Version: </strong>3.0.7</p>
				<p>A very intuitively designed theme that has a very robust set of options, CSS entities and abilities.  Is a *core* theme for plugins like Comic Easel.</p>
				<p>All of this theme’s files are located in <code>/themes/easel</code>.</p>
			</div>
		</div>
		<?php } } ?>
	</div>
	
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous theme-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next theme-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing=0 cellpadding=0> 
<?php 
		$a = 0;
		foreach($this->themes as $theme){
			if($theme['id']  != $this->current['id']) {
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $theme['title']; ?> 
			</td>
			<td>
				<?php echo $theme['parent']; ?> 
			</td>			
			<td class="link">
				<a href="<?php echo $theme['edit']; ?>">
					<?php echo $this->edit; ?> 
				</a>
			</td>
		</tr> 
<?php
			$a = ($a + 1) % 2;
			}
		}
?> 
	</table>
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous theme-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next theme-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}
