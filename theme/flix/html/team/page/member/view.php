<?php

class Template_Theme_Flix_HTML_Team_Page_Member_View extends Template {
	public function display(){
?>		
<div class="page-view team page-team team-member team-member-view page-team-member page-team-member-view">
	<h1><a href="<?php echo $this->team_url; ?>"><?php echo $this->team_title; ?></a></h1>
	<div class="team-member-inner">
		<h2><?php 
			if($this->member_role != ''){ 
				?><?php echo $this->member_role; ?> - <?php 
			}
			if($this->member) {
				echo $this->member_name; 
			} 
			else {
				echo $this->vacant;
			}?> </h2>
		<div class="team-member-role">
			<?php echo $this->member_role_body; ?> 
		</div>
		<?php if($this->member) { ?>
		<h3>About <?php echo $this->member_name; ?></h3>
		<div class="team-member-body">
			<?php echo $this->member_body; ?> 
		</div> 
		<?php } ?>
	</div>
</div>
<?php	
	}	
}
