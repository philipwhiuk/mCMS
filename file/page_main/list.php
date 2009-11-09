<?php

class File_Page_Main_List extends File_Page_Main {
	
	private $files;
	
	public function __construct($parent){
		parent::__construct($parent);
		$this->files = File::Get_All();
		Permission::Check(array('file'), array('view','edit','upload','delete','list'),'list');
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('file','page','list'));
		
		$system = System::Get_Instance();
		
		$module = Module::Get('file');
		
		$language = Language::Retrieve();
		
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->files as $file){
			$template->files[] = array(
				'name' => $file->name(),
				'url' => $system->url(Resource::Get_By_Argument($module, $file->id())->url())
			);
		}
		
		
		return $template;
	}
}