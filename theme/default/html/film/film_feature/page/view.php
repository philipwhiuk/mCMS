<?php
class Template_Theme_Default_HTML_Film_Film_Feature_Page_View extends Template {
	public $director;
	public $trailer;
	public function __construct($parent) {
		parent::__construct($parent);
	}
	public function display() {
		?>
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
                	<div class="filmbox_detail">
                	    <span class="filmbox_label">Certificate:</span>
                	    <span class="filmbox_data"><?php echo $this->certificate; ?></span>
                        <div style="clear:both"></div>
                    </div>
                	<div class="filmbox_detail">
                	    <span class="filmbox_label">Length:</span>
                	    <span class="filmbox_data"><?php echo $this->runtime; ?> minutes</span>
                        <div style="clear:both"></div>
                    </div>
                	<div class="filmbox_detail">
            	        <span class="filmbox_label">Year:</span>
            	        <span class="filmbox_data"><?php echo $this->release_year; ?></span>
                        <div style="clear:both"></div>
                    </div>
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
				?></span>
                        <div style="clear:both"></div>
                    </div>
                	<div class="filmbox_detail">
            	        <span class="filmbox_label">Language:</span>
            	        <span class="filmbox_data"><?php echo $this->language; ?></span>
                        <div style="clear:both"></div>
                    </div>
                 </div>
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
	