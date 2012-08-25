<?php
class Template_Theme_Flix_HTML_Film_Feature_Page_Block_Category_Next extends Template {
	public $films = array();
	public $showings = array();
	public $id;
	public $category = 0;
	public function display() {
		?>
	<div class="page-view feature page-block-feature feature-next page-block-feature-next page-block-feature-next-<?php echo $this->category; ?>">
		<div class="nextfeature-category-showings">
		<span class="nextfeature-category-showinghdr">Next Showing: 
			<?php foreach($this->films as $film) { 
				?><a href="<?php echo $this->url; ?>" class="nextfeature-category-showinghdr-title">
					<?php echo $film->name; ?>
				</a>
				<span class="nextfeature-category-showinghdr-rating"> (<?php echo $film->certificate; ?>)</span>
			<?php } ?>
		</span>
		<table class="nextfeature-category-showings"><tbody>
		<?php
		foreach($this->showings as $showing) {
			?><tr><th class='nextfeature-category-showingday'><?php
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
		?>
	</div>
		<?php
	}
}
	