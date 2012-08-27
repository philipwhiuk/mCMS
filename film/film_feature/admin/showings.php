<?php
abstract class Film_Feature_Admin_Showings extends Film_Feature_Admin {
	public function execute_showings_manage(){
		$this->mode = 'showings_manage';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$showings = Film_Feature_Showing::Get_All();
		if(!(($page-1)*20 <= count($showings))) {
			$page = (int) (count($showings)/20)-1;
		}
		for($i = ($page-1)*20; $i < $page*20 && $i< count($showings); $i++) {
			if($showings[$i] instanceof Film_Feature_Showing) { $this->showings[] = $showings[$i]; }
		}
		$this->page = $page;
		$count = Film_Feature_Showing::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('showings/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}	
	public function execute_showings_edit(){
		$this->mode = 'showing_edit';
		$arg = $this->parent->resource()->get_argument();
		$this->film_feature_showing = Film_Feature_Showing::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('film',$this->film_feature_showing->get_id(), 'admin'), $this->url('edit/' . $this->film_feature_showing->get_id()));
		
		$datetime = Form_Field::Create('datetime', array('textbox'));
		$datetime->set_label($language->get($this->module, array('admin','showing_edit','datetime')));
		$datetime->set_value($this->film_feature_showing->get_datetime());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','showing_edit','submit')));
		$this->form->fields($datetime,$submit);
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('showings'));
		} catch(Form_Incomplete_Exception $e){
		}

	}
	public function execute_showings() {
		$arg = $this->parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
				case 'edit':
				case 'permissions':
					$this->parent->resource()->consume_argument();
					break;
				default:
				case 'manage':
					$this->parent->resource()->consume_argument();
					$this->execute_showings_manage();
					return;
					break;
			}
		} catch(Exception $e){
			var_dump($e);
		}
	}
	public function display_showing_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','showing_edit'));
		$template->title = $this->film_feature_showing->get_feature()->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function display_showings_manage(){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','showings','manage'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->showings as $showing){
			$template->showings[] = array(
				'title' => $showing->get_feature()->get_content()->get_title(),
				'datetime' => $showing->get_datetime(),
				'edit' => $this->url('showing_edit/' . $showing->get_id())
			);
		}
		return $template;
	}
}
