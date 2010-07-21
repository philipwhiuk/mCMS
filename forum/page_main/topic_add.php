<?php
class Forum_Page_Main_Topic_Add extends Forum_Page_Main {
	function __construct($parents,$forum,$parent) {
		parent::__construct($parent);
		$module = Module::Get('forum');
		$language = Language::Retrieve();
		
		$this->parents = $parents;
		$this->forum = $forum;
		$this->forum->content()->get_title();
		$this->forum->content()->get_body();
		$urlpart = "";
		foreach($this->parents as $parent) {
			$urlpart .= $parent->id().'/';	
		}		
		$this->forumurl = System::Get_Instance()->url(Resource::Get_By_Argument($module, $urlpart.$this->forum->id())->url());
		
		$this->form = new Form(array('forum', 'topic_add'), $this->parent->url($this->parent->resource()->url()));
		$this->title = $language->get($module, array('topic','add','title_main'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('topic','add','title')));
		
		$description = Form_Field::Create('description', array('textbox'));
		$description->set_label($language->get($module, array('topic','add','description')));
		
		$post_title = Form_Field::Create('post_title', array('textbox'));
		$post_title->set_label($language->get($module, array('topic','add','post_title')));
		
		$post_body = Form_Field::Create('post_body', array('richtext','textarea'));
		$post_body->set_label($language->get($module, array('topic','add','post_body')));
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('topic','add','submit')));
		
		$this->form->fields($title,$description,$post_title,$post_body,$submit);
		
		try {
			$data = $this->form->execute();
		} catch(Form_Incomplete_Exception $e){
		}
		
	}
	function display() {
		$system = System::Get_Instance();
		$forummodule = Module::Get('forum');
		$template = $system->output()->start(array('forum','page','topic','add'));
		foreach($this->parents as $parent) {
			$pa = array();
			$pa['title'] = $parent->content()->get_title();
			if(!isset($parenturl)) {
				$parenturl = System::Get_Instance()->url(Resource::Get_By_Argument($forummodule,$parent->id())->url());
				$pa['url'] = $parenturl;
			}
			else {
				$pa['url'] = $parenturl.$parent->id().'/';
			}				
			$template->parents[] = $pa;
		}
		$template->forum['title'] = $this->forum->content()->get_title();
		$template->forum['url'] = $this->forumurl;
		$template->title = $this->title;
		try {
			$template->forum['parentID'] = $this->forum->parent()->id();
		}
		catch (Forum_Not_Found_Exception $e) {
			$template->forum['parentID'] = 0;
		}
		$template->form = $this->form->display();
		return $template;
	}
}