<?php
MCMS::Get_Instance()->files('database/mysqli/exception','database/mysqli/query','database/mysqli/select_base','database/mysqli/select','database/mysqli/count', 'database/mysqli/update', 'database/mysqli/insert');
class Database_MySQLi extends MySQLi implements Database_Provider {
	public function __construct($config) {
		@parent::__construct(
			(isset($config['host']) ? $config['host'] : ''), 
			isset($config['username']) ? $config['username'] : '', 
			isset($config['password']) ? $config['password'] : '', 
			isset($config['database']) ? $config['database'] : '',
			isset($config['port']) ? $config['port'] : 3306,
			isset($config['socket']) ? $config['socket'] : '');
		if ($this->connect_error) {
			throw new Database_MySQLi_Connect_Exception($this->connect_error);
		}
	}
	public function query($sql /*, $arg1, $arg2 ... */){
		$args = func_get_args();
		array_shift($args);
		return $this->query_array($sql, $args);
	}

	public function insert_id(){ return $this->insert_id; }
	
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
	
	public function add(){
		return new Database_MySQLi_Insert_Query();
	}	
	public function get(){
		return new Database_MySQLi_SelectQuery();
	}
	public function count(){
		return new Database_MySQLi_Count_Query();
	}
	public function update(){
		return new Database_MySQLi_Update_Query();
	}
}