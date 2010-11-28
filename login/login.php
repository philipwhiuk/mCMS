<?php

abstract class Login {
	
	private $id;
	private $module;
	private $active;
	private $sort;
	private $resource;
	private $parent;
	
	public function get_id(){
		return $this->id;
	}
	
	public function resource(){
		return $this->resource;
	}
	
	public function parent(){
		return $this->parent;
	}
	
	protected function __construct($data = array()){
		foreach($data as $f => $v){ $this->$f = $v; }
	}
	
	public function load($resource, $parent){
		$this->resource = $resource;
		$this->parent = $parent;
	}
	
	abstract public function display();
	
	public static function Get_By_Highest_Priority(){
		
		$query = System::Get_Instance()->database()->Select()->table('login')->where('=', array(
			array('col','active'),
			array('bool',true)
		))->order(array('sort' => 'ASC'))->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Login_Not_Found_Exception();
		}
		
		$login = $result->fetch_assoc();
		
		$login['module'] = Module::Get_ID($login['module']);
		
		$class = $login['module']->load_section('Login');
		
		return new $class($login);
	}

	public static function Get_By_ID_Active($id){
		$query = System::Get_Instance()->database()->Select()->table('login')->where('AND', array(
			array('=',array(array('col', 'active'), array('bool',true))),
			array('=',array(array('col', 'id'), array('u', $id)))
		))->limit(1);

		$result = $query->execute();

		if($result->num_rows == 0){
			throw new Login_Not_Found_Exception($id);
		}

		$login = $result->fetch_assoc();

		$login['module'] = Module::Get_ID($login['module']);
		     
		$class = $login['module']->load_section('Login');

		return new $class($login);

	}

}
