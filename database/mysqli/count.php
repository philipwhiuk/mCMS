<?php

class Database_MySQLi_Count_Query extends Database_MySQLi_Select_Base_Query implements IDatabase_Count_Query {

	private $limit;
	private $offset;
	private $order = array();

	protected function generate_sql(){
		if(!isset($this->table)){
			throw new Database_MySQLi_Count_Invalid_Query_Exception('table');
		}

		$sql = "SELECT COUNT(*) as count FROM `{$this->table}`";

		if($this->where){
			$sql .= ' ' . $this->generate_where();
		}

		return $sql;
	}

	public function execute(){
		try {
			$result = parent::execute();
		} catch(Exception $e){
			throw new Database_MySQLi_Select_Query_Exception($e);
		}
		$row = $result->fetch_assoc();
		if(!$row || !isset($row['count'])){
			throw new Database_MySQLi_Count_Query_Exception($e);
		}   
		return $row['count'];
	}

}
