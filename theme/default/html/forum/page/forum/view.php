<?php

class Template_Theme_Default_HTML_Forum_Page_Forum_View extends Template {
	public $topics = array();
	public $sub_forums = array();
	public $parents = array();
	public function display() {
	?>
	<div class="page-view forum-view page-forum-view">
		<div class="forum_structure">
			<?php foreach($this->parents as $parent) { ?>
				<a href="<?php echo $parent['url']; ?>"><?php echo $parent['title']; ?></a> <span class="forum_structure_divider"><</span> 
			<?php }?>
			<a href="<?php echo $this->url; ?>"><?php echo $this->title; ?></a>
		</div>
        <h1><?php echo $this->title; ?></h1>
        <?php if(count($this->sub_forums) != 0) { ?>
            <table class="sub_forums">
			<thead>
            <tr><th class="forum">Forum</th><th class="topics">Topics</th><th class="posts">Posts</th><th class="lastpost">Last Post</th></tr>
			</thead>
			<tfoot><tr><td colspan="4">&nbsp;</td></tr></tfoot>
			<tbody>
            <?php
                foreach($this->sub_forums as $sub_forum) { ?>
                    <tr>
                        <td>
                            <div class='sf_title'><a href='<?php echo $sub_forum['url']; ?>'><?php echo $sub_forum['title']; ?></a></div>
                            <div class='sf_desc'><?php echo $sub_forum['description']; ?></div>
                        </td>
                        <td class="topics"><?php echo $sub_forum['topics']; ?></td>
                        <td class="posts"><?php echo $sub_forum['posts']; ?></td>
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
			</tbody>
        </table>        
		<?php } ?>
        
        <table class="topics">
		<thead>
        <tr><th class="atopic">Active Topics</th><th class="posts">Posts</th><th class="views">Views</th><th class="lastpost">Last Post</th></tr>
		</thead>
		<tfoot><tr><td colspan="4">&nbsp;</td></tr></tfoot>
		
		<tbody>
		<?php if(!count($this->topics) == 0) { 
			foreach($this->topics as $topic) {
				?><tr>
                	<td class="atopic"><div class="topic"><a href="<?php echo $topic['topicurl']; ?>"><?php echo $topic['title']; ?></a></div>
                    	<div class="topicinfo">by <a href="<?php echo $topic['firstposterurl']; ?>"><?php echo $topic['firstposter']; ?></a> > <?php echo $topic['firstpostdate']; ?></div></td>
                	<td class="posts"><?php echo $topic['posts']; ?></td>
                    <td class="views"><?php echo $topic['views']; ?></td>
                    <td class="lastposter"><?php echo $topic['lastposter']; ?></td>
                </tr><?php
			}
		}
		else {
			?><tr><td colspan="4" class="no_topics">No Topics Found</td></tr><?php
		}?>
		</tbody>
       
        </table>
	</div>
	<?php
	}
}