<?php

class Template_Theme_Default_HTML_Content_Admin_List extends Template {
	public function display(){
?>		
<div class="content-admin-list">
	<h1><?php echo $this->title; ?></h1>
	<table cellspacing=0 cellpadding=0> 
<?php 
		$a = 0;
		foreach($this->content as $content){
?>
		<tr <?php if($a == 0){ ?> class="even" <?php } else { ?> class="odd" <?php } ?>>
			<td>
				<?php echo $content['title']; ?> 
			</td>
			<td class="link">
				<a href="<?php echo $content['edit']; ?>">
					<?php echo $this->edit; ?> 
				</a>
			</td>
		</tr> 
<?php
			$a = ($a + 1) % 2;
		}
?> 
	</table>
</div>
<?php	
	}	
}
