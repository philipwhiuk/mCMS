<?php
class Content_Page_Main_Entry_View extends Content_Page_Main {
	protected $content;
	
	public function __construct($parent, $content){
		parent::__construct($parent);
		$this->content = $content;
		$this->check('view');
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('content','page','view'));
		$template->id = $this->content->id();
		$template->title = $this->content->get_title();
		$template->body = $this->content->get_body();
		$template->modes = $this->modes;
		return $template;
	}
}