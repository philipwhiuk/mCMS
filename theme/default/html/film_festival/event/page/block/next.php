<?php

class Template_theme_Default_html_film_festival_event_page_block_next extends Template {
	public $features = array();
	public $featureNames = array();
	public function __construct($data) {
		parent::__construct($data);
	}
	public 	function display() {
		?>
		<div class="multi-feature-display">
			<div class="domtab">

				<?php 
				$count = 0;
				foreach($this->features as $feature) { ?>
					<div style="background-image: url('theme/flix/images/film_festival/freshers_2010_<?php echo $feature->id; ?>.jpg');">
						<h2 class="event_film_festival_feature_title"><a name="feature<?php echo $count; ?>" id="feature<?php echo $count; ?>">
							<?php echo $feature->films[0]->title; ?>
						</a></h2>
						<?php $feature->display(); ?>
						<p><a href="#top">back to menu</a></p>
					</div>
					<?php $count++;
				} ?>
				<ul class="domtabs">
					<?php 
					$count = 0;
					foreach($this->featureNames as $featureName) { ?>
					<li><a href="#feature<?php echo $count; ?>"><?php echo $featureName; ?></a></li>
					<?php 
					$count++;
					} ?>
				</ul>
			</div>
		</div>
		<div style="clear: both;"></div>
		<?php
	}
}
