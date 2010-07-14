<?php

class Member {

	public static function Get_By_ID($id){
		return self::Get_One('=',array(array('col','id'), array('u', $id)));
	}

	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}

	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('member')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Member_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Member');
	}


}
