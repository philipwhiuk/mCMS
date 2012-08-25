	<?php

class Template_Theme_Flix_HTML_Main extends Template {
	
	public $head = array();
	
	public function display(){
		header('Content-type: text/html; charset=utf-8')
?><!DOCTYPE html>
<html>
	<head>
	    <base href="<?php echo $this->url; ?>">
		<title>Flix: Loughborough Student's Union Cinema</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<link rel="SHORTCUT ICON" href="<?php echo $this->theme->url('images/favicon.ico'); ?>"/>
		<link rel="stylesheet" href="<?php echo $this->theme->url('css/00.css'); ?>" type="text/css">
<?php 
	foreach($this->head as $data){
		echo $data;
	}
?>
	</head>
	<body>
	<div id="header"> 
		<div id="header_main"> 
			<div id='header_left'> 
				<a href='<?php echo $this->url; ?>'><img id='flix_logo' src='theme/flix/images/flix_logo.png' alt='Flix' /></a> 
				<p id='intro'>The Award winning society of <br/>Loughborough Student's Union</p> 
			</div> 



			<div id='header_right'> 
				<img class='award' src='theme/flix/images/awards/society0809.png' alt='Society of the Year 08-09' />
				<img class='award' src='theme/flix/images/awards/society0910.png' alt='Society of the Year 09-10' />
				<img class='award' src='theme/flix/images/awards/website0910.png' alt='Website of the Year 08-09' />
				<img class='award' src='theme/flix/images/awards/nus0910.jpg' alt='NUS 2009-2010 Society of the Year Finalist' />
				<a href='http://www.lufbra.net'><img id='lsu_logo' src='theme/flix/images/lsu_logo.png' alt="Loughborough Student's Union" /></a>

			</div> 
			<div id="header_right_links">
				<a href="/user/login/"><img src='theme/flix/images/login.png' alt="LOGIN" ></a>
				<a href='http://www.facebook.com/pages/Loughborough-United-Kingdom/FLIX-Loughborough-Student-Cinema/131116950233118'><img src='theme/flix/images/facebook.png' alt="Loughborough Student's Union" ></a>
			</div>
			<div style='clear: both'> 
			</div> 
		</div> 
	</div> 
<?php 
	$this->main->display();
?>
	</body>
</html>
<?php	
	}	
}