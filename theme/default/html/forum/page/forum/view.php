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
				<a href="<?php echo $parent['url']; ?>"><?php echo $parent['title']; ?></a>
				 < 
			<?php }?>
			<a href="<?php echo $this->url; ?>"><?php echo $this->title; ?></a>
		</div>
        <h1><?php echo $this->title; ?></h1>
        <?php if(count($this->sub_forums) != 0) { ?>
            <table class="sub_forums">
			<thead>
            <tr><th>Forum</th><th>Topics</th><th>Posts</th><th>Last Post</th></tr>
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
			</tbody>
        </table>        
		<?php } ?>
        <?php if(!count($this->topics) == 0) { ?>
        <table class="topics">
		<thead>
        <tr><th>Active Topics</th><th>Posts</th><th>Views</th><th>Last Post</th></tr>
		</thead>
		<tfoot><tr><td colspan="4">&nbsp;</td></tr></tfoot>
		<tbody>
			<?php foreach($this->topics as $topic) {
				?><tr>
                	<td><a href="<?php echo $topic['topicurl']; ?>"><?php echo $topic['title']; ?></a>,
                    	<a href="<?php echo $topic['firstposterurl']; ?>"><?php echo $topic['firstposter']; ?></a> ,<?php echo $topic['firstpostdate']; ?></td>
                	<td><?php echo $topic['posts']; ?></td>
                    <td><?php echo $topic['views']; ?></td>
                    <td><?php echo $topic['lastposter']; ?></td>
                </tr><?php
			} ?>
		</tbody>
        </table>
        <?php }?>
	</div>
	<?php
	}
}