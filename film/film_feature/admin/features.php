<?php
abstract class Film_Feature_Admin_Features extends Film_Feature_Admin {
	public static function Load_Main($panel,$parent) {
		$arg = $parent->resource()->get_argument();
		switch($arg) {
			case 'add':
			case 'edit':
			case 'permissions':
				$parent->resource()->consume_argument();
				break;
			default:					
			case 'manage':
				$parent->resource()->consume_argument();
				$panel['module']->file('admin/features/manage');					
				return new Film_Feature_Admin_Features_Manage($panel,$parent);
				break;				
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
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

}