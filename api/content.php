<?php

/**
 * Content API File
 *
 * Subversion ID: $Id$
**/

class Content {
	static function Load($block, $page){
		$sql = "SELECT * FROM content WHERE block = %u AND page = %u ORDER BY id DESC LIMIT 1";
    $result = Fusion::$_->storage->query($sql, $block, $page);
		$content = new Content;
    if($result && $row = $result->fetch_assoc()){
			foreach($row as $f => $v){
				$content->$f = $v;
			}
    }
		return $content;
	}
}

class Block_Content extends Block {
	function __construct($data, Page $page){
		parent::__construct($data, $page);
		$this->content = Content::Load($this->id, $page->id);
	}
	function Run(){
		$m = 'Run_' . $this->mode;
		return $this->$m();
	}
	function Run_Edit(){
		$this->form = new Form('block_content_' . $this->id, Fusion::URL($this->URL('edit')));
		$this->form->field('title',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => $this->content->title,
			'title' => Fusion::$_->locale->get('Content/edit/title')
		));
		$this->form->field('body',array(
			'type' => 'richtext,textarea',
			'value' => $this->content->body,
			'title' => Fusion::$_->locale->get('Content/edit/body')
		));
		$this->form->field('submit',array(
			'type' => 'submit',
			'title' => Fusion::$_->locale->get('Content/edit/submit')
		));
		
		if($data = $this->form->run()){
			
		}
	}
	function Run_View(){
	
	}
	function Output(){
		$m = 'Output_' . $this->mode;
		$template = $this->$m();
		$template->modes = $this->modes;
		return $template;
	}
	function Output_View(){
		$template = Fusion::$_->output->template('content/view');
		$template->title = $this->content->title;
		$template->body = $this->content->body;
		return $template;
	}
	function Output_Edit(){
		$template = Fusion::$_->output->template('content/edit');
		$template->title = $this->content->title;
		$template->form = $this->form->output();
		return $template;
	}
}
