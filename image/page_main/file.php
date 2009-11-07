<?php

class Image_Page_Main_File extends Image_Page_Main {
	
	private $file;
	
	private $image;
	
	public function __construct($parent, $image, $file){
		parent::__construct($parent);
		$this->image = $image;
		$this->file = $file;
		Permission::Check(array('image',$image->id()), array('view','edit','add','delete'),'view');
	}
	
	public function display(){
		
		$language = Language::Retrieve();
		$module = Module::Get('image');
		
		$template = System::Get_Instance()->output()->start(array('image','page','file'));
		$template->name = $this->image->description()->get_title();
		
		
		$template->path_label = $language->get($module, array('file', 'path'));
		$template->size_label = $language->get($module, array('file', 'size'));
		$template->mime_label = $language->get($module, array('file', 'mime'));
		
		$template->width_label = $language->get($module, array('file', 'width'));
		$template->height_label = $language->get($module, array('file', 'height'));
		
		$template->mime = $this->file->file()->mime();
		$template->size = $this->file->file()->size();
		$template->path = $this->file->file()->url();
		$template->filename = $this->file->file()->name();
		
		$template->width = $this->file->width();
		$template->height = $this->file->height();
		
		return $template;
	}
}