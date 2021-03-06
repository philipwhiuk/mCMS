<?php

class Image {
	
	private $id;
	private $description;
	private $files;
	
	private function __construct(){}
	
	public function id(){
		return $this->id;
	}
	
	public function description(){
		if(!($this->description instanceof Content)){
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}

	public function largest(){
		$this->files();
		if(count($this->files) == 0){
			throw new Image_No_Files_Found_Exception();
		}
		$max = NULL;
		foreach($this->files as $file){
			if(!isset($max) || $file->width() > $max->width()){
				$max = $file;
			}
		}
		return $max;
	}

	// Give me the width of the thumbnail you want.
	public function width($width){
		$this->files();
		if(count($this->files) == 0){
			throw new Image_No_Files_Found_Exception();
		}
		$max = NULL;
		foreach($this->files as $file){
			if($file->width() == $width){
				return $file;
			}
			if(!isset($max) || $file->width() > $max->width()){
				$max = $file;
			}
		}
		if($max->width() < $width){
			return $max;
		}
		$height = ($width * $max->height()) / $max->width();
		return $max->resize($height, $width);
	}

	// Give me the height of the thumbnail you want.
	public function height($height){
		$this->files();
		if(count($this->files) == 0){
			throw new Image_No_Files_Found_Exception();
		}
		$max = NULL;
		foreach($this->files as $file){
			if($file->height() == $height){
				return $file;
			}
			if(!isset($max) || $file->width() > $max->width()){
				$max = $file;
			}
		}
		if($max->height() < $height){
			return $max;
		}
		$width = ($height * $max->width()) / $max->height();
		return $max->resize($height, $width);
	}

	public function min($width, $height){
		$max = $this->largest();
		$mwidth = ($height * $max->width()) / $max->height();
		if($mwidth > $width){ 
			return $this->height($height);
		} else {
			return $this->width($width);
		}
	}
	
	public function max($width, $height){
		$max = $this->largest();
		$mwidth = ($height * $max->width()) / $max->height();
		if($mwidth < $width){ 
			return $this->height($height);
		} else {
			return $this->width($width);
		}
	}

	public function raw_url($param = ''){
		return MCMS::Get_Instance()->url(
			Resource::Get_By_Argument(
				Module::Get('image'),
				$this->id() . '/' . $param
			)->url(), 
			array('output' => 'raw')
		);
	}
	
	public function files(){
		if(!isset($this->files)){
			$this->files = Image_File::Get_By_Image($this);
		}
		return $this->files;
	}
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('image');
		return $query->execute();

	}
	public static function Get_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('image');
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Image')){
			$return[] = $row;
		}
		
		return $return;
	}
	
	static public function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('image')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Image_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Image');		
	}
	
}
