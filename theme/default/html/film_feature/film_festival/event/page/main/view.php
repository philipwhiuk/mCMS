<?php
class Template_Theme_Flix_HTML_Film_Feature_Film_Festival_Event_Page_Main_View extends Template {
	public $films = array();
	public $id;
	public $parentID;
	public function display() {
		
		?>
		<div class="filmbox">
			<div class="filmbox_hdr"><?php echo $this->title; ?></div>
			<div class="filmbox_inner"><?php foreach($this->films as $film) {$film->display();} ?>
				<div class="showingsbox">
					<div class="showings_hdr">Showings</div>
					<?php
						foreach($this->showings as $showing) {
						?><div class='showing'><?php echo date("jS F Y",$showing[0]); ?>
							<?php
								foreach($showing as $date) {
								echo date("g:iA",$date);
							}
							?>
							</div>
							<?php			
						}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}
	