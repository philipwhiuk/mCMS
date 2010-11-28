<?php
global $config;

$config = array(
	'path' => '/~rjw201/raven',
	'host' => 'www.srcf.ucam.org',
	'keys' => '/home/rjw201/raven/',
	'sessions' => '/home/rjw201/raven/sessions'
);

$users = array('rjw201');

// DO NOT CHANGE BELOW THIS LINE //

$user = raven();

if(!in_array($user, $users)){
	header('HTTP/1.0 403 Forbidden');
}

$file = trim(basename($_GET['file']));

$dir = dirname(__FILE__) . '/';
if(file_exists($dir . $file) AND is_file($dir . $file)){

header('Content-type: ' . mime_content_type($dir . $file));
echo file_get_contents(basename($_GET['file']));

} elseif($file == ''){
?>
<html>
	<head>
	<title>Files available:</title>
	</head>
	<body>
		<ul>
		<?php foreach(scandir(dirname(__FILE__)) as $file){ if(substr($file,0,1) != '.' && substr($file,-3,3) != 'php'){ ?>
			<li><a href="<?php echo $config['path']; ?>/<?php echo $file; ?>"><?echo $file; ?></a></li>
		<?php } } ?>
		</ul>
	</body>
</html>
<?php
} else {
	header("HTTP/1.0 404 Not Found");
?>
<html>
	<head>
	<title>File Not Found</title>
	</head>
	<body>
		File requested was not found.
	</body>
</html>
<?php
}

function raven(){
global $config;
ini_set('session.cookie_path','/cucats/');
ini_set('session.save_path',$config['sessions']);
session_start();

if(isset($_SESSION['raven'])){
	unset($_SESSION['raven']);
	return $_SESSION['raven'];
}

require_once('ucam_webauth.php');

$webauth = new Ucam_Webauth(array(
        'hostname' => $config['host'],
        'key_dir' => $config['keys'],
	'do_session' => FALSE,
	'protocol_version' => '2'
));

if(!$webauth->validate_response()){
	$webauth->invoke_wls();
	exit;
}

if(!$webauth->success()){
	return false;
}

$_SESSION['raven'] = $webauth->principal();

session_write_close();

header('Location: ' . $config['path'] . '/' . $_GET['file']);

exit;

var_dump($_GET);

echo $webauth->principal();

exit;

}

