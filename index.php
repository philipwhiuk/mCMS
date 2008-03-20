<?php
/**
 * Fusion - Index
 *
 * This is the entry point for the Fusion Web Framework
**/


require_once('Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));

class Site extends Model {
	
}

class Fusion {
	
	 public static function Load(){
	 	$return = new Fusion;
	 	$return->Configure();
	 	Doctrine_Manager::connection($return->config['storage'], 'sandbox'); 
	 	$return->Site();
	 	$return->API();
	 }
	 
	 private function Site(){
	 	global $storage;
	 	
	 }
	 
	 private function Configure(){
		$config = array();
		$uri = explode('/', $_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : $_SERVER['SCRIPT_FILENAME']);
		$server = explode('.', implode('.', array_reverse(explode(':', rtrim($_SERVER['HTTP_HOST'], '.')))));
		for ($i = count($uri) - 1; $i > 0; $i--) {
			for ($j = count($server); $j > 0; $j--) {
				$dir = implode('.', array_slice($server, -$j)) . implode('.', array_slice($uri, 0, $i));
				if(file_exists("{$confdir}/{$dir}.php")) {
					require_once("{$confdir}/{$dir}.php");
					$this->config = $config;
				}
			}
		}
		if(file_exists("{$confdir}/default.php")) {
			require_once("{$confdir}/default.php");
			$this->config = $config;
		} else {
			Fusion::Install();
		}
	 }
	
}

// Setup Site Table




// Start Fusion

global $fusion;

$fusion = Fusion::Load();
if($fusion->run())
	$fusion->output();
	
$fusion = NULL