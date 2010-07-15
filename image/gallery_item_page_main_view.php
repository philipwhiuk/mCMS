<?php

class Image_Gallery_Item_Page_Main_View extends Gallery_Item_Page_Main_View  {

	private $item;

	public function selected(){
		return isset($this->item->selected) ? $this->item->selected : false;
	}

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
		$template = $this->system->output()->start(array('image', 'gallery','page','view'));
		$template->title = $this->image->description()->get_title();
		$template->body = $this->image->description()->get_body();
		$template->image = $this->image;
		$furl = $this->gallery_furl . 'object/' . $this->item->id() . '/';
		$surl = $this->gallery_surl . 'object/' . $this->item->id() . '/';
		$template->furl = $this->system->url(Resource::Get_By_Argument($this->module, $furl)->url());
		$template->surl = $this->system->url(Resource::Get_By_Argument($this->module, $surl)->url());
		return $template;
	}	

}
