<?php

class Template_Theme_Default_HTML_Forum_Page_Forum_View extends Template {
	public $topics = array();
	public $sub_forums = array();
	public function display() {
		?>
        <div class="page-view forum-view page-forum-view">
        <h1><?php echo $this->title; ?></h1>
        <?php if(count($this->sub_forums) != 0) { ?>
        <h2>Sub-Forums</h2>
            <table class="sub_forums">
            <tr><th>Forum</th><th>Topics</th><th>Posts</th><th>Last Post</th></tr>
            <?php
                foreach($this->sub_forums as $sub_forum) { ?>
                    <tr>
                        <td>
                            <div class='sf_title'><a href='<?php echo $sub_forum['url']; ?>'><?php echo $sub_forum['title']; ?></a></div>
                            <div class='sf_desc'><?php echo $sub_forum['description']; ?></div>
                        </td>
                        <td><?php echo $sub_forum['topics']; ?></td>
                        <td><?php echo $sub_forum['posts']; ?></td>
                        <td>
                            <?php if($sub_forum['lastpost']) { ?>
                                <a href='<?php echo $sub_forum['lastposterurl']; ?>'><?php echo $sub_forum['lastposter']; ?></a>
                                <a href='<?php echo $sub_forum['lastposturl']; ?>'>View Post</a>
                                <?php echo date('jS F Y',$sub_forum['lastpostdate']); ?>
                            <?php } else {
                                ?>No Posts<?php
                            }?>
                            </td>
                    </tr>
                <?php } 
			?>
        </table>        
		<?php } ?>
        <h2>Topics</h2>
        <table class="topics">
        <tr><th>Active Topics</th><th>Posts</th><th>Views</th><th>Last Post</th></tr>
        <?php if(count($this->topics) == 0) {
			?><tr><td colspan="4" class="no_topics">No Topics</td></tr><?php 
		}
		else {
			foreach($this->topics as $topic) {
			} 
		}?>
        </table>
        </div>
        <?php
	}
}