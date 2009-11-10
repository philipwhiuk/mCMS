<?php

class Database_MySQLi_Insert_Query extends Database_MySQLi_Query implements IDatabase_Insert_Query {
	
	private $limit;
	private $offset;
	private $where = false;
	private $set = array();
	
	protected function generate_sql(){
		if(!isset($this->table)){
			throw new Database_MySQLi_Update_Invalid_Query_Exception($this, 'table');
		}
		
		if(count($this->set) < 1){
			throw new Database_MySQLi_Update_Invalid_Query_Exception($this, 'set');
		}
		
		$sql = "INSERT INTO `{$this->table}`";
		
		$sql .= $this->generate_set();
		
		return $sql;
	}
	
	protected function generate_set(){
		$set = "SET ";
		$clauses = array();
		foreach($this->set as $field => $value){
			$clause = "`%s` = ";
			$this->args[] = $field;
			$clause .= $this->generate_param_clause($value[0], $value[1]);
			$clauses[] = $clause;
		}
		$set .= join(',', $clauses);
		return $set;
	}
	
	public function execute(){
		try {
			return parent::execute();
		} catch(Exception $e){
			throw new Database_MySQLi_Insert_Query_Exception($e);
		}
	}
	
	public function set($data){
		$this->set = $data;
		return $this;
	}
	
}