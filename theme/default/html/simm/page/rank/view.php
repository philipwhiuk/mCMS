<?php
class Template_Theme_Default_HTML_Simm_Page_Rank_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->title; ?></h1>
		<h2>Serving Officers At This Rank</h2>
		<ul>
		<?php foreach($this->characters as $character) { ?>
			<li><?php echo $character['rank']; ?> <a href="<?php echo $character['bio_url']; ?>"><?php echo $character['fname']; ?> <?php echo $character['lname']; ?></a>
			<ul>
			<?php foreach($character['positions'] as $position) { ?>
			<li><?php echo $position['position']; ?>, <?php echo $position['department']; ?>, <?php echo $position['simm']; ?></li>
			<?php } ?>
			<ul>
		<?php } ?>
		</ul>		
		<?php
	}

}