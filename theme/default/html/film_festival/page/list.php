<?php
class Template_Theme_Default_HTML_Film_Festival_Page_List extends Template {
	function display() {
		?><div class="page-view">
		<h1><?php echo $this->title; ?></h1>
		<ul>
			<?php foreach($this->items as $film_festival){ ?>
			<li><a href="<?php echo $film_festival['url']; ?>"><?php echo $film_festival['name']; ?></a></li>
			<?php } ?>
		</ul> 
		</div><?php
	}
}