<?php

class Form {
	
	private $fields;
	
	private $id;
	
	private $url;
	
	public function get_id(){
		return $this->id;
	}
	
	public function __construct($id, $url){
		
		$this->id = $id;
		$this->url = $url;
		
	}
	
	public function fields(){
		$fields = func_get_args();
		foreach($fields as $field){
			$this->field($field);
		}
	}
	
	public function field($field){
		
		if(!$field instanceof Form_Field){
			throw new Form_Invalid_Field_Exception($this, $field);
		}
		
		$this->fields[$field->get_name()] = $field;
		
	}
	
	// $error is a localised error message
	
	public function error($error){
		$this->errors[] = $error;
	}
	
	public function errors($errors){
		$errors = (array) $errors;
		foreach($errors as $error){
			$this->error($error);
		}
	}
	
	public function execute(){
		$post =& $_POST;
		
		foreach($this->id as $id){
			if(isset($post[$id])){
				$post =& $post[$id];
			} else {
				throw new Form_Incomplete_Exception($this);
			}
		}
		
		$data = array();
		
		foreach($this->fields as $k => $v){
			try {
				$result = $v->execute($this, isset($post[$k]) ? $post[$k] : null);
				if(isset($result)){
					$data[$k] = $result;
				}
			} catch(Form_Field_Exception $e){
				$this->errors($e->errors());
			}
		}
		
		return $data;
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('form'));
		
		foreach($this->fields as $field){
			$template->fields[] = $field->display($this);
		}
		
		$template->url = $this->url;
		
		return $template;
	}
	
	
	
}