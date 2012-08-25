<?php
class Template_Theme_Default_HTML_Simm_Page_Bio_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->rank['title'].' '.$this->lastname.', '.$this->firstname.' '.$this->middlename; ?></h1>
		<h2>Character Information</h2>
		<div class="simm-character-info">
			<div class="simm-character-label">Name</div>
			<div class="simm-character-field"><?php echo $this->firstname; ?> <?php echo $this->middlename; ?> <?php echo $this->lastname; ?></div>
			<div class="simm-character-label">Rank</div>
			<div class="simm-character-field"><?php echo $this->rank['title']; ?></div>
			<div class="simm-character-label">Species</div>
			<div class="simm-character-field"><?php echo $this->species; ?></div>
			<div class="simm-character-label">Age</div>
			<div class="simm-character-field"><?php echo $this->age; ?></div>
			<div class="simm-character-label">Position(s)</div>
			<div class="simm-character-field"><?php 
				foreach($this->positions as $position) {
					echo $position['position'].', '.$position['manifest'];
				} ?></div>			
		</div>
		<?php
		foreach($this->contentSections as $contentSection) {
			?><h2><?php echo $contentSection['title']; ?></h2><?php
			echo $contentSection['body'];
		}
		?>
		<h2>Service Record</h2>
		<?php
		foreach($this->serviceRecord as $record) {
			var_dump($record);
		}
		?>
		<h2>Awards</h2>
		<?php
		foreach($this->serviceRecord as $record) {
			var_dump($record);
		}
		?>
		<h2>Posting History</h2>
		<?php
		foreach($this->posts as $post) {
			var_dump($post);
		}
	}

}