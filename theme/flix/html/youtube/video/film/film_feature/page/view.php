<?php
	class Template_Theme_Default_HTML_YouTube_Film_Film_Feature_Page_View extends Template {
		public $video;
		function display() {
			$width = 640;
			$height = 385;
			?>
			<object width="<?php echo $width; ?>" height="<?php echo $height; ?>">
				<param name="movie" value="http://www.youtube.com/v/<?php echo $video; ?>&hl=en_GB&fs=1&"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed src="http://www.youtube.com/v/<?php echo $video; ?>&hl=en_GB&fs=1&" 
					type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></embed>
			</object>
			<?php
		}
	}