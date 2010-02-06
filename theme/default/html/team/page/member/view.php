<?php

class Template_Theme_Default_HTML_Team_Page_Member_View extends Template {
	public function display(){
?>		
<div class="team page-team team-member team-member-view page-team-member page-team-member-view">
	<h1><?php echo $this->team_title; ?></h1>
	<div class="team-member-inner">
		<h2><?php echo $this->member_name; ?> <?php if($this->member_role != ''){ ?> - <?php echo $this->member_role; ?><?php } ?></h2>
		<div class="team-member-role">
			<?php echo $this->member_role_body; ?> 
		</div>
		<div class="team-member-body">
			<?php echo $this->member_body; ?> 
		</div> 
	</div>
</div>
<?php	
	}	
}
