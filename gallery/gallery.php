<?php

class Gallery {

	private $id;
	private $content;
	private $parent;
	private $sort;
	private $module;

	public function id(){
		return $this->id;
	}

	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}

	public function children(){
		if(!isset($this->children)){
			$this->children = Gallery::Get_By_Parent($this);
		}
		return $this->children;
	}

	public function parents(){
		if($this->parent == 0){
			return array($this->id());
		} else {
			if(!($this->parent instanceof Gallery)){
				$this->parent = Gallery::Get_By_ID($this->parent);
			}
			$parents = $this->parent->parents();
			$parents[] = $this->id();
			return $parents;
		}
	}

	public function objects(){
		if(!isset($this->objects)){
			try {
				$class = Module::Get_ID($this->module)->load_section('Gallery_Item');
			} catch(Exception $e){ print_r($e); }
			$this->objects = call_user_func(array($class, 'Get_By_Gallery'), $this);
		}
		return $this->objects;
	}


/*	public function members(){
		if(!isset($this->members)){
			$this->members = Team_Member::Get_By_Team($this);
		}
		return $this->members;
	}*/

	public static function Get_By_Parent($parent){
		
		if($parent instanceof Gallery){
			$parent = $parent->id();
		}
		
		$query = System::Get_Instance()	->database()
						->Select()
						->table('galleries')
						->where('=', array(array('col','parent'), array('u', $parent)))
						->order(array('sort' => true));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('Gallery')){
			$return[$row->id()] = $row;
		}
		
		return $return;
	}

	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('galleries')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Gallery_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Gallery');
	}

	public static function Get_By_ID($id){
		return self::Get_One('=',array(array('col','id'), array('u', $id)));
	}

	public static function Get_By_ID_Parent($id, $parent){
		if($parent instanceof Gallery){
			$parent = $parent->id();
		}
		return self::Get_One('AND',array(
			array('=', array(array('col','id'), array('u', $id))),
			array('=', array(array('col','parent'), array('u', $parent))),
		));
	}

}

