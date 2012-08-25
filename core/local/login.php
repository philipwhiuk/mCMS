<?php

class Local_Login extends Login {

	private $form;
	
	public function salt(){
		try {
			return MCMS::Get_Instance()->site()->get('local_salt');
		} catch(Exception $e){
			try {
				return MCMS::Get_Instance()->config()->get('local_salt');
			} catch(Exception $f){
				throw new Local_Login_Salt_Unavailable_Exception($e, $f);
			}
		}
	}
	
	public function load($resource, $parent){
		parent::load($resource, $parent);
		$parent = $this->parent();
		$language = Language::Retrieve();

		$module = Module::Get('local');
		
		$this->form = new Form(array('local','login'), $parent->url($resource->url()));
		
		$username = Form_Field::Create('username', array('textbox'));
		$username->set_label($language->get($module, array('login','username')));
		
		$password = Form_Field::Create('password', array('password'));
		$password->set_label($language->get($module, array('login','password')));
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('login','submit')));
		
		$this->form->fields($username,$password, $submit);
		
		$e = false; $f = false;
		
		try {
			$data = $this->form->execute();
			
			$password = md5($this->salt() . $data['password']);
			
			try { 
				return User::Get_One('AND',array(
					array('=', array(array('col','local_username'), array('s', $data['username']))),
					array('=', array(array('col','local_password'), array('s', $password))),
				));
			} catch(User_Not_Found_Exception $e){
				// User not found
			}
		} catch(Exception $f){
			// Form is incomplete. Oh dear.
		}
		
		throw new Login_Incomplete_Exception();
		
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('local','login'));
		
		$template->form = $this->form->display();
		
		return $template;
	}
	
}