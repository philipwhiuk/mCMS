<?php
class Event {
	private $id;
	private $module;
	private $content;
	private $starttime;
	private $finishtime;
	private $category;
	
	public function get_id() {
		return $this->id;
	}
	public function get_content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public function get_module() {
		if(!$this->module instanceof Module) {
			$this->module = Module::Get_ID($this->module);
		}
		return $this->module;
	}
	public function get_starttime() {
		return $this->starttime;
	}
	public function get_finishtime() {
		return $this->finishtime;
	}
	public function get_category() {
		if(!$this->category instanceof Event_Category) {
			$this->category = Event_Category::Get_By_ID($this->category);
		}
		return $this->category;
	}
	public function get_objects() {
		if(!isset($this->objects)){
			$this->implementation = $this->get_module()->load_section('Event_Impl');
			$this->objects = call_user_func(array($this->implementation, 'Get_By_Event'), $this);
		}
		return $this->objects;
	}
	public static function Get_All(){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('event');
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Event')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('event')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Event_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Event');
		
	}
	public static function Get_Next() {
		$operator = '>';
		$operand = array(array('col','finishtime'), array('u', time()));
		$ordering = array('starttime' => true);
		$query = MCMS::Get_Instance()->Storage()->Get()->From('event')->where($operator, $operand)->order($ordering)->limit(1);
		$result = $query->execute();		
		if($result->num_rows == 0){
			throw new Event_Not_Found_Exception();
		}
		return $result->fetch_object('Event');
	}
	public static function Get_Next_By_Category($cat,$skip) {
		$operator = 'AND';
		$operand = array(
		array('>',array(array('col','finishtime'), array('u', time()))),
		array('=',array(array('col','category'), array('u', $cat)))
		);
		$ordering = array('starttime' => true);
		$query = MCMS::Get_Instance()->Storage()->Get()->From('event')->where($operator, $operand)->order($ordering)->limit(1)->offset($skip);
		$result = $query->execute();		
		if($result->num_rows == 0){
			throw new Event_Not_Found_Exception();
		}
		return $result->fetch_object('Event');
	}
	public static function Count_All(){
		$query = MCMS::Get_Instance()->Storage()->Count()->From('event');
		return $query->execute();
	}
}