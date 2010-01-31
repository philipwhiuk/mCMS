<?php

class Team {

	private $id;
	private $content;
	private $parent;
	private $sort;

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
			$this->children = Team::Get_By_Parent($this);
		}
		return $this->children;
	}

	public function parents(){
		if($this->parent == 0){
			return array($this->id());
		} else {
			if(!($this->parent instanceof Team)){
				$this->parent = Team::Get_By_ID($this->parent);
			}
			$parents = $this->parent->parents();
			$parents[] = $this->id();
			return $parents;
		}
	}


	public function members(){
		if(!isset($this->members)){
			$this->members = Team_Member::Get_By_Team($this);
		}
		return $this->members;
	}

	public static function Get_By_Parent($parent){
		
		if($parent instanceof Team){
			$parent = $parent->id();
		}
		
		$query = System::Get_Instance()	->database()
						->Select()
						->table('teams')
						->where('=', array(array('col','parent'), array('u', $parent)))
						->order(array('sort' => true));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('Team')){
			$return[$row->id()] = $row;
		}
		
		return $return;
	}

	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('teams')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Team_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Team');
	}

	public static function Get_By_ID($id){
		return self::Get_One('=',array(array('col','id'), array('u', $id)));
	}

	public static function Get_By_ID_Parent($id, $parent){
		if($parent instanceof Team){
			$parent = $parent->id();
		}
		return self::Get_One('AND',array(
			array('=', array(array('col','id'), array('u', $id))),
			array('=', array(array('col','parent'), array('u', $parent))),
		));
	}

}
