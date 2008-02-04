<?php

/**
 * Content API File
 *
 * Subversion ID: $Id$
**/

class Content {
	static function Load($block, $page, $locale){
		$sql = "SELECT * FROM content WHERE block = %u AND page = %u ORDER BY id DESC LIMIT 1";
    $result = Fusion::$_->storage->query($sql, $block, $page);
		$content = new Content;
    if($result && $row = $result->fetch_assoc()){
			foreach($row as $f => $v){
				$content->$f = $v;
			}
    } else {
			$content->block = $block;
			$content->page = $page;
			$content->locale = $locale;
		}
		return $content;
	}
	function Update($title, $body){	
		$sql = "INSERT INTO content SET time = %u, block = %u, page = %u, locale = %u, title = %s, body = %s";
		$time = time();
		$result = Fusion::$_->storage->query($sql, $time, $this->block, $this->page, $this->locale, $title, $body, $this->id);
		$this->time = $time;
		$this->title = $title;
		$this->body = $body;
	}
}

class Block_Content extends Block {
	function __construct($data, Page $page){
		parent::__construct($data, $page);
		$this->content = Content::Load($this->id, $page->id, Fusion::$_->locale->id);
	}
	function Run($render_mode){
		if($render_mode){
			$m = 'Run_' . $this->mode;
			$this->render = true;
			return $this->$m();
		} else {
			$this->mode = 'view';
			$this->render = false;
			return $this->Run_View();
		}
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
			$this->content->Update($data['title'], $data['body']);
			// Assume not continuing!
			Fusion::Redirect($this->page->URL());
		}
	}
	function Run_View(){
	
	}
	function Output(){
		$m = 'Output_' . $this->mode;
		$template = $this->$m();
		$template->modes = $this->modes;
		$template->render = $this->render;
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
