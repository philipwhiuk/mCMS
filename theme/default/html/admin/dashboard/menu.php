<?php

class Template_Theme_Default_HTML_Admin_Dashboard_Menu extends Template {
	public $selected;

	public function display(){
?>		
<div class="admin-dashboard-menu">
	<ul>
		<li class="header"><li><a href="<?php echo $this->url; ?>"><?php echo $this->title; ?></a></li>
		<?php if($this->selected) { foreach ($this->items as $item) { ?>
		<li><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></li>
		<?php } } ?>
	</ul>
</div>
<?php	
	}	
}
