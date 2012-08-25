<?php

class Template_Theme_Flix_HTML_Film_Page_View extends Template {
	public $trailer;
	public function display(){
?>		
<div class="page-view film page-film film-view page-film-view"  style="border: 1px solid #444; 
	<?php if(isset($this->backgroundImage)) { ?>background-image: url(<?php echo $this->backgroundImage; ?>); <?php } ?>">
	<h1 class="film_title">film: <?php echo $this->title; ?></h1>
	<div class="tagline">"<?php echo $this->tagline; ?>"</div>
        <div class="filmbox">
            <div class="filmbox_hdr">Film Details</div>
            <div class="filmbox_inner">
                <div class="filmbox_trailer"><?php echo $this->trailer; ?></div>
                <div class="filmbox_details">
				<?php 	
				$first = true;
				foreach($this->role_actors as $role => $actors) {
					?><div class="filmbox_detail <?php if ($first) { $first = false; ?>filmbox_detail_top<?php } ?>">                    
									<span class="filmbox_label"><?php echo $role; ?><?php if(count($actors) > 1) { ?>s<?php } ?></span>
						<span class="filmbox_data">
							<?php foreach($actors as $actor) { ?>
								<li><a href="<?php echo $actor['url']; ?>"><?php echo $actor['name']; ?></a></li>
							<?php } ?>
						</span>
						<div style="clear:both"></div>
					</div><?php
				}
				?>
				<?php if(isset($this->certificate)) { ?>
					<div class="filmbox_detail">
						<span class="filmbox_label">Certificate:</span>
						<span class="filmbox_data"><?php echo $this->certificate; ?></span>
						<div style="clear:both"></div>
					</div>
				<?php }	if(isset($this->runtime)) {?>
					<div class="filmbox_detail">
						<span class="filmbox_label">Length:</span>
						<span class="filmbox_data"><?php echo $this->runtime; ?> minutes</span>
						<div style="clear:both"></div>
					</div>
				<?php }	if(isset($this->release_year)) {?>
					<div class="filmbox_detail">
						<span class="filmbox_label">Year:</span>
						<span class="filmbox_data"><?php echo $this->release_year; ?></span>
						<div style="clear:both"></div>
					</div>
				<?php }	if(isset($this->genres) && count($this->genres) > 0) {?>
					<div class="filmbox_detail">
						<span class="filmbox_label">Genre:</span>
						<span class="filmbox_data">
						<?php
							$first = true;
							foreach($this->genres as $genre) {
								if($first) { $first = false; } 
								else { echo '/'; } 
								?><a href="<?php echo $genre['url']; ?>"><?php echo $genre['name']; ?></a><?php
							}
						?>
						</span>
						<div style="clear:both"></div>
					</div>
				<?php }	if(isset($this->language)) {?>
					<div class="filmbox_detail">
						<span class="filmbox_label">Language:</span>
						<span class="filmbox_data"><?php echo $this->language; ?></span>
						<div style="clear:both"></div>
					</div>
				<?php } ?>
                 <div style="clear:both;"></div>
             </div>
             <div style="clear:left;"></div>
        </div>
	<h2>DESCRIPTION</h2>
	<div class="film_feature-description">
	<?php echo $this->description; ?>
	</div>
	<h2>SYNOPSIS</h2>
	<div class="film_feature-synopsis">
	<?php echo $this->synopsis; ?>
	</div>
	<div style="clear:left;"></div>
	</div>
<?php	
	}	
}