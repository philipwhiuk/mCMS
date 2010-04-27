<?php

class Template_Theme_Default_HTML_Main extends Template {
	
	public $head = array();
	
	public function display(){
		header('Content-type: text/html; charset=utf-8')
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
		<title></title>
	</head>
	<body>
<?php 
	$this->main->display();
?>
	</body>
</html>
<?php	
	}	
}
