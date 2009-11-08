<?php

class TinyMCE_Page_Main_Files extends TinyMCE_Page_Main {
	
	private $url;
	private $type;
	private $images = array();
	private $image = false;
	
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
				break;
			default:
				throw new TinyMCE_Page_Main_Files_Type_Exception($type);
		}
	}
	
	public function display(){
		
		$module = Module::Get('tinymce');
		$system = System::Get_Instance();
		
		switch($this->type){
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
		}
		
		$language = Language::Retrieve();
		$template->title = $language->get($module, array('files', 'title'));

		return $template;
	}
}