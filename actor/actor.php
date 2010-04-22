<?php
class Actor {
	private $id;
	private $description;
	public function id(){
		return $this->id;
	}
	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public function get_description(){
		if(!($this->description instanceof Content)){
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('actor')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Actor_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Actor');
		
	}
}