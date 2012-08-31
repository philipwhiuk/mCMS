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
		<a href="<?php echo $this->forum['url']; ?>"><?php if($this->forum['parentID'] != 0) { echo $this->forum['title']; } else { echo 'Board Index'; } ?></a>
        </div>
        <h1><a href="<?php echo $this->topicurl; ?>"><?php echo $this->title; ?></a></h1>
        <?php echo $this->description; ?>
        <?php foreach($this->posts as $post) {
			?><div class="post">
			<div class="user">
				<div class="user-avatar"><img src="<?php echo $post['author']['avatarurl']; ?>" /></div>
				<div class="user-displayname"><a href="<?php echo $post['author']['url']; ?>"><?php echo $post['author']['displayname']; ?></a></div>
				<div class="user-title"><?php echo $post['author']['title']; ?></div>
				<div class="user-posts"><span class="title">Posts:</span> <?php echo $post['author']['posts']; ?></div>
				<div class="user-joined"><span class="title">Joined:</span> <?php echo $post['author']['joined']; ?></div>
				<div class="user-location"><span class="title">Location:</span> <?php echo $post['author']['location']; ?></div>
				<div class="user-name"><span class="title">Name:</span> <?php echo $post['author']['name']; ?></div>
			</div>
            <h2><a href="<?php echo $post['url']; ?>"><?php echo $post['title']; ?></a></h2>
            <div class="post_info">
            	<a href="<?php echo $post['url']; ?>">View Post</a>
                <a href="<?php echo $post['author']['url']; ?>"><?php echo $post['author']['name']; ?></a>
                 >> <?php echo $post['date']; ?></div>
			
			<div class="post_body"><?php echo $post['body']; ?></div>
            <?php if($post['edit']) { ?>
	            <div class="edit_info">Last edited by <?php echo $post['editauthor']; ?> on <?php echo $post['editdate']; ?>, edited <?php echo $post['editcount']; ?> times in total.</div>
			<?php } ?>
            <div class="signature">
			<hr />
            <?php echo $post['author']['signature']; ?>
            </div>
            </div><?php
		} ?>
        </div>
        <?php
	}
}