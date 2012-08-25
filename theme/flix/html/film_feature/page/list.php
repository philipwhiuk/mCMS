<?php

class Template_Theme_Flix_HTML_Film_Feature_Page_List extends Template {
	
	public $features = array();
	
	public function display(){
?>		
<div class="film_feature page-film_feature film_feature-list page-film_feature-list page-view">
	<h1><?php echo $this->title; ?></h1>
	<div class='filmlistboxes_section'>
	<div class='filmlistboxes'>
    	<?php		
		foreach($this->items as $item){
            	?>
		<div class='filmlistbox_outer'>
                    <div class='filmlistbox filmlistbox<?php echo $item['category']; ?>'>
                        	<div class='filmlistbox_inner' style="<?php if(isset($item['smallImage'])) { ?>background-image: url(<?php echo $item['smallImage']; ?>); <?php } ?> background-position: center center;">
                           		<div class='filmlistbox_title'>
						<a href='<?php echo $item['url']; ?>'><?php echo $item['title']; ?></a>
					</div>
                            	<div class='filmlistbox_date'>
						<a href='<?php echo $item['url']; ?>'><?php $day = current($item['showings']); echo date("jS M Y",$day['time']); ?>
							<br /><?php $first=true; 
										foreach($item['showings'] as $showing) { 
											if(!$first) { ?>, <?php } 
											else { $first=false; } 
											echo date("G:ia",$showing['time']);
										} ?></a></div>
                         	</div>
                    </div>
		</div>
        	<?php
		}
	?>
    	</div>
	</div>
     <div style="clear: both;">&nbsp;</div>
</div>
<?php	
	}	
}