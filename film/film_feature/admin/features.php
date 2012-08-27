<?php
abstract class Film_Feature_Admin_Features extends Film_Feature_Admin {
	public static function Load_Main($panel,$parent) {
		try {
			$arg = $parent->resource()->get_argument();
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/features/add');					
					return new Film_Feature_Admin_Features_Add($panel,$parent);				
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/features/edit');					
					return new Film_Feature_Admin_Features_Edit($panel,$parent);
				case 'permissions':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/features/manage');					
					return new Film_Feature_Admin_Features_Manage($panel,$parent);					
					break;
				case 'manage':
					$parent->resource()->consume_argument();
				default:					
					$panel['module']->file('admin/features/manage');					
					return new Film_Feature_Admin_Features_Manage($panel,$parent);
					break;				
			} 
		} catch(Exception $e) {
			$panel['module']->file('admin/features/manage');					
			return new Film_Feature_Admin_Features_Manage($panel,$parent);
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

}