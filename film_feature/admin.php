<?php

class Film_Feature_Admin extends Admin {

	protected $parent;
	protected $mode;

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		$this->slist_url = $this->url('showings/');
		
		Permission::Check(array('film_feature'), array('view','edit','add','delete','list','admin'),'admin');
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
		$this->slist_name = Language::Retrieve()->get($this->module, array('admin','menu','showings_name'));
	}
	public static function film_feature_sort($a,$b) {
		if(
			strtolower($a->get_content()->get_title()) 
			== 
			strtolower($b->get_content()->get_title())
		) {
			return 0;
		}
		else {
			return (
				strtolower($a->get_content()->get_title()) 
				< 
				strtolower($b->get_content()->get_title())
			) ? -1 : 1;
		}
	}
	public function execute_list(){
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$film_features = Film_Feature::Get_All();
		usort($film_features,array("Film_Feature_Admin","film_feature_sort"));
		if(!(($page-1)*20 <= count($film_features))) {
			$page = (int) (count($film_features)/20)-1;
		}
		for($i = ($page-1)*20; $i < $page*20; $i++) {
			if($film_features[$i] instanceof Film_Feature) { $this->film_feature[] = $film_features[$i]; }
		}
		$this->page = $page;
		$count = Film_Feature::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}
	public function execute_showings(){
		$this->mode = 'showings';  
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
		for($i = ($page-1)*20; $i < $page*20; $i++) {
			if($showings[$i] instanceof Film_Feature_Showing) { $this->showing[] = $showings[$i]; }
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
	
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->content = Film::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('film',$this->content->id(), 'admin'), $this->url('edit/' . $this->content->id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->film_feature->get_content()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->film_feature->get_content()->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			System::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			if($arg == 'list'){
				$this->parent->resource()->consume_argument();
				$this->execute_list();
				return;
			} elseif($arg == 'showings') {
				$this->parent->resource()->consume_argument();
				$this->execute_showings();
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

	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('film_feature','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		$template->slist_url = $this->slist_url;
		$template->slist_name = $this->slist_name;
		return $template;
	}

	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('film_feature','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film_feature as $film_feature){
			$template->film_feature[] = array(
				'title' => $film_feature->get_content()->get_title(),
				'edit' => $this->url('edit/' . $film_feature->get_id())
			);
		}
		return $template;
	}

	public function display_showings(){
		$template = System::Get_Instance()->output()->start(array('film_feature','admin','showings'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->showing as $showing){
			$template->showing[] = array(
				'title' => $showing->get_feature()->get_content()->get_title(),
				'datetime' => $showing->get_datetime(),
				'edit' => $this->url('showing_edit/' . $showing->get_id())
			);
		}
		return $template;
	}
	
	public function display_edit(){
		$template = System::Get_Instance()->output()->start(array('film','admin','edit'));
		$template->title = $this->film_feature->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}


	public function display(){
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'showings'){
			return $this->display_showings();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}

}
