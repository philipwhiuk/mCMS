<?php

class Template_Theme_Flix_HTML_Actor_Page_List extends Template {
	
	public $actor = array();
	
	public function display(){
?>		
<div class="page-list actor page-actor actor-list page-actor-list">
	<h1><?php echo $this->title; ?></h1>
	<div class="actor-list-section">
		<?php 	$count = 0;
			$actorlisttotal = (count($this->actor)/3); ?>
		<ul>
			<?php foreach($this->actor as $actor){ 
				if($count > $actorlisttotal) { 
					$count = 0;
					?></ul>
					<ul><?php 
				} ?>
				<li><a href="<?php echo $actor['url']; ?>"><?php echo $actor['name']; ?></a></li>
				<?php 	$count++; 
			} ?>
		</ul>
		<div style="clear: left;">&nbsp;</div>
	</div>
</div>
<?php	
	}	
}