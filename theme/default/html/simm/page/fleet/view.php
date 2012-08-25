<?php
class Template_Theme_Default_HTML_Simm_Page_Fleet_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->name; ?></h1>
		<h2>Sub-Fleets</h2>
		<ul>
		<?php
		foreach($this->sfleets as $sfleet) {
			?><li><?php echo $sfleet['name']; ?></li><?php
		}
		?>
		</ul>
		<h2>Simms</h2>
		<ul>
		<?php
		foreach($this->simms as $simm) {
			?><li><?php echo $simm['name']; ?>
			<?php echo $simm['image']; ?>
			<div class="simm-fleet-simm-details">
				<div class="simm-fleet-simm-label">Class:</div>
					<div class="simm-fleet-simm-value"><?php echo $simm['specification']; ?></div>
				<div class="simm-fleet-simm-label">Status:</div>
					<div class="simm-fleet-simm-value"><?php echo $simm['status']; ?></div>
				<div class="simm-fleet-simm-label">Age Rating:</div>
					<div class="simm-fleet-simm-value"><?php echo $simm['rating']; ?></div>
				<div class="simm-fleet-simm-label">Members:</div>
					<div class="simm-fleet-simm-value"><?php echo $simm['members']; ?></div>
			</div>
			<div class="simm-fleet-simm-manifest">
			<?php $simm['manifest']->display(); ?>
			</div></li><?php
		}
		?>
		</ul>
		<?php
	}

}