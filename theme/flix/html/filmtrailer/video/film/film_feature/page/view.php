<?php
	class Template_Theme_Default_HTML_Filmtrailer_Film_Film_Feature_Page_View extends Template {
		public $video;
		public $channel;
		function display() {
			$width = 640;
			$height = 385;
			?>
			<object width="<?php echo $width; ?>" height="<?php echo $height; ?>">
<param name="movie" value="http://www.player.filmtrailer.com/v3.4/player.swf?file=http://uk.player-feed.previewnetworks.com/cinema/<?php echo $video; ?>/<?php echo $channel; ?>/&display_title=always&menu=true&enable_link=true&default_quality=large&controlbar=over&autostart=false&backcolor=241D16&frontcolor=7F7F7F&share=1&repeat=always&volume=80&linktarget=_blank"/>
<param name="wmode" value="transparent" />
<param name="allowFullScreen" value="true" />
<param name="allowScriptAccess" value="always" />
<embed id="player" name="player" type="application/x-shockwave-flash" 
	src="http://www.player.filmtrailer.com/v3.4/player.swf?file=http://uk.player-feed.previewnetworks.com/cinema/<?php echo $video; ?>/<?php echo $channel; ?>/&display_title=always&menu=true&enable_link=true&default_quality=large&controlbar=over&autostart=false&backcolor=241D16&frontcolor=7F7F7F&share=1&repeat=always&displayclick=play&volume=80&linktarget=_blank" 
	width="<?php echo $width; ?>" height="<?php echo $height; ?>"allowFullScreen="true" allowScriptAccess="always">
				</embed>
			</object>
			<?php
		}
	}