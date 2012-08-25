<?php
class Template_Theme_Flix_HTML_Menu_Page_Block_View extends Template {
	public $id;
	public $name;
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
		$first = true;
		foreach($this->items as $item){
			$class = array();
			if($item['trail']){
				$class[] = 'menu-trail';
			}
			if($item['current']){
				$class[] = 'menu-current';
			}
			if($first){
				$class[] = 'menu-first';
			}
	?> 
		<li <?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>" <?php } ?>>
			<a href="<?php echo $item['url']; ?>"<?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>" <?php } ?>>
				<?php echo $item['name']; ?> 
			</a>
<?php if($item['child']){ $item['child']->display(); } ?> 
		</li>
<?php
			$first = false;
		}
	?>
	</ul>
</div>
<?php
	}

	public function display_top(){
?>		
<div class="menu menu<?php echo $this->id; ?> page-block-menu menu-view page-block-menu-view">
	<ul>
<?php 
		$first = true;
		foreach($this->items as $item){
			$class = array();
			if($item['trail']){
				$class[] = 'menu-trail';
			}
			if($item['current']){
				$class[] = 'menu-current';
			}
			if($first) {
				$class[] = 'menu-first';
			}
			?>
		<li <?php if(count($class) > 0){ ?>class="<?php echo join(' ',$class);?>"<?php } ?>>
			<a href="<?php echo $item['url']; ?>"<?php if(count($class) > 0){ ?> class="<?php echo join(' ',$class);?>"<?php } ?>>
				<?php echo $item['name']; ?> 
			</a>
		</li>
<?php if($item['child']){ $item['child']->display(); } 
			$first = false;
		} ?>
	</ul>
</div>
<?php	
	}	
}