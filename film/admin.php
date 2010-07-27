<?php

class Film_Admin extends Admin {

	protected $parent;
	protected $mode;

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('film'), array('view','edit','add','delete','list','admin'),'admin');
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
	}
	public static function film_sort($a,$b) {
		if(
		   strtolower(
					  $a->get_description()->get_title()
			) == strtolower($b->get_description()->get_title())) {
			return 0;
		}
		else {
			return (strtolower($a->get_description()->get_title()) < strtolower($b->get_description()->get_title())) ? -1 : 1;
		}
	}
	public function execute_list(){
		$this->film = array();
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$films = Film::Get_All();
		usort($films,array("Film_Admin","film_sort"));
		if(!(($page-1)*20 <= count($films))) {
			$page = (int) (count($films)/20)-1;
		}
		for($i = ($page-1)*20; $i < $page*20; $i++) {
			if($films[$i] instanceof Film) { $this->film[] = $films[$i]; }
		}
		$this->page = $page;
		$count = Film::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}

	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->film = Film::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('film',$this->film->get_id(), 'admin'), $this->url('edit/' . $this->film->get_id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->film->get_description()->get_title());
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($this->module, array('admin','edit','description')));
		$description->set_value($this->film->get_description()->get_body());
		
		$release_year = Form_Field::Create('release_year', array('textbox'));
		$release_year->set_label($language->get($this->module, array('admin','edit','release_year')));
		$release_year->set_value($this->film->get_release_year());
		
		$certificate = Form_Field::Create('certificate', array('textbox'));
		$certificate->set_label($language->get($this->module, array('admin','edit','certificate')));
		try { $certificate->set_value($this->film->get_certificate()->get_id()); } catch (Exception $e) {}
		
		$synopsis = Form_Field::Create('synopsis', array('richtext','textarea'));
		$synopsis->set_label($language->get($this->module, array('admin','edit','synopsis')));
		try { $synopsis->set_value($this->film->get_synopsis()->get_body()); } catch (Exception $e) {}
		
		$runtime = Form_Field::Create('runtime', array('textbox'));
		$runtime->set_label($language->get($this->module, array('admin','edit','runtime')));
		$runtime->set_value($this->film->get_runtime());
		
		$imdb = Form_Field::Create('imdb', array('textbox'));
		$imdb->set_label($language->get($this->module, array('admin','edit','imdb')));
		$imdb->set_value($this->film->get_imdb());
		
		$language_field = Form_Field::Create('language', array('textbox'));
		$language_field->set_label($language->get($this->module, array('admin','edit','language')));
		$language_field->set_value($this->film->get_language()->get_id());
		
		$english_title = Form_Field::Create('english_title', array('textbox'));
		$english_title->set_label($language->get($this->module, array('admin','edit','english_title')));
		$english_title->set_value($this->film->get_english_title());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$description,$release_year,$certificate,$synopsis,$runtime,$imdb,$language_field,$english_title,$submit);
		
		try {
			$data = $this->form->execute();
			
			$this->film->update($data);
			
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
			} elseif($arg == 'edit'){
				$this->parent->resource()->consume_argument();
				$this->execute_edit();
				return;
			}
		} catch(Exception $e){
			var_dump($e);
		}
		$this->execute_list();
	}

	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('film','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		return $template;
	}

	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('film','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film as $film){
			$template->film[] = array(
				'title' => $film->get_description()->get_title(),
				'edit' => $this->url('edit/' . $film->get_id())
			);
		}
		return $template;
	}

	public function display_edit(){
		$template = System::Get_Instance()->output()->start(array('film','admin','edit'));
		$template->title = $this->film->get_description()->get_title();
		$template->form = $this->form->display();
		return $template;
	}


	public function display(){
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}

}
