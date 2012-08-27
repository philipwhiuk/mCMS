<?php
class Film_Feature_Admin_Features_Edit extends Film_Feature_Admin_Features {
	public function __construct($a,$b){
		parent::__construct($a,$b);
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
			try {
				$catTitle = $cat->description()->get_title();
			} catch (Content_Not_Found_Exception $e) {
				$catTitle = '';
			}
		
			if($cat->get_id() == $current_cat) {
				$category->set_option($cat->get_id(),$catTitle,true);
			}
			else {
				$category->set_option($cat->get_id(),$catTitle,false);
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
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','features','edit'));
		$template->title = $this->film_feature->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}