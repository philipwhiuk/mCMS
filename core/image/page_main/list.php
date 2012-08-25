<?php

class Image_Page_Main_List extends Image_Page_Main {
	
	private $images;
	
	public function __construct($parent){
		parent::__construct($parent);
		$this->images = Image::Get_All();
		Permission::Check(array('image'), array('view','edit','add','delete','list'),'list');
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('image','page','list'));
		
		$system = MCMS::Get_Instance();
		
		$module = Module::Get('image');
		
		$language = Language::Retrieve();
		
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->images as $image){
			$template->images[] = array(
				'name' => $image->description()->get_title(),
				'url' => $system->url(Resource::Get_By_Argument($module, $image->id())->url())
			);
		}
		
		
		return $template;
	}
}