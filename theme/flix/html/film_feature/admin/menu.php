<?php

class Template_Theme_Flix_HTML_Film_Feature_Admin_Menu extends Template {
	public function display(){
?>		
<div class="flix-admin-menu">
	<ul>
		<li class="header"><?php echo $this->feature_title; ?></li>
		<?php foreach ($this->feature_items as $item) { ?>
		<li><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></li>
		<?php } ?>
		<li class="header"><?php echo $this->showing_title; ?></li>
		<?php foreach ($this->showing_items as $item) { ?>
		<li><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></li>
		<?php } ?>		
	</ul>	
</div>
<?php	
	}	
}
