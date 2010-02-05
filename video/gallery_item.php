<?php

class Video_Gallery_Item extends Gallery_Item {

	private $id;
	private $video;
	private $gallery;
	private $sort;

	public function id(){
		return (int) $this->id;
	}

	public function video(){
		if(!($this->video instanceof Image)){
			$this->video = Video::Get_By_ID($this->video);
		}
		return $this->video;
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

	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('gallery_videos')->where($operator, $operand)->limit(1);	
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Gallery_Item_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Video_Gallery_Item');
		
	}


	public static function Get_By_Gallery($gallery){

		if($gallery instanceof Gallery){
			$gallery = $gallery->id();
		}
		
		$query = System::Get_Instance()	->database()
						->Select()
						->table('gallery_videos')
						->where('=', array(array('col','gallery'), array('u', $gallery)))
						->order(array('sort' => true));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('Video_Gallery_Item')){
			$return[$row->id()] = $row;
		}
		
		return $return;
	}

}