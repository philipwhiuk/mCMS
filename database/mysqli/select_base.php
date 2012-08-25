<?php

abstract class Database_MySQLi_Select_Base_Query extends Database_MySQLi_Query {
	
	public $where = false;
	
	public function where($operator, $operand){
		$this->where = true;
		return parent::where($operator, $operand);
	}
	
}