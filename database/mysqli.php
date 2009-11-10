<?php

System::Get_Instance()->files('database/mysqli/exception','database/mysqli/query','database/mysqli/select','database/mysqli/update', 'database/mysqli/insert');

class Database_MySQLi extends MySQLi implements IDatabase {
	
	public function __construct($config){
		parent::__construct($config['host'], $config['username'], $config['password'], $config['database'], $config['port'], $config['socket']);
		
		// PHP 5.2.9 and PHP 5.3.0 support means procedural style! :-(
		
		if(mysqli_connect_error()){
			throw new Database_MySQLi_Connect_Exception(mysqli_connect_error());
		}
	}
	
	// IDatabase
	
	public function query($sql /*, $arg1, $arg2 ... */){
		$args = func_get_args();
		array_shift($args);
		return $this->query_array($sql, $args);
	}
	
	public function escape($val){
		if(is_numeric($val)){
			return $val;
		}
		return $this->escape_string($val);
	}
	
	public function query_array($sql, $args){
	
		$args = (array) $args;
		
		$args = array_map(array($this, 'escape'), $args);
		$query = vsprintf($sql, $args);	
		
		$result = parent::query($query);
		
		if(!$result){
			throw new Database_MySQLi_Query_Exception($this->error, $query);
		}
		
		return $result;
	}
	
	public function insert(){
		return new Database_MySQLi_Insert_Query();
	}
	
	public function Select(){
		return new Database_MySQLi_Select_Query();
	}
	
	public function Update(){
		return new Database_MySQLi_Update_Query();
	}
	
}
