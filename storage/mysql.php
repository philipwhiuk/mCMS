<?php	

/**
 * MySQL Storage File
 *
 * Subversion ID: $Id$
**/

if(class_exists('mysqli')){

	class mysql extends mysqli {

		function __construct($config){
			global $start;
			return parent::__construct($config['host'], $config['user'], $config['password'], $config['database'], $config['port'], $config['socket']);
		}
		
		function escape($arg){
			if(is_numeric($arg)){
				return $arg;
			} else {
				return '"' . $this->escape_string($arg) . '"';
			}
		
		}
		
		function query($query){
			$args = func_get_args();
			array_shift($args);
			if(count($args) == 1 && is_array($args[0])){
				$args = $args[0];
			}
			foreach($args as $a => $arg){
				$args[$a] = $this->escape($arg);
			}
			$queryb = vsprintf($query, $args);
			$t = microtime(true);
			if($result = parent::query($queryb)){
				$this->querys[$queryb] = (microtime(true) - $t);
				return $result;
			} else {
				@header('Content-type: text/plain');
				die("SQL: {$query} \r\n\r\nError: {$this->error}");
			}
		}

	}

} else {

	class mysql {



	}

}

