<?php 

class Template_Theme_Default_HTML_Team_Page_View extends Template {

	public function display(){
?> 
<div class="team page-team team-view page-team-view">
	<?php if($this->team['title'] != ''){ ?><h1><?php echo $this->team['title']; ?></h1><?php } ?> 
	<?php echo $this->team['body']; ?> 
	<div class="team-subteams">
		<ul>
			<?php foreach($this->teams as $team){ ?> 
			<li <?php if($team['selected']){ ?> class="team-subteam-selected" <?php } ?> style="width: <?php echo 100 / count($this->teams); ?>%;">
				<a href="<?php echo $team['surl']; ?>"><?php echo $team['title']; ?></a>
			</li>
			<?php } ?> 
		</ul>
	</div>
	<?php if(isset($this->selected) && count($this->selected) > 0){ ?>
	<div class="team-subteam-members team-members">
		<ul>
			<?php foreach($this->selected as $member){ ?> 
			<li>
				<div class="team-member-inner">
					<a href="<?php echo $member['url']; ?>"><p><?php echo $member['member_title']; ?></p><p><?php echo $member['role_title']; ?></p></a>
				</div>
			</li>
			<?php } ?> 
		</ul>
	</div>
	<?php } ?>
	<div class="team-direct-members team-members">
		<ul>
			<?php foreach($this->members as $member){ ?> 
			<li>
				<div class="team-member-inner">
					<a href="<?php echo $member['url']; ?>"><p><?php echo $member['member_title']; ?></p><p><?php echo $member['role_title']; ?></p></a>
				</div>
			</li>
			<?php } ?> 
		</ul>
	</div>
</div>
<?php
	}

}
