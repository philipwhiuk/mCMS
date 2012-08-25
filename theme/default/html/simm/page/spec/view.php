<?php
class Template_Theme_Default_HTML_Simm_Page_Spec_View extends Template {
	public $title;
	public function display() {
		?>
		<h1>Ship Database</h1><br />
		<h2><?php echo $this->name; ?> Class <?php echo $this->type; ?></h2>
		<u><b>Category: <?php echo $this->category; ?></b></u><br /><br />
		<img src="<?php echo $this->image; ?>" alt="<?php echo $this->imagedesc; ?>" width="200" height="100"><br /><br />
		Expected Duration: 150 years<br />
		Time Between Refit: <?php echo $this->resupply; ?> years<br /><br />
		<h3>Personnel</h3>
		Officers: <?php echo $this->officers; ?><br />
		Enlisted Crew: <?php echo $this->enlisted; ?><br />
		Marines: <?php echo $this->marines; ?><br />
		Passengers: <?php echo $this->passengers; ?><br />
		Starship Docking Capacity: <?php echo $this->docking; ?><br />
		<br />
		<h3>Dimensions</h3>
		Diameter: <?php echo $this->length; ?> metres<br />
		Main Height: <?php echo $this->width; ?> metres<br />
		Overall Height: <?php echo $this->height; ?> metres<br />
		Decks: 215<br /><br />
		<h3>Auxiliary Craft</h3>
		Shuttlebays: <?php echo $this->shuttlebays; ?><br />
		<h3>Armament</h3>
		<h3>Description</h3>
		<?php echo $this->description; ?>
		<h3>Design Notes</h3>
		<?php echo $this->notes;?>
		<h3><?php echo $this->name; ?> <?php echo $this->type; ?>s Currently In Service</h3>
		<ul>
		<?php foreach ($this->simms as $simm) { ?>
		<li><?php echo $simm['name']; ?></li>
		<?php } ?>
		</ul>
		<?php
	}

}