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

	}

	
	public function files(){
		if(!isset($this->files)){
			$this->files = Image_File::Get_By_Image($this);
		}
		return $this->files;
	}
	
	public static function Get_All(){
		
		$query = System::Get_Instance()->database()->Select()->table('images');
		
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
		
		$query = System::Get_Instance()->database()->Select()->table('images')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Image_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Image');		
	}
	
}
