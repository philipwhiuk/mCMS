<?php
class Film_Festival {
	private $id;
	private $content;
	private $features;
	private $module;
	public function get_module() {
		if(!$this->module instanceof Module) {
			$this->module = Module::Get('film_feature');
		}
		return $this->module;
	}
	public function get_id() {
		return $this->id;
	}
	public function get_content(){
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public function get_features(){
		if(!isset($this->features)) {
			$this->implementation = $this->get_module()->load_section('Film_Festival_Impl');
			$this->features = call_user_func(array($this->implementation, 'Get_By_Film_Festival'), $this);
		}
		return $this->features;
	}
	public static function Get_All(){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('film_festival');
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Festival')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('film_festival')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Film_Festival_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Film_Festival');
	}
	public static function Count_All(){
		$query = MCMS::Get_Instance()->Storage()->Count()->From('film_festival');
		return $query->execute();
	}
}