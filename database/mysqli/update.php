<?php

class Database_MySQLi_Update_Query extends Database_MySQLi_Query implements IDatabase_Update_Query {
	
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
		
		$sql = "UPDATE `{$this->table}`";
		
		$sql .= $this->generate_set();
		
		if($this->where){
			$sql .= ' ' . $this->generate_where();
		}
		
		if(isset($this->limit)){
			$sql .= ' LIMIT %u';
			$this->args[] = $this->limit;
		}
		
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
			throw new Database_MySQLi_Select_Query_Exception($e);
		}
	}
	
	public function set($data){
		$this->set = $data;
		return $this;
	}
	
	public function where($operator, $operand){
		$this->where = true;
		return parent::where($operator, $operand);
	}
	
	
	public function limit($number){
		$this->limit = $number;
		return $this;
	}
	
}