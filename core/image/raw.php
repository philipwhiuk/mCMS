<?php

class Image_Raw extends Raw {
	
	private $image;
	private $ifile;
	private $file;
	private $download = false;
	
	protected function __construct($resource, $image){
		parent::__construct($resource);
		$arg = $resource->get_argument();
		$this->image = $image;
		
		Permission::Check(array('image',$image->id()), array('view','edit','upload','delete'),'view');

		if($resource->get_argument() == 'download'){
			$this->download = true;
			$resource->consume_argument();
		}

		if(isset($arg) && $arg == 'width'){
			$resource->consume_argument();
			$arg = $resource->get_argument();
			if(is_numeric($arg)){
				$resource->consume_argument();
				$this->ifile = $image->width($arg);
				$this->file = $this->ifile->file();
			}
		} elseif(isset($arg) && $arg == 'height'){
			$resource->consume_argument();
			$arg = $resource->get_argument();
			if(is_numeric($arg)){
				$resource->consume_argument();
				$this->ifile = $image->height($arg);
				$this->file = $this->ifile->file();
			}
		} elseif(isset($arg) && $arg == 'min'){
			$resource->consume_argument();
			$w = $resource->get_argument();
			if(is_numeric($w)){			
				$resource->consume_argument();
				$h = $resource->get_argument();
				if(is_numeric($h)){
					$this->ifile = $image->min($w, $h);
					$this->file = $this->ifile->file();
				}
			}
		} elseif(isset($arg) && $arg == 'max'){
			$resource->consume_argument();
			$w = $resource->get_argument();
			if(is_numeric($w)){			
				$resource->consume_argument();
				$h = $resource->get_argument();
				if(is_numeric($h)){
					$this->ifile = $image->max($w, $h);
					$this->file = $this->ifile->file();
				}
			}
		} else {
			$this->ifile = $image->largest();
			$this->file = $this->ifile->file();
		}
		
		if(!$this->download && $resource->get_argument() == 'download'){
			$this->download = true;
			$resource->consume_argument();
		}
	}
	
	public function display(){
		return $this;
	}
	
	public function output(){
		header("Cache-Control: public");				// Try and cache
		header("Expires: Sat, 1 Jan 2030 05:00:00 GMT"); 		// Force cachine.
		if($this->download){
			header('Content-Disposition: attachment; filename="' . $this->file->name() . '"');
		} else {
			header('Content-Disposition: filename="' . $this->file->name() . '"');
		}
		return file_get_contents($this->file->location());
	}
	
	public function mimetype(){
		return $this->file->mime();
	}
	
	public static function Load($resource){
		$arg = $resource->get_argument();
		if(is_numeric($arg)){
			$img = Image::Get_By_ID((int) $arg);
			$resource->consume_argument();
			return new Image_Raw($resource, $img);
		}
		
	}
	
	
	
}
