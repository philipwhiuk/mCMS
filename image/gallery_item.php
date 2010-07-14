<?php

class Image_Gallery_Item extends Gallery_Item {

	private $id;
	private $image;
	private $gallery;
	private $sort;

	public function id(){
		return (int) $this->id;
	}

	public function image(){
		if(!($this->image instanceof Image)){
			$this->image = Image::Get_By_ID($this->image);
		}
		return $this->image;
	}

	public static function Get_By_Gallery_ID($gallery, $id){
		if($gallery instanceof Gallery){
			$gallery = $gallery->id();
		}
		return self::Get_One('AND', array(
					array('=',array(array('col','id'), array('u', $id))),
					array('=',array(array('col','gallery'), array('u', $gallery)))
					));
	}

	public function previous(){
		$query = System::Get_Instance()->database()->Select()->table('gallery_image')->where('AND', array(
					array('=', array(array('col','gallery'), array('u', $this->gallery))),
					array('<', array(array('col','sort'), array('u', $this->sort)))
					))->order(array('sort' => false))->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Gallery_Item_Not_Found_Exception($operator, $operand);
		}

		return $result->fetch_object('Image_Gallery_Item');
	}

	public function next(){
		$query = System::Get_Instance()->database()->Select()->table('gallery_image')->where('AND', array(
					array('=', array(array('col','gallery'), array('u', $this->gallery))),
					array('>', array(array('col','sort'), array('u', $this->sort)))
					))->order(array('sort' => true))->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){ 
			throw new Gallery_Item_Not_Found_Exception($operator, $operand);
		}   

		return $result->fetch_object('Image_Gallery_Item');
	}

	public static function Get_One($operator, $operand){

		$query = System::Get_Instance()->database()->Select()->table('gallery_image')->where($operator, $operand)->limit(1);	
		$result = $query->execute();

		if($result->num_rows == 0){
			throw new Gallery_Item_Not_Found_Exception($operator, $operand);
		}

		return $result->fetch_object('Image_Gallery_Item');

	}


	public static function Get_By_Gallery($gallery, $offset, $limit){

		if($gallery instanceof Gallery){
			$gallery = $gallery->id();
		}

		$query = System::Get_Instance()	->database()
			->Select()
			->table('gallery_image')
			->where('=', array(array('col','gallery'), array('u', $gallery)))
			->order(array('sort' => true))
			->limit($limit)
			->offset($offset);


		$result = $query->execute();
		$return = array();

		while($row = $result->fetch_object('Image_Gallery_Item')){
			$return[$row->id()] = $row;
		}

		return $return;
	}

	public static function Count_By_Gallery($gallery){
		if($gallery instanceof Gallery){
			$gallery = $gallery->id();
		}

		$query = System::Get_Instance() ->database()
			->Count()
			->table('gallery_image')
			->where('=', array(array('col','gallery'), array('u', $gallery)));

		return $query->execute();

	}
}
