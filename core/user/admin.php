<?php
class User_Admin extends Admin {

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new User_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new User_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new User_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new User_Admin_List($panel,$parent);		
		}
	}

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public function display() {
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		}
	}
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('user','admin','edit'));
		$template->title = $this->user->name();
		$template->form = $this->form->display();
		return $template;
	}	


	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			if($arg == 'list'){
				$this->parent->resource()->consume_argument();
				$this->execute_list();
				return;
			} elseif($arg == 'edit'){
				$this->parent->resource()->consume_argument();
				$this->execute_edit();
				return;
			}
		} catch(Exception $e){

		}
		$this->execute_list();
	}
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->user = User::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();
		$language = Language::Retrieve();
		$this->form = new Form(array('user',$this->user->id(), 'admin'), $this->url('edit/' . $this->user->id()));
		
		$name = Form_Field::Create('name', array('textbox'));
		$name->set_label($language->get($this->module, array('admin','edit','name')));
		$name->set_value($this->user->name());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));

		$this->form->fields($name,$submit);
	}	
}