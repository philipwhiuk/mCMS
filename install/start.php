<?php
class Install_Start {
	public function __construct(){
	}
	
	public function display(){
		$this->title = "Install :: Start";
		$this->body = "Welcome to the installer for ModularCMS.";
		$this->modes = "";
		$this->storageOptions = array('database' => 'Database');
		$this->submit = "Submit";
	}
	public function render() {
		header('Content-type: text/html');
?>
<html>
<head>
<link href="theme/default/css/main.css" rel="stylesheet" />
<title>Install :: Start</title>
</head>
<body>
<div class="install">
<h1><?php echo $this->title; ?></h1>
<p><?php echo $this->body; ?></p>
<form action="post">
<div class="install-module install-module-storage">
<h2>Storage Type</h2>
<div class="form-label">Module:</div> 
<div class="form-field"><select name="storage-module">
	<?php foreach($this->storageOptions as $module=>$title) { ?>
		<option value="<?php echo $module; ?>"><?php echo $title; ?></option>
	<?php } ?>
</select></div>
</div>
<div class="install-module install-module-database">
	<h2>Database Options</h2>
	<div class="form-label">Driver:</div> 
	<div class="form-field">
		<select name="database-driver">
			<?php foreach($this->databaseDriverOptions as $driver=>$title) { ?>
				<option value="<?php echo $module; ?>"><?php echo $title; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-label">Host:</div> <div class="form-label"><input name="database-host" /></div>
	<div class="form-label">Username:</div> <div class="form-label"><input name="database-username" /></div>
	<div class="form-label">Password:</div> <div class="form-label"><input name="database-password" /></div>
	<div class="form-label">Database:</div> <div class="form-label"><input name="database-db" /></div>
	<div class="form-label">Socket:</div> <div class="form-label"><input name="database-socket" /></div>
	<div class="form-label">Port:</div> <div class="form-label"><input name="database-port" /></div>
</div>
<input type="submit" value="<?php echo $this->submit; ?>" />
</form>
</div>
<body>
<div>
</div>
</body>
</html>
<?php
	}
}