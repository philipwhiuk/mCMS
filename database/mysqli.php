<?php

System::Get_Instance()->file('database/mysqli/exception');

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
	
	public function Select(){
		return new Database_MySQLi_Select_Query();
	}
	
}

abstract class Database_MySQLi_Query implements IDatabase_Query {
	
	protected $table;
	protected $where_tor;
	protected $where_and;
	protected $args = array();
	
	public function table($table){
		$this->table = $table;
		return $this;
	}
	
	public function execute(){
		$this->args = array();
		$sql = $this->generate_sql();
		$result = System::Get_Instance()->database()->query_array($sql, $this->args);
		return $result;
	}
	
	abstract protected function generate_sql();
	
	protected function where($operator, $operand){
		$this->where_tor = $operator;
		$this->where_and = $operand;
		return $this;
	}
	
	private function generate_where_param_clause($operator, $operand){
		switch(strtolower($operator)){
			case "col":
				$clause = "`%s`";
				$this->args[] = $operand;
				break;
			case "bool":
				$clause = ($operand) ? 1 : 0;
				break;
			case "s":
				$clause = "'%s'";
				$this->args[] = $operand;
				break;
			default:
				$clause = "%{$operator}";
				$this->args[] = $operand;
				break;
		}
		return $clause;
	}
	
	private function generate_where_clause($operator, $operand){
		$clause = '';
		switch(strtolower($operator)){
			case "or":
				$sqls = array();
				foreach($operand as $op){
					$sqls[] = $this->generate_where_clause($op[0], $op[1]);
				}
				$clause = join(' OR ', $sqls);
				break;
			case "and":
				$sqls = array();
				foreach($operand as $op){
					$sqls[] = $this->generate_where_clause($op[0], $op[1]);
				}
				$clause = join(' AND ', $sqls);
				break;
			case "=":
				if(count($operand) != 2){
					throw new Database_MySQLi_Query_Where_Invalid_Exception($operator, $operand);
				}
				$clause = $this->generate_where_param_clause($operand[0][0], $operand[0][1]);
				$clause .= '=';
				$clause .= $this->generate_where_param_clause($operand[1][0], $operand[1][1]);
				break;
			default:
				throw new Database_MySQLi_Query_Where_Invalid_Exception($operator, $operand);			
		}
		return "({$clause})";
	}
	
	protected function generate_where(){
		$where = "WHERE ";
		$where .= $this->generate_where_clause($this->where_tor, $this->where_and);
		return $where;
	}
	
}

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