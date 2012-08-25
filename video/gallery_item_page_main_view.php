<?php

class Video_Gallery_Item_Page_Main_View extends Gallery_Item_Page_Main_View  {

	private $item;

	public function selected(){
		return isset($this->item->selected) ? $this->item->selected : false;
	}

	public function __construct($item){
		$this->item = $item;
		$this->video = $item->video();
		$this->video->content();
	}

	public function display(){
		$this->system = MCMS::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('video', 'gallery','page','view'));
		$template->title = $this->video->content()->get_title();
		$template->body = $this->video->content()->get_body();
		$template->files = array();
		$furl = $this->gallery_furl . 'object/' . $this->item->id() . '/';
		$surl = $this->gallery_surl . 'object/' . $this->item->id() . '/';
		$template->furl = $this->system->url(Resource::Get_By_Argument($this->module, $furl)->url());
		$template->surl = $this->system->url(Resource::Get_By_Argument($this->module, $surl)->url());
		return $template;
	}	

}

