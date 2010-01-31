<?php

class Image_Gallery_Item extends Gallery_Item {

	public static function Get_By_Gallery($gallery){

		if($gallery instanceof Gallery){
			$gallery = $gallery->id();
		}
		
		$query = System::Get_Instance()	->database()
						->Select()
						->table('gallery_images')
						->where('=', array(array('col','gallery'), array('u', $gallery)))
						->order(array('sort' => true));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('Image_Gallery_Item')){
			$return[] = $row;
		}
		
		return $return;
	}

}
