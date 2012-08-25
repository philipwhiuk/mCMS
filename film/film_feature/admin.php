<?php

class Film_Feature_Admin extends Admin {
	protected $parent;
	protected $mode;
	
	private $pages;
	private $showings = array();
	private $features = array();

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Film_Feature_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Film_Feature_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Film_Feature_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Film_Feature_Admin_List($panel,$parent);		
		}
	}
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		$this->slist_url = $this->url('showings/');
		
		Permission::Check(array('film_feature'), array('view','edit','add','delete','list','admin'),'admin');
		
		$this->menu_feature_title = Language::Retrieve()->get($this->module, array('admin','menu','features','title'));
		$this->menu_feature_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Add')),
				  'url' => $this->url().'features/add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Manage')),
				  'url' => $this->url().'features/manage/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Permissions')),
				  'url' => $this->url().'features/permissions/'),				  	  
		);	
		$this->menu_showing_title = Language::Retrieve()->get($this->module, array('admin','menu','showings','title'));
		$this->menu_showing_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Add')),
				  'url' => $this->url().'showings/add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Manage')),
				  'url' => $this->url().'showings/manage/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Permissions')),
				  'url' => $this->url().'showings/permissions/')				  
		);
	}
	public static function film_feature_sort($a,$b) {
		try {
			$atitle = $a->get_content()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$atitle = '';
		}
		try {
			$btitle = $b->get_content()->get_title();
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
	public function execute_features_add(){
		$this->mode = 'add';
		$language = Language::Retrieve();
		$this->form = new Form(array('film','admin'), $this->url('add'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','add','title')));
		$title->set_value($this->film_feature->get_content()->get_title());
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($this->module, array('admin','add','description')));
		$description->set_value($this->film_feature->get_content()->get_body());
		
		$category = Form_Field::Create('category', array('select'));
		$category->set_label($language->get($this->module, array('admin','edit','category')));
		$cats = Film_Feature_Category::Get_All();
		foreach ($cats as $cat) {
			$category->set_option($cat->get_id(),$cat->description()->get_title(),true);
		}
		
		$filmForm = new Form_Field(array('film', 'admin'), $this->url('add'));
		//do film
		$showingForm = new Form(array('showing', 'admin'), $this->url('add'));
		$submit = Form_Field::Create('submit', array('submit'));
	}
	public function execute_features_manage(){
		$this->mode = 'features_manage';  	
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$film_features = Film_Feature::Get_All();
		@usort($film_features,array("Film_Feature_Admin","film_feature_sort"));	
		if(!(($page-1)*20 <= count($film_features))) {
			$page = (int) (count($film_features)/20)-1;
		}
		$this->film_feature = array();
		for($i = ($page-1)*20; $i < $page*20 & $i< count($film_features); $i++) {
			if($film_features[$i] instanceof Film_Feature) { $this->film_features[] = $film_features[$i]; }
		}
		$this->page = $page;
		$count = Film_Feature::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('features/manage/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}
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
	public function execute_features_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->film_feature = Film_Feature::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('film',$this->film_feature->get_id(), 'admin'), $this->url('edit/' . $this->film_feature->get_id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->film_feature->get_content()->get_title());
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($this->module, array('admin','edit','description')));
		$description->set_value($this->film_feature->get_content()->get_body());
		
		$category = Form_Field::Create('category', array('select'));
		$category->set_label($language->get($this->module, array('admin','edit','category')));
		$cats = Film_Feature_Category::Get_All();
		try {
			$current_cat = $this->film_feature->get_category()->get_id();
		}
		catch (Film_Feature_Category_Not_Found_Exception $e) {
			$current_cat = 0;
		}
		foreach ($cats as $cat) {
			if($cat->get_id() == $current_cat) {
				$category->set_option($cat->get_id(),$cat->description()->get_title(),true);
			}
			else {
				$category->set_option($cat->get_id(),$cat->description()->get_title(),false);
			}
		}
		
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		$this->form->fields($title,$description,$category,$submit);
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}
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

	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'showings':
					$this->parent->resource()->consume_argument();
					$this->execute_showings();
					return;
					break;				
				default:
				case 'features':
					$this->parent->resource()->consume_argument();
					$this->execute_features();
					return;
					break;
			}
		} catch(Exception $e){
			var_dump($e);
		}
	}
	public function execute_features() {
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
					$this->execute_features_manage();
					return;
					break;
			}
		} catch(Exception $e){
			var_dump($e);
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
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','edit'));
		$template->title = $this->film_feature->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function display_features_manage(){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film_features as $film_feature){
			$fft = array();
			try {
				$fft['title'] = $film_feature->get_content()->get_title();
			} catch (Content_Not_Found_Exception $e) {
				$fft['title'] = '';
			}
			$fft['edit'] = $this->url('edit/' . $film_feature->get_id());
			$template->film_features[] = $fft;
		}
		return $template;
	}
	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','menu'));
		$template->title = $this->menu_feature_title;
		$template->url = $this->url;
		$template->feature_title = $this->menu_feature_title;
		
		$template->feature_items = $this->menu_feature_items;
		$template->showing_title = $this->menu_showing_title;
		$template->showing_items = $this->menu_showing_items;
		$template->selected = $selected;
		return $template;
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
	public function display(){
		switch($this->mode)  {
			case 'features_add':
				return $this->display_features_add();
			case 'features_edit':
				return $this->display_features_edit();
			case 'features_manage':
				return $this->display_features_manage();
			case 'features_permissions':	
				return $this->display_features_permissions();
			case 'showings_add':
				return $this->display_showings_add();	
			case 'showings_edit':
				return $this->display_showings_edit();			
			case 'showings_manage':
				return $this->display_showings_manage();			
			case 'showings_permissions':
				return $this->display_showings_permissions();			
		}
	}
}
