<?php

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
	
	protected function generate_param_clause($operator, $operand){
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
	
	protected function generate_clause($operator, $operand){
		$clause = '';
		switch(strtolower($operator)){
			case "or":
				$sqls = array();
				foreach($operand as $op){
					$sqls[] = $this->generate_clause($op[0], $op[1]);
				}
				$clause = join(' OR ', $sqls);
				break;
			case "and":
				$sqls = array();
				foreach($operand as $op){
					$sqls[] = $this->generate_clause($op[0], $op[1]);
				}
				$clause = join(' AND ', $sqls);
				break;
			case ",":
				$sqls = array();
				foreach($operand as $op){
					$sqls[] = $this->generate_clause($op[0], $op[1]);
				}
				$clause = join(',', $sqls);
				break;
			case ">":
			case "<":
			case "=":
				if(count($operand) != 2){
					throw new Database_MySQLi_Query_Clause_Invalid_Exception($operator, $operand);
				}
				$clause = $this->generate_param_clause($operand[0][0], $operand[0][1]);
				$clause .= $operator;
				$clause .= $this->generate_param_clause($operand[1][0], $operand[1][1]);
				break;
			default:
				throw new Database_MySQLi_Query_Clause_Invalid_Exception($operator, $operand);			
		}
		return "({$clause})";
	}
	
	protected function generate_where(){
		$where = "WHERE ";
		$where .= $this->generate_clause($this->where_tor, $this->where_and);
		return $where;
	}
	
}
