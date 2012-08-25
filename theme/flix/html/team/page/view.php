<?php 

class Template_Theme_Flix_HTML_Team_Page_View extends Template {

	public function display(){
		?> 
		<div class="team page-team team-view page-team-view page-view">
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
						<h2><?php echo $member['role_title']; ?></h2>
						<div class="team-member-inner">
						<p><?php echo $member['role_body']; ?></p>
						<p><b>Current Incumbent:</b> 
						<?php 
							if($member['member']) { 
								?><p><a href="<?php echo $member['url']; ?>"><?php echo $member['member_title']; ?></a></p> <?php
							} 
							else { 
								?>
									<?php echo $this->position_vacant; ?></p> 
								<p>	<a href="<?php echo $member['url']; ?>"><?php echo $this->view_info_on_role; ?></a>
								</p><?php

							} 

						?>
						</div>
					<?php } ?>				
				</ul>
			</div>
		</div>
		<?php
	}

}
