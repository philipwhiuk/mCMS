<?php
class Template_Theme_Default_HTML_Film_Feature_Page_Block_Coming_Soon extends Template {
	public $features = array();
	public function display() {
		?>
		<div class="feature-coming_soon page-block-feature-coming_soon feature-coming_soon-view page-block-feature-coming_soon-view">
		<ul class='coming_soon'>
		<?php
		foreach($this->features as $feature) {
			?>
			<div class="film_coming_soon_box">
			<li class="coming_soon_film">
				<div class='film_coming_soon_date'> 
				<a href="<?php echo $feature['url']; ?>">
				<?php foreach($feature['showings'] as $showing) {
					echo date("jS F Y",$showing[0]).'<br/>';
					$first = true;
					foreach($showing as $date) {
						if(!$first) {
						?>, <?php
						}
						$first = false;
						echo date("g:iA",$date);
					}
					
				} ?></a></div>
				<div class='film_coming_soon_title'><a href="<?php echo $feature['url']; ?>"><?php echo $feature['title']; ?></a></div>				
			</li>
			</div>
			<?php
		}
		?>
		</ul>
        </div><?php
	}
}
?>