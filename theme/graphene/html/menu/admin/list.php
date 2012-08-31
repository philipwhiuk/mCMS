<?php

class Template_Theme_Graphene_HTML_Menu_Admin_List extends Template {
	public $grouping_types = array();
	public $current_type = array();
	public $search;
	public $addurl;
	public function display(){
?>		
<div class="admin-list content-admin-list">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
	<h2><?php echo $this->title; ?> <a href="<?php echo $this->addurl;?>" class="add-new-h2">Add New</a> </h2>
	<ul class="subsubsub">
		<?php 
		$first = true;
		foreach($this->grouping_types as $type) { ?>
			<li class="<?php echo $type['id']; ?>"><?php if(!$first) { ?>| <?php } ?><a href="<?php echo $type['url']; ?>" <?php if($type['id'] == $this->current_type['id']) {?> class="current" <?php } ?>><?php echo $type['title']; ?> <span class="count">(<?php echo $type['count']; ?>)</span></a> </li>
			<?php $first = false;
		}
		?>
	</ul>
	<form id="posts-filter" action="" method="get">
		<p class="search-box">
				<label class="screen-reader-text" for="content-search-input"><?php echo $this->search; ?>:</label>
				<input type="search" id="content-search-input" name="s" value="">
				<input type="submit" name="" id="search-submit" class="button" value="<?php echo $this->search ; ?>">
		</p>
		<input type="hidden" name="content_status" class="content_status_page" value="<?php echo $this->current_type['id']; ?>">
		<input type="hidden" name="content_type" class="content_type_content" value="content">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="">
		<input type="hidden" name="_wp_http_referer" value="<?php echo $this->url; ?>">
		<div class="tablenav top">
			<div class="alignleft actions">
				<select name="action">
					<option value="-1" selected="selected">Bulk Actions</option>
					<option value="edit" class="hide-if-no-js">Edit</option>
					<option value="trash">Move to Trash</option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply">
			</div>
			<div class="alignleft actions">
				<select name="m">
					<option selected="selected" value="0">Show all dates</option>
					<option value="201208">August 2012</option>
					<option value="201204">April 2012</option>
					<option value="201111">November 2011</option>
					<option value="201110">October 2011</option>
					<option value="200907">July 2009</option>
				</select>
				<input type="submit" name="" id="post-query-submit" class="button-secondary" value="Filter">		
			</div>
			<div class="tablenav-pages one-page">
				<span class="displaying-num">10 items</span>
				<span class="pagination-links">
					<a class="first-page disabled" title="Go to the first page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page">«</a>
					<a class="prev-page disabled" title="Go to the previous page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">‹</a>
					<span class="paging-input">
						<input class="current-page" title="Current page" type="text" name="paged" value="1" size="1"> of <span class="total-pages">1</span>
					</span>
					<a class="next-page disabled" title="Go to the next page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">›</a>
					<a class="last-page disabled" title="Go to the last page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">»</a>
				</span>
			</div>
			<br class="clear">
		</div>
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
					<th scope="col" id="title" class="manage-column column-title sortable desc" style="">
						<a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=title&amp;order=asc">
							<span>Name</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th scope="col" id="author" class="manage-column column-author sortable desc" style="">
						<a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=author&amp;order=asc">
							<span>Author</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th scope="col" id="date" class="manage-column column-date sortable asc" style="">
						<a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=date&amp;order=desc">
							<span>Date</span><span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
					<th scope="col" class="manage-column column-title sortable desc" style="">
						<a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=title&amp;order=asc"><span>Name</span><span class="sorting-indicator"></span></a></th>
					<th scope="col" class="manage-column column-author sortable desc" style="">
						<a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=author&amp;order=asc"><span>Author</span><span class="sorting-indicator"></span></a>
					</th>
					<th scope="col" class="manage-column column-date sortable asc" style=""><a href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>	
				</tr>
			</tfoot>	
			<tbody class="content-list-table">
				<?php foreach($this->menus as $menu){ ?>
				<tr id="post-161" class="post-161 page type-page status-publish hentry alternate iedit author-self nodate" valign="top">
					<th scope="row" class="check-column"><input type="checkbox" name="post[]" value="161"></th>
					<td class="post-title page-title column-title">
						<strong><a class="row-title" href="<?php echo $menu['edit']; ?>" title="Edit “<?php echo $menu['name']; ?> ”"><?php echo $menu['name']; ?> </a></strong>
						<div class="row-actions"><span class="edit"><a href="<?php echo $menu['name']; ?>" title="Edit this item">Edit</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline" title="Edit this item inline">Quick&nbsp;Edit</a> | </span><span class="trash"><a class="submitdelete" title="Move this item to the Trash" href="http://philip.whiuk.com/wp-admin/post.php?post=161&amp;action=trash&amp;_wpnonce=f41f60f1c5">Trash</a> | </span><span class="view"><a href="http://philip.whiuk.com/?page_id=161" title="View “About Me”" rel="permalink">View</a></span></div>
						<div class="hidden" id="inline_161">
							<div class="post_title">About Me</div>
							<div class="post_name">about</div>
							<div class="post_author">1</div>
							<div class="comment_status">closed</div>
							<div class="ping_status">closed</div>
							<div class="_status">publish</div>
							<div class="jj">08</div>
							<div class="mm">07</div>
							<div class="aa">2009</div>
							<div class="hh">09</div>
							<div class="mn">35</div>
							<div class="ss">11</div>
							<div class="post_password"></div>
							<div class="post_parent">0</div>
							<div class="page_template">default</div>
							<div class="menu_order">0</div>
						</div>
					</td>
					<td class="author column-author"><a href="edit.php?post_type=page&amp;author=1">Philip</a></td>
					<td class="date column-date"><abbr title="2009/07/08 9:35:11 AM">2009/07/08</abbr><br>Published</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="tablenav bottom">
			<div class="alignleft actions">
				<select name="action2">
					<option value="-1" selected="selected">Bulk Actions</option>
					<option value="edit" class="hide-if-no-js">Edit</option>
					<option value="trash">Move to Trash</option>
				</select>
				<input type="submit" name="" id="doaction2" class="button-secondary action" value="Apply">
			</div>
			<div class="alignleft actions">
			</div>
			<div class="tablenav-pages one-page"><span class="displaying-num">10 items</span>
				<span class="pagination-links">
					<a class="first-page disabled" title="Go to the first page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page">«</a>
					<a class="prev-page disabled" title="Go to the previous page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">‹</a>
					<span class="paging-input">1 of <span class="total-pages">1</span></span>
					<a class="next-page disabled" title="Go to the next page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">›</a>
					<a class="last-page disabled" title="Go to the last page" href="http://philip.whiuk.com/wp-admin/edit.php?post_type=page&amp;paged=1">»</a>
				</span>
			</div>
			<br class="clear">
		</div>
	</form>
	<br class="clear">
</div>
<?php	
	}	
}
