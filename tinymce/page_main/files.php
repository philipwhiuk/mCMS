<?php

class TinyMCE_Page_Main_Files extends TinyMCE_Page_Main {
	
	private $url;
	private $type;
	
	// Image browser
	
	private $images = array();
	private $image = false;
	
	// File browser
	
	private $files = array();
	private $file = false;
	
	public function __construct($parent, $type, $url){
		parent::__construct($parent);
		$this->url = $url;
		switch($type){
			case "image":
				// Image browser
				$this->type = 'image';
				$this->images = Image::Get_All();
				$arg = $parent->resource()->get_argument();
				if(is_numeric($arg)){
					try {
						$this->image = Image::Get_By_ID((int) $arg);
						$parent->resource()->consume_argument();
						$this->files = $this->image->files();
					} catch(Exception $e){
						$this->image = false;
					} 
				}
				break;
			case "media":
				break;
			case "file":
				$this->type = 'file';
				$this->files = File::Get_All();
				$arg = $parent->resource()->get_argument();
				if(is_numeric($arg)){
					try {
						$this->file = File::Get_By_ID((int) $arg);
						$parent->resource()->consume_argument();
					} catch(Exception $e){
						$this->file = false;
					} 
				}
				break;
			default:
				throw new TinyMCE_Page_Main_Files_Type_Exception($type);
		}
	}
	
	public function display(){
		
		$module = Module::Get('tinymce');
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		
		switch($this->type){
			case "file":
				$template = $system->output()->start(array('tinymce','page','files','file'));
				foreach($this->files as $file){
					$template->files[] = array(
						'name' => $file->name(),
						'url' => $system->url(Resource::Get_By_Argument($module, 'files/' . $file->id())->url(), array(
							'tinymce[type]' => 'file',
							'tinymce[url]' => $this->url,
							'output' => 'inline'
						))
					);
				}
				if($this->file !== false){
					$template->file = array(
						'name' => $this->file->name(),
						'path' => $this->file->url(),
						'size' => $this->file->size(),
						'mime' => $this->file->mime(),
						
						'path_label' => $language->get($module, array('files', 'path')),
						'size_label' => $language->get($module, array('files', 'size')),
						'mime_label' => $language->get($module, array('files', 'mime'))
					);
				} else {
					$template->file = false;
				}
				break;
			case "image":
				$template = $system->output()->start(array('tinymce','page','files','image'));
				foreach($this->images as $image){
					$template->images[] = array(
						'name' => $image->description()->get_title(),
						'url' => $system->url(Resource::Get_By_Argument($module, 'files/' . $image->id())->url(), array(
							'tinymce[type]' => 'image',
							'tinymce[url]' => $this->url,
							'output' => 'inline'
						))
					);
				}
				if($this->image !== false){
					$template->image = array(
						'name' => $this->image->description()->get_title()
					);
					foreach($this->files as $file){
						$template->image['files'][] = array(
							'src' => $file->file()->url(),
							'height' => $file->height(),
							'width' => $file->width(),
							'size' => $file->file()->size()
						);
					}
				} else {
					$template->image = false;
				}
				break;
		}
		
		$template->title = $language->get($module, array('files', 'title'));

		return $template;
	}
}