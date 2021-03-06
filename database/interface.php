<?php

interface IDatabase {
	
	public function query($sql /*, $arg1, $arg2 ... */);
	
	public function query_array($sql, $args);
	
	public function select();
	public function update();
	public function insert();
	
}

interface IDatabase_Query {
	
	public function From($table);
	
}

interface IDatabase_Insert_Query extends IDatabase_Query {
	
	public function set($data);
	
}

interface IDatabase_Update_Query extends IDatabase_Query {
	
	public function where($operator, $operands);
	public function limit($number);
	public function set($data);
	
	
}

interface IDatabase_Count_Query extends IDatabase_Query {
	public function where($operator, $operands);
}

interface IDatabase_Select_Query extends IDatabase_Query {
	
	public function where($operator, $operands);
	public function limit($number);
	public function offset($number);
	public function order($cols);
	
	
}
