<?php

class Resource {
	
	private $id;
	private $path;
	private $module;
	private $base;
	private $additional;
	private $changed = false;
	private $pointer = 0;
	private $output;


	
	public function base(){
		if(!is_array($this->base)){
			$this->base = ($this->base == "") ? array() : explode('/', trim($this->base,'/'));
		}
		return $this->base;
	}

	public function additional(){
		if(!is_array($this->additional)){
			$this->additional = ($this->additional == "") ? array() : explode('/', trim($this->additional,'/'));
		}
		return $this->additional;
	}
	
	public function get_output(){
		if(!($this->output instanceof Module)){
			$this->output = Module::Get_ID($this->output);
		}
		return $this->output;
	}

	public function equal($that){
		if($this->module instanceof Module){
			$aid = (int) $this->module->id();
		} else {
			$aid = (int) $this->module;
		}

		if($that->module instanceof Module){
			$bid = (int) $that->module->id();
		} else {
			$bid = (int) $that->module;
		}

		if($aid == $bid){
			$eq = 1;
			$a_args = $this->get_arguments();
			$b_args = $that->get_arguments();
			foreach($a_args as $k => $arg){
				if(!isset($b_args[$k])){
					return $eq;
				}
				if($b_args[$k] != $a_args[$k]){
					return $eq;
				}
				$eq ++;
			}
			return true;
		} else {
			return 0;
		}
	}
	
	public function get_id(){
		return $this->id;
	}
	public function get_path() {
		return $this->path;
	}	

	public function get_module(){
		if(!($this->module instanceof Module)){
			$this->module = Module::Get_ID($this->module);
		}
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
		return array_merge($this->base(), $this->additional());
	}
	
	public function set_additional($argument){
		$argument = trim((string) $argument,'/');
		if($argument != '' && $argument != join('/', $this->additional())){
			$this->additional = explode('/', $argument);
			$this->changed = true;
		}
	}
	
	public function url(){
		if($this->changed){
			return implode('/', array_merge(explode('/', trim($this->path, '/')), $this->additional()));
		}
		return $this->path;
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		$query = MCMS::Get_Instance()->storage()->Get()->From('resource')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		
		if($result->num_rows < 1){
			throw new Resource_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Resource');
	}
	
	private static function Get_Resources($path, $argument){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('resource')->where('=', 
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
		$mid = ($module instanceof Module) ? $module->id() : $module; 
		
		$argument = trim($argument, '/');
		
		$t = $s = explode('/',$argument);
		
		$args = array(
			$argument => ''
		);
		
		$left = array(
		);
		
		foreach($t as $k){
			$l = array_pop($s);
			array_unshift($left, $l);
			$args[join('/',$s)] = join('/', $left);
		}
		
		foreach($args as $base => $additional){
			
			$query = MCMS::Get_Instance()->storage()->Get()->From('resource')->where('and', 
				array(
					array('=',array(
						array('col', 'module'),
						array('u', $mid)
					)),
					array('=',array(
						array('col', 'base'),
						array('s', $base)
					))
				)
			)->order(
				array(
					'priority' => false
				)
			);
			
			$result = $query->execute();
			
			if($row = $result->fetch_object('Resource')){
				$row->set_additional($additional);
				return $row;
			}
		}
		
		throw new Resource_Not_Found_Exception($module, $argument);
		
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
	
	public static function Get_Selection($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('resource')->order(array('path' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$resources = array();
		
		while($resource = $result->fetch_object('Resource')){
			$resources[] = $resource;
		}
		
		return $resources;
	}
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('resource');
		return $query->execute();

	}
}
