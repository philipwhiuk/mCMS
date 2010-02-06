<?php

class Template_Theme_Default_HTML_Image_Gallery_Page_View extends Template {

	public function __construct($parent){
		parent::__construct($parent);
		$this->html->head('jquery', '<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js
"></script>');
		$this->html->head('image', '<script language="javascript" type="text/javascript" src="' . $this->theme->url('js/image.js') . '"></script><script language="javascript" type="text/javascript">image_init("' . $this->theme->url('images/loadingAnimation.gif') . '","' . $this->theme->url('images/tbclose.png') . '");</script>');
	}

// Replace with image code.
	public function get_file($target){
		ksort($this->files); 
		$current = null; $cfile = null;
		foreach($this->files as $match => $file){
			if($match == $target){
				return $file;
			}
			if(!isset($current) && $match > $target){
				return $file;
			} elseif(!isset($current)){
				$current = $match; $cfile = $file;
			} elseif($match < $target){
				$current = $match; $cfile = $file;
			} else { //if($current < $target, $match > $target){
				return $file;
			}
		}
		return $cfile;
	}

	public function display($others = array()){
		 $p = count($others);

?>
		<div class="gallery-items-images-selector">
			<ul> 
			<?php 
				$i = 0;
				foreach($others as $other){
					$i ++;
					if($i == 1){ ?>
			
				<?php 	} ?>
					<li><a href="<?php echo $other->furl; ?>">
						<img src="<?php $file = $other->get_file(110); echo $file['url']; ?>">							</a></li>
				<?php 	if($i == 5){ ?>
				<?php	$i = 0;
					} 
				}
				if($i != 0){ ?></div><?php } 
			?>
			</ul>
		</div>
<?php
	}


}
