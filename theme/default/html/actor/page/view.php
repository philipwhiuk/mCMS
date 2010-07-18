<?php

class Template_Theme_Flix_HTML_Actor_Page_View extends Template {
	public $leads = array();
	public function display(){
?>		
<div class="page-view actor page-actor actor-view page-actor-view">
	<h1><?php echo $this->title; ?></h1>
	<h2>Biography</h2>
	<div class="biography">
	<?php echo $this->body; ?> 
	</div>
	<h2>Filmography at FLIX Cinema</h2>
	<div class="film_title_boxes">
		<?php $role = "";
		foreach($this->film_roles as $film_role) {
			if($film_role['role'] != $role) { $role = $film_role['role']; ?>
				<h3><a href="<?php echo $film_role['roleURL']; ?>"><?php echo $role; ?> Roles</a></h3>
			<?php } ?>
			<div class="film_title_box_outer">
				<div class="film_title_box" <?php if(isset($film_role['titleIMG'])) { ?>style="background-image: url('<?php echo $film_role['titleIMG']; ?>');"<?php } ?>>
					<a href="<?php echo $film_role['titleURL']; ?>"><?php echo $film_role['title']; ?></a>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php if(count($this->leads) != 0) { ?>
		<h2>Lead Actor Roles</h2>
		<div class="role-lead"><?php 
			foreach($this->leads as $lead) {
				?>
				<div class="role-film-box">
					<img src="<?php echo $lead['url']; ?>" class="role-film-box-image" />
					<div class="role-film-box-title"><?php echo $lead['title']; ?></div>
				</div>
				<?php
			}
		?>
		</div>
	<?php } ?>
	<?php if(count($this->modes) > 1){ ?>
		<ul class="content-modes">
			<?php foreach($this->modes as $mode){ ?> 
			<li <?php if($mode['selected']){ ?>class="content-mode-selected"<?php } ?>>
				<a href="<?php echo $mode['url']; ?>"><?php echo $mode['label']; ?></a>
			</li>
			<?php } ?> 
		</ul>
	<?php } ?> 
</div>
<?php	
	}	
}