<?php

class Template_Theme_Flix_HTML_Content_Admin_Menu extends Template {
	public function display(){
?>		
<div class="content-admin-menu">
	<ul>
		<li class="header"><?php echo $this->title; ?></li>
		<?php foreach ($this->items as $item) { ?>
		<li><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></li>
		<?php } ?>
	</ul>
</div>
<?php	
	}	
}
