<?php

class Template_Theme_Default_HTML_Error_Page_Main_View extends Template {
	private function printLine($tline) {
		?>
			<div class="error-line"><span class="error-line-function"><?php 
			if(isset($tline['class'])) { echo $tline['class']; }
			if(isset($tline['type'])) { echo $tline['type']; }
			echo $tline['function']; ?>(</span><?php
			$first = true;
			foreach($tline['args'] as $arg) {
				if(!$first) { echo ','; } else { $first = false; }
				if(is_object($arg)) { echo get_class($arg).' Object'; }
				else if(is_array($arg)) { echo 'Array size('.count($arg).'), {';
					$afirst = true;
					foreach($arg as $aarg) {
						if(!$afirst) { echo ','; } else { $afirst = false; }
						if(is_object($aarg)) { echo get_class($aarg).' Object'; }
						else if(is_array($aarg)) { echo 'Array size('.count($aarg).')'; }
						else { echo '"'.$aarg.'"'; 	}
							echo ', ';
					}
				echo '}';}
				else { echo '"'.$arg.'"'; 	}

			}
			?><span class="error-line-function">)</div><div class="error-line-file"><?php
			if(isset($tline['file'])) {
				echo $tline['file'];
			}
			if(isset($tline['line'])) {
				echo ' - Line '. $tline['line'];
			}
			?></span></div>
		<?php
	}

	public function display(){
?>		
<div class="page-error page-view error-view page-error-view">
	<div class="content-head">
		<h1	<?php if(count($this->modes) > 1){ ?> class="error-modes" <?php } ?>><?php echo $this->title; ?></h1>
		<?php if(count($this->modes) > 1){ ?>
		<ul class="error-modes">
			<?php foreach($this->modes as $mode){ ?> 
			<li <?php if($mode['selected']){ ?>class="error-mode-selected"<?php } ?>>
				<a href="<?php echo $mode['url']; ?>"><?php echo $mode['label']; ?></a>
			</li>
			<?php } ?> 
		</ul>
	<?php } ?> 
	</div>
	<div class="error-text">
		<?php echo $this->body; ?>
		<?php foreach($this->exceptions as $exception) { ?>
		<h2><?php echo $exception['name']; ?></h2>
		<div class="error-class"><?php echo $exception['class']; ?></div>
		<div class="error-message"><?php echo $exception['message']; ?></div>
		<div class="error-label">Produced By MCMS?</div>
			<div class="error-value"><?php if($exception['validSystemException']) {?>Yes<?php } else { ?>No <?php } ?></div>
		<div class="error-label">Trace:</div>	
			<div class="error-value">
			<?php foreach($exception['trace'] as $tline) {
				$this->printLine($tline);
			} ?>
			</div>				
		<?php } ?>
	</div> 
</div>
<?php	
	}	
}
