<?php

class Team_Member {

	private $id;
	private $content;
	private $team;
	private $member;
	private $sort;

	public function id(){
		return $this->id;
	}

	public function member(){
		if(!($this->member instanceof Member)){
			$this->member = Member::Get_By_ID($this->member);
		}
		return $this->member;
	}

	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}

	public static function Get_By_ID_Team($id, $team){
		if($team instanceof Team){
			$team = $team->id();
		}
		return self::Get_One('AND',array(
			array('=', array(array('col','id'), array('u', $id))),
			array('=', array(array('col','team'), array('u', $team))),
		));
	}

	public static function Get_One($operator, $operand){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('team_member')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Team_Member_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Team_Member');
	}


	public static function Get_By_Team($team){

		if($team instanceof Team){
			$team = $team->id();
		}
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('team_member')
						->where('=', array(array('col','team'), array('u', $team)))
						->order(array('sort' => true));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('Team_Member')){
			$return[] = $row;
		}
		
		return $return;


	}

}
