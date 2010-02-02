<?php

class Gallery_Page_Main_Item_View extends Gallery_Page_Main {

	public function __construct($parent, $gallery, $object){
		parent::__construct($parent);
		$this->gallery = $gallery;
		$this->object = $object;

		$gallery->content();

		Module::Get('gallery')->file('gallery_item/page_main/item/view');
		
		$gallery->section = $class = $gallery->module()->load_section('Gallery_Item_Page_Main_Item_View');
		$this->item = new $class($object);
	}

	public function display(){
		$this->system = System::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('gallery','page','item','view'));
		
		$template->gallery = array(
			'title' => $this->gallery->content()->get_title(),
			'body' => $this->gallery->content()->get_body()
		);

		$template->item = $this->item->display();

		return $template;
	}

}
