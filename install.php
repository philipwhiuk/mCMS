<?php
class Install {
	public static function Load() {
		$exceptions = array();
		return new Install_Start();
	}
}
class Install_Start {
	public function __construct(){
	}
	
	public function display(){
		$this->title = "Start";
		$this->body = "";
		$this->modes = "";
	}
	public function render() {
		header('Content-type: text/html');
?><html>
<head><title>Install :: Start</title>
</head>
<body>
<h1>Install :: Start</h1>
<body>
<div Welcome to the installer for ModularCMS</body>
</html>
<?php
	}
}