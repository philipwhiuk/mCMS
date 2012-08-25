<?php
class Template_Theme_Flix_HTML_Film_Feature_Event_Page_Block_Next extends Template {
	public $films = array();
	public $showings = array();
	public $id;
	public $parentID;
	public function display($height=null,$width=null) {
		?>
		<div class="feature-display" <?php
			if(isset($this->smallImage)) { 
				if($height != null && $width != null) {
					?>style="background-image: url('<?php echo $this->smallImage->raw_url('max/'.$height.'/'.$width); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
				}
				elseif($height != null) {
					?>style="background-image: url('<?php echo $this->smallImage->raw_url('height/'.$height); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
				}
				elseif($width != null) {
					?>style="background-image: url('<?php echo $this->smallImage->raw_url('width/'.$width); ?>'); background-repeat: no-repeat; background-position: center-top; background-color: black;"<?php 
				}
			} ?>>
			<div class="feature-info">
				<?php
					foreach($this->films as $film) {
						$film->display();
					}
				?>
				<div class="feature-showings"><?php
					foreach($this->showings as $showing) {
						?><a href="<?php echo $this->url; ?>"><?php
						echo date("jS M Y",$showing[0]); ?></a><?php
					}
				?></div>
			</div>
		</div>
		<?php
	}
}
	