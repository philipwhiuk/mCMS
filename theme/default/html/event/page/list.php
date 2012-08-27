<?php

class Template_Theme_Default_HTML_Event_Page_List extends Template {
	
	public $events = array();
	
	public function display(){
?>		
<div class="film page-film film-list page-film-list">
	<h1><?php echo $this->title; ?></h1>
	<ul>
		<?php foreach($this->events as $event){ ?>
		<li><a href="<?php echo $event['url']; ?>"><?php echo $event['name']; ?></a></li>
		<?php } ?>
	</ul> 
</div>
<?php	
	}	
}