<?php

interface IDatabase {
	
	public function query($sql /*, $arg1, $arg2 ... */);
	
	public function query_array($sql, $args);
	
}

interface IDatabase_Query {
	
	public function table($table);
	
}

interface IDatabase_Select_Query extends IDatabase_Query {
	
	public function where($opertator, $operands);
	public function limit($number);
	public function offset($number);
	
	
}