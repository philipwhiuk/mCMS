<?php

class Content_Page_Main_List extends Content_Page_Main {
	
	protected $content;
	
	public function __construct($parent){
		parent::__construct($parent);
		$this->content = Content::Get_All();
		Permission::Check(array('content'), array('view','edit','add','delete','list'),'list');
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','page','list'));
		
		$language = Language::Retrieve();
		
		$system = System::Get_Instance();
		
		$module = Module::Get('content');
		
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->content as $content){
			$template->content[] = array(
				'name' => $content->get_title(),
				'url' => $system->url(Resource::Get_By_Argument($module, $content->id())->url())
			);
		}
		
		
		return $template;
	}
}
