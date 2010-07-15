<?php

class Template_Theme_Default_HTML_Content_Admin_List extends Template {
	public function display(){
?>		
<div class="content-admin-list">
	<table> 
<?php 
		foreach($this->content as $content){
?>
		<tr>
			<td>
				<?php echo $content['title']; ?> 
			</td>
			<td>
				<a href="<?php echo $content['edit']; ?>">
					<?php echo $this->edit; ?> 
				</a>
			</td>
		</tr> 
<?php
		}
?> 
	</table>
</div>
<?php	
	}	
}
