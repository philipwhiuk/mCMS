<?php
class Template_Theme_Graphene_HTML_Main extends Template {
	
	public $head = array();
	
	
	public function display(){
	header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo $this->url; ?>">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" href="<?php echo $this->theme->url('css/main.css'); ?>" type="text/css">
<?php 
	foreach($this->head as $data){
?>
<?php echo $data; ?> 
<?php	
	}
?>
		<title><?php echo $this->siteName; ?> :: <?php echo $this->main->title(); ?></title>
	</head>
<body>

<div class="bg-gradient js">
	<div id="container" class="container_16">
		<div id="top-bar">
			<div id="profiles" class="clearfix gutter-left">
				<a href="http://philip.whiuk.com/?feed=rss2" title="Subscribe to Philip Whitehouse&#039;s Blog&#039;s RSS feed" id="social-id-1" class="mysocial social-rss">
					<img src="http://philip.whiuk.com/wp-content/themes/graphene/images/social/rss.png" alt="RSS" title="Subscribe to Philip Whitehouse&#039;s Blog&#039;s RSS feed" />
				</a>
			</div>
			<div id="top_search" class="grid_4">
				<form id="searchform" class="searchform" method="get" action="http://philip.whiuk.com">
					<p class="clearfix default_searchform">
					<input type="text" name="s" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" value="Search" />
					<button type="submit"><span>Search</span></button>
					</p>
				</form>
			</div>
		</div>
		<div id="header">
			<img src="http://philip.whiuk.com/wp-content/themes/graphene/images/headers/flow.jpg" alt="" class="header-img" />        	       
			<h2 class="header_title push_1 grid_15">
				<a href="<?php echo $this->url; ?>" title="Go back to the front page">Philip Whitehouse&#039;s Blog</a>
			</h2>			
			<h3 class="header_desc push_1 grid_15">Computer Science, Game Development, MMOs</h3>                
		</div>
		<?php $this->main->display(); ?>
	</div>
</div>
</body>
</html>
<?php	
	}	
}
