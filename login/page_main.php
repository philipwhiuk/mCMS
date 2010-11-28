<?php

class Login_Page_Main extends Page_Main {
	
	private $login;
	
	public function __construct($parent, $login){
		parent::__construct($parent);
		$this->login = $login;
		try {
			$user = $this->login->load($this->parent->resource(), $this);
			Authentication::Authenticate($user);
			$system = System::Get_Instance();
			$system->redirect($system->url('home'));
			exit;
		} catch(Login_Incomplete_Exception $e){
		}
	}
	
	public function url($url){
		return $this->parent->url($url);
	}
	
	public static function Load($parent){
		
		if(!Authentication::Authenticable()){
			throw new Login_Page_Unavailable_Exception();
		}
		
		$exceptions = array();
		
		// Get a Login Module
		
		$arg = $parent->resource()->get_argument();
		
		try {
			try {
				if(isset($arg) && is_numeric($arg)){
					$id = (int) $arg;
					$login = Login::Get_By_ID_Active($id);
					$parent->resource()->consume_argument();
					return new Login_Page_Main($parent, $login);
				}
			} catch (Exception $e){
				$exceptions[] = $e;
			}
			
			$login = Login::Get_By_Highest_Priority();
			return new Login_Page_Main($parent, $login);
		} catch (Exception $e){
			$exceptions[] = $e;
		}
		
		throw new Login_Page_Unavailable_Exception($exceptions);
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('login','page'));
		
		$template->login = $this->login->display();
		
		return $template;
	}
}
