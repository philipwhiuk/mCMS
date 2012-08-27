<?php

class Template_Theme_Graphene_HTML_Simm_Admin_Overview extends Template {
	public function display(){
?>		
<div class="admin-list simm-admin-list">
	<div id="icon-index" class="icon32"><br></div>
	<h2><?php echo $this->title; ?></h2>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder columns-2">
			<div id="postbox-container-1" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables">
					<div id="dashboard_right_now" class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span>Right Now</span></h3>
						<div class="inside">
							<div class="table table_content">
								<p class="sub">Content</p>
								<table>
									<tbody>
										<tr class="first">
											<td class="first b b-simms"><a href="<?php echo $this->characters['url']; ?>"><?php echo $this->characters['count']; ?></a></td>
											<td class="t simms"><a href="edit.php"><?php echo $this->characters['title']; ?></a></td>
										</tr>
										<tr>
											<td class="first b b_positions"><a href="<?php echo $this->positions['url']; ?>"><?php echo $this->positions['count']; ?></a></td>
											<td class="t positions"><a href="<?php echo $this->positions['url']; ?>"><?php echo $this->positions['title']; ?></a></td>
										</tr>
										<tr>
											<td class="first b b_departments"><a href="<?php echo $this->departments['url']; ?>"><?php echo $this->departments['count']; ?></a></td>
											<td class="t departments"><a href="<?php echo $this->departments['url']; ?>"><?php echo $this->departments['title']; ?></a></td>
										</tr>
										<tr>
											<td class="first b b_simms"><a href="<?php echo $this->simms['url']; ?>"><?php echo $this->simms['count']; ?></a></td>
											<td class="t simms"><a href="<?php echo $this->simms['url']; ?>"><?php echo $this->simms['title']; ?></a></td>
										</tr>
										<tr>
											<td class="first b b-fleets"><a href="<?php echo $this->fleets['url']; ?>"><?php echo $this->fleets['count']; ?></a></td>
											<td class="t fleets"><a href="<?php echo $this->fleets['url']; ?>"><?php echo $this->fleets['title']; ?></a></td>
										</tr>
										<tr>
											<td class="first b b-tags"><a href="<?php echo $this->missions['url']; ?>"><?php echo $this->missions['count']; ?></a></td>
											<td class="t tags"><a href="<?php echo $this->missions['url']; ?>"><?php echo $this->missions['title']; ?></a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br class="clear" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br class="clear">
</div>
<?php	
	}	
}
