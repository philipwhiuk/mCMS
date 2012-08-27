<?php

class Template_Theme_Graphene_HTML_Forum_Admin_List extends Template {
	public function display(){
?>		
<div class="admin-list forum-admin-list">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
	<h2><?php echo $this->title; ?> <a href="<?php echo $this->addurl;?>" class="add-new-h2">Add New</a> </h2>
	<p><?php echo $this->description; ?></p>
	
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous forum-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next forum-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
	<table cellspacing="1">
		<colgroup><col class="col1"><col class="col2"><col class="col3"></colgroup>
		<tbody>		
			<?php foreach($this->forum as $forum){ ?>
			<tr>
				<td style="width: 5%; text-align: center;"><img src="<?php echo $this->theme->url('images/icon_folder.gif'); ?>" alt="Folder"></td>
				<td>
					<strong><a href="<?php echo $forum['edit']; ?>"><?php echo $forum['title']; ?></a></strong>
					<br><span><?php echo $forum['description']; ?></span><br><br><span>Topics: <strong><?php echo $forum['topic_count']; ?></strong> / Posts: <strong><?php echo $forum['post_count']; ?></strong></span>
				</td>
				<td style="vertical-align: top; width: 100px; text-align: right; white-space: nowrap;">
					
					<img src="<?php echo $this->theme->url('images/icon_up_disabled.gif'); ?>" alt="<?php echo $this->up; ?>" title="<?php echo $this->up; ?>">
					<img src="<?php echo $this->theme->url('images/icon_down_disabled.gif'); ?>" alt="<?php echo $this->down; ?>" title="<?php echo $this->down; ?>">
					
					<a href="<?php echo $forum['edit']; ?>">
						<img src="<?php echo $this->theme->url('images/icon_edit.gif'); ?>" alt="<?php echo $this->edit; ?>" title="<?php echo $this->edit; ?>">
					</a>
					
					<a href="<?php echo $forum['resync']; ?>" onclick="popup_progress_bar();">
						<img src="<?php echo $this->theme->url('images/icon_sync.gif'); ?>" alt="<?php echo $this->resync; ?>" title="<?php echo $this->resync; ?>">
					</a>
					
					<a href="<?php echo $forum['delete']; ?>">
						<img src="<?php echo $this->theme->url('images/icon_delete.gif'); ?>" alt="<?php echo $this->delete; ?>" title="<?php echo $this->delete; ?>">
					</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	
	<?php if($this->page > 1){ ?>
	<a class="admin-list-previous forum-admin-list-previous" href="<?php echo $this->pages[$this->page - 1]; ?>">
		<div>&laquo;<?php echo $this->page - 1; ?></div>
	</a>
	<?php } ?>
	<?php if($this->page < $this->page_count){ ?>
	<a class="admin-list-next forum-admin-list-next" href="<?php echo $this->pages[$this->page + 1]; ?>">
		<div><?php echo $this->page + 1; ?>&raquo;</div>
	</a>
	<?php } ?>
</div>
<?php	
	}	
}
