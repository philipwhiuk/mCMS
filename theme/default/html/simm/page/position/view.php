<?php
class Template_Theme_Default_HTML_Simm_Page_Position_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->title; ?></h1>
		<?php echo $this->description; ?>
		<h2>Commonly Found In</h2>
		<ul>
		<?php foreach($this->departments as $department) { ?>
			<li><?php echo $department['title']; ?></li>
		<?php } ?>
		</ul>
		<h2>Serving Officers</h2>
		<ul>
		<?php foreach($this->characters as $character) { ?>
			<li><?php echo $character['rank']; ?> <?php echo $character['fname']; ?> <?php echo $character['lname']; ?>, <?php echo $character['simm']; ?></li>
		<?php } ?>
		</ul>		
		<?php
	}

}