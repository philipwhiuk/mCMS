<?php
class Template_Theme_Default_HTML_Film_Feature_Event_Page_Block_Next extends Template {
	public $films = array();
	public $showings = array();
	public $id;
	public $parentID;
	public function display() {
		?>
		<div class="nextevent-feature-showings">
		<span class="nextevent-feature-showinghdr">Next Showing: 
			<?php foreach($this->films as $film) { 
				?><a href="<?php echo $this->url; ?>" class="nextevent-feature-showinghdr-title">
					<?php echo $film->name; ?>
				</a>
				<span class="nextevent-feature-showinghdr-rating"> (<?php echo $film->certificate; ?>)</span>
			<?php } ?>
		</span>
		<table class="nextevent-feature-showings"><tbody>
		<?php
		foreach($this->showings as $showing) {
			?><tr><th class='nextevent-feature-showingday'><?php
				echo date("jS F Y",$showing[0]); 
			?></th><?php
			$first = true;
			foreach($showing as $date) {
				?><td class='nextevent-feature-showingtime'><?php
				echo date("g:iA",$date);
				?></td><?php
			}
			?></tr><?php
		}
		?>
		</tbody></table>
		</div>
		<?php
		foreach($this->films as $film) {
			$film->display();
		}
	}
}
	