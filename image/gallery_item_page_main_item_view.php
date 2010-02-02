<?php

class Image_Gallery_Item_Page_Main_Item_View extends Gallery_Item_Page_Main_Item_View {

	public function __construct($item){
		$this->item = $item;
		$this->image = $this->item->image();
		$this->image->description();
		$this->files = $this->image->files();
		if(count($this->files) == 0){
			throw new Image_Gallery_Item_Files_Exception();
		}
	}

	public function display(){
		$this->system = System::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('image', 'gallery','page','item','view'));
		$template->title = $this->image->description()->get_title();
		$template->body = $this->image->description()->get_body();
		$template->files = array();

		foreach($this->files as $file){
			$template->files[ $file->width()] = array(
				'url' => $file->file()->url(),
				'width' => $file->width(),
				'height' => $file->height()
			);
		}
		return $template;
	}	


}
