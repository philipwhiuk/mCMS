<?php
	class Template_Theme_Default_HTML_Film_Film_Feature_Film_Festival_Event_Page_Block_Next extends Template {
		function display() {
			if($this->video != "") {
				?><br /><?php echo $this->video;
				?><br /><?php 
			}
			elseif($this->largeImageURL != "") {
				?><div style="text-align: center; width:100%">
					<img src="<?php echo $this->largeImageURL; ?>" alt="" height="400" align="center" class="nextevent-festival-feature-film-largeImage" /></div><?php
			}
			else {
				?><div style="text-align: center; height:200px;">&nbsp;</div><?php
			}
		}
	
	}
?>