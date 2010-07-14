<?php

class Image_File {

	private $id;
	private $file;
	private $image;

	private $width;
	private $height;

	private function __construct($array = array()){ foreach($array as $k => $v){ $this->$k = $v; } }
	
	public function id(){
		return $this->id;
	}
	
	public function width(){
		return $this->width;
	}

	public function height(){
		return $this->height;
	}
	
	// Perform resize.
	public function resize($height, $width){
		$height = round($height);
		$width = round($width);

		$new_image = @imagecreatetruecolor($width, $height);
		if(!$new_image){
			throw new Image_Resize_Exception();
		}
		$mime = $this->file()->mime();
		if($mime == 'image/jpeg'){
			$extension = '.jpg';
			$this_image = @imagecreatefromjpeg($this->file->location());
			if(!$this_image){
				imagedestroy($new_image);
				throw new Image_Resize_Open_Exception();
			}
		} else {
			imagedestroy($new_image);
			throw new Image_Resize_Undefined_Exception($mime);
		}

		if(!imagecopyresampled($new_image, $this_image, 0, 0, 0, 0, $width, $height, $this->width, $this->height)){
			imagedestroy($this_image);
			imagedestroy($new_image);
			throw new Image_Resize_Exception();
		}

		imagedestroy($this_image);

		$file = File::Create(array('mime' => $mime,'time' => time(), 'extension' => $extension));
		$path = $file->location();

		imagejpeg($new_image, $path, 100);
		imagedestroy($new_image);

		$size = filesize($path);

		$file->update(array('size' => $size));
	
		// Insert row for this Image_File
		$image = ($this->image instanceof Image) ? $this->image->id() : $this->image;

		$db = System::Get_Instance()->database();

		$query = $db->Insert()->table('image_file')
			->set(array(
				'image' => array('u', $image),
				'file' => array('u', $file->id()),
				'width' => array('u', $width),
				'height' => array('u', $height)
			));

		$result = $query->execute();

		return new Image_File(array('id' => $db->insert_id(), 'image' => $image, 'file' => $file->id(), 'width' => $width, 'height' => $height));
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
		
		$query = System::Get_Instance()->database()->Select()->table('image_file')->where('=',array( 
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
		
		$query = System::Get_Instance()->database()->Select()->table('image_file')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Image_File_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Image_File');
		
		return $site;
		
	}
	
}
