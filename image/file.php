<?php

class Image_File {
	
	private $id;
	private $file;
	private $image;

	private $width;
	private $height;
	
	public function id(){
		return $this->id;
	}
	
	public function width(){
		return $this->width;
	}

	public function height(){
		return $this->height;
	}
	
	public function file(){
		if(!($this->file instanceof File)){
			$this->file = File::Get_By_ID($this->file);
		}
		return $this->file;
	}
	
	public static function Get_By_Image($image){
		
		if($image instanceof Image){
			$image = $image->id();
		}
		
		$query = System::Get_Instance()->database()->Select()->table('image_files')->where('=',array( 
			array('col', 'image'),
			array('u', $image)
		));
		
		$result = $query->execute();
		
		$ifs = array();
		
		while($row = $result->fetch_object('Image_File')){
			$ifs[] = $row;
		}
		
		return $ifs;
		
	}
	
	static public function Get_By_ID_Image($id, $image){
		if($image instanceof Image){
			$image = $image->id();
		}
		
		return self::Get_One('AND', array(
			array('=',array(
				array('col','id'), 
				array('u', $id)
			)),
			array('=',array(
				array('col','image'), 
				array('u', $image)
			)),		
		));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('image_files')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Image_File_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Image_File');
		
		return $site;
		
	}
	
}