<?php
	class Template_Theme_Flix_HTML_Film_Film_Feature_Film_Festival_Event_Page_Main_View extends Template {
		function display() {
			?>
			<div class="filmbox_trailer"><?php echo $this->video; ?></div>
			<div class="filmbox_details"></div>
			<div style="clear: both;">&nbsp;</div>
			<?php
		}
	
	}
?>