<?php

class Template_Theme_Flix_HTML_Image_Gallery_Page_View extends Template {

	public function display($others = array()){
		 $p = count($others);
		 $system = MCMS::Get_Instance();

?>
		<div class="gallery-items-images-selector">
			<div class="a">
			<?php 
				$i = 0;
				foreach($others as $other){
					$i ++;
					if($i == 1){ ?>
				<div class="b"> 
				<?php 	} ?>
					<a class="gallery-items-images-image" href="<?php echo $other->furl; ?>"><div class="c"><div class="d">
						<div class="e" style="background-image: url('<?php 
							echo $other->image->raw_url('max/300/150');
						 ?>');"></div>
					</div></div></a>
				<?php 	if($i == 5){ ?>
				</div>
				<?php	$i = 0;
					} 
				}
				if($i != 0){
					for(; $i < 5; $i ++){
						?><a></a><?php
					}
					?>
				</div><?php } 
			?>
			</div>
		</div>
<?php
	}


}