<?php

class File_Page_Main_View extends File_Page_Main {
	
	private $file;
	
	public function __construct($parent, $file){
		parent::__construct($parent);
		$this->file = $file;
		Permission::Check(array('file',$file->id()), array('view','edit','upload','delete','list','admin'),'view');
	}
	
	public function display(){
		
		$language = Language::Retrieve();
		$module = Module::Get('file');
		
		$template = MCMS::Get_Instance()->output()->start(array('file','page','view'));
		$template->name = $this->file->name();
		$template->path = $this->file->url();
		// Interperet: $template->time = $this->file->time();
		$template->size = $this->file->size();
		$template->mime = $this->file->mime();
		
		$template->path_label = $language->get($module, array('view', 'path'));
		$template->size_label = $language->get($module, array('view', 'size'));
		$template->mime_label = $language->get($module, array('view', 'mime'));
		
		return $template;
	}
}
