<?php

class Template_Theme_Default_HTML_Menu_Page_Block_View extends Template {

	public function display(){
		if($this->level == 0){
			$this->display_top();
		} else {
			$this->display_child();
		}
	}

	public function display_child(){
?>
<div class="menu-child">
	<ul>
<?php 
		foreach($this->items as $item){
			$class = array();
			if($item['trail']){
				$class[] = 'menu-trail';
			}
			if($item['current']){
				$class[] = 'menu-current';
			}
	?> 
		<li <?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>" <?php } ?>>
			<a href="<?php echo $item['url']; ?>"<?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>" <?php } ?>>
				<?php echo $item['name']; ?> 
			</a>
<?php if($item['child']){ $item['child']->display(); } ?> 
		</li>
<?php
		}
	?>
	</ul>
</div>
<?php
	}

	public function display_top(){
?>		
<div class="menu page-block-menu menu-view page-block-menu-view">
	<ul>
<?php 
		foreach($this->items as $item){
			$class = array();
			if($item['trail']){
				$class[] = 'menu-trail';
			}
			if($item['current']){
				$class[] = 'menu-current';
			}
	?>
		<li<?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>" <?php } ?>>
			<a href="<?php echo $item['url']; ?>"<?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>"<?php } ?>>
				<?php echo $item['name']; ?> 
			</a>
<?php if($item['child']){ $item['child']->display(); } ?> 
		</li>
<?php
		}
	?> 
	</ul>
</div>
<?php	
	}	
}
