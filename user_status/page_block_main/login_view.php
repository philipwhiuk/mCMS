<?php
class User_Status_Page_Block_Main_Login_View extends User_Status_Page_Block_Main {
	public function __construct($parent,$user) {
		$this->user = $user;
		$this->form = new Form(array('user_status',$user->get_id(), 'login'), '');
		$username = Form_Field::Create('username', array('textbox'));
		$username->set_label('Username');
		$username->set_value('');
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label('Submit');
		$this->form->fields($username,$submit);
		try {
			$data = $this->form->execute();			
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
		}
	}
	public function display() {
		$template = System::Get_Instance()->output()->start(array('user_status','page','block','login','view'));
		$template->form = $this->form;
		
		return $template;
	}
}
