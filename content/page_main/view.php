<?php

class Content_Page_Main_View extends Content_Page_Main {
	
	private $content;
	
	public function __construct($parent, $content){
		parent::__construct($parent);
		$this->content = $content;
		Permission::Check(array('content',$content->id()), array('view','edit','add','delete','list'),'view');
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','page','view'));
		$template->title = $this->content->get_title();
		$template->body = $this->content->get_body();
		return $template;
	}
}

