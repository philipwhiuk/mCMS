<?php

class Resource {
	
	private $id;
	private $path;
	private $module;
	private $base;
	private $additional;
	private $pointer = 0;
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_module(){
		return $this->module;
	}
	
	public function consume_argument(){
		$this->pointer ++;
	}
	
	public function get_argument(){
		$arguments = $this->get_arguments();
		if(isset($arguments[$this->pointer])){
			return $arguments[$this->pointer];
		}
		return null;
	}
	
	public function get_arguments(){
		return array_merge($this->base, $this->additional);
	}
	
	public function set_additional($argument){
		$this->additional = ($argument == "") ? $this->additional : explode('/', trim((string) $argument,'/'));
	}
	
	public function url(){
		return System::Get_Instance()->URL($this->path);
	}
	
	public function __construct(){
		$this->base = ($this->base == "") ? array() : explode('/', trim($this->base,'/'));
		$this->additional = ($this->additional == "") ? array() : explode('/', trim($this->additional,'/'));
		if(!($this->module instanceof Module)){
			$this->module = Module::Get_ID($this->module);
		}
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('resources')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows < 1){
			throw new Resource_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Resource');
	}
	
	private static function Get_Resources($path, $argument){
		
		$query = System::Get_Instance()->database()->Select()->table('resources')->where('=', 
			array(
				array('col', 'path'),
				array('s', $path)
			)
		)->order(
			array(
				'priority' => false
			)
		);
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Resource')){
			$row->set_additional($argument);
			$return[] = $row;
		}
		
		if(count($return) > 0){
			return $return;
		}
		
		throw new Resource_Not_Found_Exception($path, $argument);
	}
	
	public static function Get_By_Argument($module, $argument){
		// Argh!!
		
		/// TODO
		
		exit('Resource::Get_By_Argument');
		
	}
	
	public static function Get_By_Paths($paths){
		$return = array();
		foreach($paths as $path){
			try {
				$resources = self::Get_By_Path($path);
				foreach($resources as $resource){
					$return[] = $resource;
				}
			} catch (Exception $e){
				
			}
		}
		return $return;
	}
	
	public static function Get_By_Path($path = ''){
		
		// Resource Load Order
		
		// Rewrite path once to show correct path.
		
		$paths = array();
		$e = explode('/', $path);
		foreach($e as $k => $g){
			$paths[] = array(
							join('/', array_slice($e, 0, ($k == 0) ? null : -$k)),
							($k == 0) ? '' : join('/', array_slice($e, -$k))
						);
		}
		
		$exceptions = array();
		
		foreach($paths as $path){
			try {
				return self::Get_Resources($path[0], $path[1]);
			} catch(Exception $e){
				// Ignore resource
				$exceptions[] = $e;
			}
		}
		
		throw new Resource_Not_Found_Exception($exceptions);
	}
	
	
}