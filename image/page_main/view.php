<?php

class Image_Page_Main_View extends Image_Page_Main {
	
	private $image;
	
	public function __construct($parent, $image){
		parent::__construct($parent);
		$this->image = $image;
		$this->files = $this->image->files();
		Permission::Check(array('image',$image->id()), array('view','edit','add','delete'),'view');
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('image','page','view'));
		$template->title = $this->image->description()->get_title();
		$template->body = $this->image->description()->get_body();
		$template->files = array();
		$system = System::Get_Instance();
		$module = Module::Get('image');
		foreach($this->files as $file){
			$template->files[] = array(
				'url' => $system->url(Resource::Get_By_Argument($module, $this->image->id() . '/' . $file->id())->url()),
				'src' => $file->file()->url(),
				'height' => $file->height(),
				'width' => $file->width(),
				'size' => $file->file()->size()
			);
		}
		return $template;
	}
}