<?php

class Film_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	
	public static function Load_Menu($panel, $parent) {
		$parent->resource()->get_module()->file('admin/menu');
		return new Film_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('admin/edit');					
					return new Film_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$parent->resource()->get_module()->file('admin/list');				
					return new Film_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$parent->resource()->get_module()->file('admin/list');		
			return new Film_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('film'), array('view','edit','add','delete','list','admin'),'admin');
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->menu_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Add')),
				  'url' => $this->url().'add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Manage')),
				  'url' => $this->url().'list/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Permissions')),
				  'url' => $this->url().'permissions/'),			  
		);			
	}
	public static function film_sort($a,$b) {
		try {
			$atitle = $a->get_description()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$atitle = '';
		}
		try {
			$btitle = $b->get_description()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$btitle = '';
		}
	
		if(strtolower($atitle) == strtolower($btitle)) {
			return 0;
		}
		else {
			return (strtolower($atitle) < strtolower($btitle)) ? -1 : 1;
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
		@usort($films,array("Film_Admin","film_sort"));
		if(!(($page-1)*20 <= count($films))) {
			$page = (int) (count($films)/20)-1;
		}
		for($i = ($page-1)*20; $i < $page*20 && $i < count($films); $i++) {
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
		$this->page_title = $language->get($this->module, array('admin','list','title'));
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
		
		$certificate = Form_Field::Create('certificate', array('select'));
		$certificate->set_label($language->get($this->module, array('admin','edit','certificate')));
		$certs = Film_Certificate::Get_All();
		try {
			$current_cert = $this->film->get_certificate()->get_id();
		}
		catch (Film_Certificate_Not_Found_Exception $e) {
			$current_cert = 0;
		}
		foreach ($certs as $cert) {
			if($cert->get_id() == $current_cert) {
				$certificate->set_option($cert->get_id(),$cert->get_image()->description()->get_title(),true);
			}
			else {
				$certificate->set_option($cert->get_id(),$cert->get_image()->description()->get_title(),false);
			}
		}
		
		$synopsis = Form_Field::Create('synopsis', array('richtext','textarea'));
		$synopsis->set_label($language->get($this->module, array('admin','edit','synopsis')));
		try { $synopsis->set_value($this->film->get_synopsis()->get_body()); } catch (Exception $e) {}
		
		$runtime = Form_Field::Create('runtime', array('textbox'));
		$runtime->set_label($language->get($this->module, array('admin','edit','runtime')));
		$runtime->set_value($this->film->get_runtime());
		
		$imdb = Form_Field::Create('imdb', array('textbox'));
		$imdb->set_label($language->get($this->module, array('admin','edit','imdb')));
		$imdb->set_value($this->film->get_imdb());
		
		$f_language = Form_Field::Create('language', array('select'));
		$f_language->set_label($language->get($this->module, array('admin','edit','language')));
		$f_langs = Film_Language::Get_All();
		try {
			$current_lang = $this->film->get_language()->get_id();
		}
		catch (Film_Language_Not_Found_Exception $e) {
			$current_lang = 0;
		}
		foreach ($f_langs as $f_lang) {
			if($f_lang->get_id() == $current_lang) {
				$f_language->set_option($f_lang->get_id(),$f_lang->get_content()->get_title(),true);
			}
			else {
				$f_language->set_option($f_lang->get_id(),$f_lang->get_content()->get_title(),false);
			}
		}
		
		$english_title = Form_Field::Create('english_title', array('textbox'));
		$english_title->set_label($language->get($this->module, array('admin','edit','english_title')));
		$english_title->set_value($this->film->get_english_title());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$description,$release_year,$certificate,$synopsis,$runtime,$imdb,$f_language,$english_title,$submit);
		
		try {
			$data = $this->form->execute();
			
			$this->film->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
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
		}
		$this->execute_list();
	}

	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->selected = $selected;
		$template->items = $this->menu_items;
		return $template;
	}

	public function display_list(){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film as $film){
			$filmT = array();
			try {
				$filmT['title'] = $film->get_description()->get_title();
			} catch (Content_Not_Found_Exception $e) {
				$filmT['title'] = '';
			}
			$filmT['edit'] = $this->url('edit/' . $film->get_id());
			$template->films[] = $filmT;
		}
		return $template;
	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','edit'));
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
