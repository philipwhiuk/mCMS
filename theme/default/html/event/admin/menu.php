<?php

class Template_Theme_Default_HTML_Event_Admin_Menu extends Template {
	public function display(){
?>		
<div class="event-admin-menu">
	<ul>
	<li class="header"><a href="<?php echo $this->url; ?>"><?php echo $this->name; ?></a></li>
	</ul>
</div>
<?php	
	}	
}
