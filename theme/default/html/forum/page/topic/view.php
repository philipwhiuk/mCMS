<?php

class Template_Theme_Default_HTML_Forum_Page_Topic_View extends Template {
	public $posts = array();
	public $forum = array();
	public $parents = array();
	public function display() {
		?>
        <div class="page-view topic-view forum-view forum-topic-view">
        <div class="forum_structure">
        <?php foreach($this->parents as $parent) { ?>
        	<a href="<?php echo $parent['url']; ?>"><?php echo $parent['title']; ?></a>
             <span class="forum_structure_divider"><</span> 
		<?php }?>
        <a href="<?php echo $this->forum['url']; ?>"><?php echo $this->forum['title']; ?></a>
        </div>
        <h1><?php echo $this->title; ?></h1>
        <?php echo $this->description; ?>
        <?php foreach($this->posts as $post) {
			?><div class="post">
			<div class="user"><a href="<?php echo $post['author']['url']; ?>"><?php echo $post['author']['name']; ?></a></div>
            <h2><?php echo $post['title']; ?></h2>
            <div class="post_info">
            	<a href="<?php echo $post['url']; ?>">View Post</a>
                <a href="<?php echo $post['author']['url']; ?>"><?php echo $post['author']['name']; ?></a>
                 >> <?php echo $post['date']; ?></div>
			
			<div class="post_body"><?php echo $post['body']; ?></div>
            <?php if($post['edit']) { ?>
	            <div class="edit_info">Last edited by <?php echo $post['editauthor']; ?> on <?php echo $post['editdate']; ?>, edited <?php echo $post['editcount']; ?> times in total.</div>
			<?php } ?>
            <div class="signature">
            <?php echo $post['author']['signature']; ?>
            </div>
            </div><?php
		} ?>
        </div>
        <?php
	}
}