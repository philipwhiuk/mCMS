<?php

class Template_Theme_Default_HTML_Menu_Page_Block_View extends Template {
	
	public function display_section($links, $level){
		if($level > 4){ return; }
?> 
		<ul>
			<?php foreach($links as $link){ ?> 
				<li class="<?php if($link['trail']){ ?>menu-trail<?php } ?> <?php if($link['current']){ ?>menu-current<?php } ?>">
					<a href="<?php echo $link['url']; ?>" class="<?php if($link['trail']){ ?>menu-trail<?php } ?> <?php if($link['current']){ ?>menu-current<?php } ?>">
						<?php echo $link['name']; ?> 
					</a>
					<?php 
						if(count($link['children']) > 0){ 
							$this->display_section($link['children'], $level + 1);
						}		
					?> 
				</li>
			<?php } ?> 
		</ul>
<?php
	}
	
	public function display(){
?>		
<div class="menu page-block-menu menu-view page-block-menu-view">
	<?php 
		if(isset($this->items[0]) && count($this->items[0]['children']) > 0){
			$this->display_section($this->items[0]['children'], 1);
		}
	?> 
</div>
<?php	
	}	
}