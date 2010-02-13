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

		try {
			$this->next = $this->object->next()->id();
		} catch(Exception $e){
			$this->next = false;
		}

		try {
			$this->previous = $this->object->previous()->id();
		} catch(Exception $e){
			$this->previous = false;
		}
	}

	public function display(){
		$this->system = System::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('gallery','page','item','view'));
		
		$url = join('/',$this->gallery->parents()). '/';

		$template->gallery = array(
			'title' => $this->gallery->content()->get_title(),
			'body' => $this->gallery->content()->get_body(),
			'next' => ($this->next ? $this->system->url(Resource::Get_By_Argument($this->module,$url . 'object/' . $this->next)->url()) : false),
			'previous' => ($this->previous ? $this->system->url(Resource::Get_By_Argument($this->module,$url . 'object/' . $this->previous)->url()) : false)
		);

		$template->item = $this->item->display();

		return $template;
	}

}
