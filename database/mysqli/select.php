<?php

class Database_MySQLi_Select_Query extends Database_MySQLi_Query implements IDatabase_Select_Query {
	
	private $limit;
	private $offset;
	private $order = array();
	private $where = false;
	
	protected function generate_sql(){
		if(!isset($this->table)){
			throw new Database_MySQLi_Select_Invalid_Query_Exception('table');
		}
		
		$sql = "SELECT * FROM `{$this->table}`";
		
		if($this->where){
			$sql .= ' ' . $this->generate_where();
		}
		
		if(count($this->order) > 0){
			$sql .= ' ORDER BY ';
			$sqls = array();
			foreach($this->order as $col => $sort){
				if($sort){
					$sqls[] = '`%s` ASC';
				} else {
					$sqls[] = '`%s` DESC';
				}
				$this->args[] = $col;
			}
			$sql .= join(',', $sqls);
		}
		
		if(isset($this->limit)){
			if(isset($this->offset)){
				$sql .= ' LIMIT %u, %u';
				$this->args[] = $this->offset;
				$this->args[] = $this->limit;
			} else {
				$sql .= ' LIMIT %u';
				$this->args[] = $this->limit;
			}
		}
		
		return $sql;
	}
	
	public function execute(){
		try {
			return parent::execute();
		} catch(Exception $e){
			throw new Database_MySQLi_Select_Query_Exception($e);
		}
	}
	
	public function order($cols){
		$this->order = $cols;
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
	public function offset($number){
		$this->offset = $number;
		return $this;
	}
	
}