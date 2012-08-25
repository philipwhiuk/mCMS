<?php

class Video_Gallery_Item_Page_Main_Item_View extends Gallery_Item_Page_Main_Item_View {

	public function __construct($item){
		$this->item = $item;
		$this->video = $item->video();
		$this->video->content();
	}

	public function display(){
		$this->system = MCMS::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('video', 'gallery','page','item','view'));
		$template->title = $this->video->content()->get_title();
		$template->body = $this->video->content()->get_body();
		return $template;
	}	
	

}
