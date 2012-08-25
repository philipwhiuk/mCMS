<?php
class Template_Theme_Default_HTML_Simm_Page_Department_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->title; ?></h1>
		<?php echo $this->description; ?>
		<?php foreach($this->positions as $position) { ?>
			<h2><?php echo $position['title']; ?></h2>
			<?php echo $position['description']; ?>
		<?php }
	}

}