<?php
class Template_Theme_Default_HTML_Forum_Page_Topic_Add extends Template {
	public $forum = array();
	public $parents = array();
	function display() {
		?>
        <div class="page-view topic-add forum-view forum-topic-add">
			<div class="forum_structure">
			<?php foreach($this->parents as $parent) { ?>
				<a href="<?php echo $parent['url']; ?>"><?php echo $parent['title']; ?></a>
				 <span class="forum_structure_divider"><</span> 
			<?php }?>
			<a href="<?php echo $this->forum['url']; ?>"><?php if($this->forum['parentID'] != 0) { echo $this->forum['title']; } else { echo 'Board Index'; } ?></a>
			</div>
			<h1><?php echo $this->title; ?></h1>
			<?php $this->form->display(); ?>
		</div>
		<?php
	}
}