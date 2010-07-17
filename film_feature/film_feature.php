<?php

class Film_Feature {
	
	private $id;
	private $content;
	private $films;
	private $module;
	
	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public function get_module() {
		if(!$this->module instanceof Module) {
			$this->module = Module::Get('film');
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
	public function get_category(){
		if(!$this->category instanceof Film_Feature_Category) {
			$this->category = Film_Feature_Category::Get_By_ID($this->category);
		}
		return $this->category;
	}
	public function get_films(){
		if(!isset($this->films)) {
			$this->implementation = $this->get_module()->load_section('Film_Feature_Impl');
			$this->films =  call_user_func(array($this->implementation, 'Get_By_Film_Feature'), $this);
		}
		return $this->films;
	}
	public function get_certificate() {
		if(!isset($this->certificate)) {
			$films = $this->get_films();
			$certID = 0;
			foreach($films as $film) {
				$certificate = $film->get_film()->get_certificate();
				if($certificate->get_id() > $certID) {
					$certID = $film->get_film()->get_certificate()->get_id();
				}
			}
			$this->certificate = Film_Certificate::Get_By_ID($certID);
		}
		return $this->certificate;
	}
	public function get_showings() {
		if(!isset($this->showings)) {
			$this->showings = Film_Feature_Showing::Get_By_Film_Feature($this);
		}
		return $this->showings;
	}
	public function Add($data){
		$database = System::Get_Instance()->database();
		$query = $database->insert()->table('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			));
		
		$query->execute();
		
		return new Content(array(
			'title' => $data['title'],
			'body' => $data['body'],
			'id' => $database->insert_id		// TODO: Fix!
		));
	}
	
	public function update($data){
		$query = System::Get_Instance()->database()->Update()->table('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->title = $data['title'];
		$this->body = $data['body'];
	}
	
	public static function Get_All(){
		$query = System::Get_Instance()->database()->Select()->table('film_feature');
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Feature')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($arg){
		if(is_array($arg)) {
			$operand = array(array('col','id'));
			foreach($arg as $row) {
				$operand[] = array('u',$row);
			}
			$query = System::Get_Instance()->database()->Select()->table('film_feature')
			->where('in',$operand);
			$result = $query->execute();
			$return = array();
			while($row = $result->fetch_object('Film_Feature')){
				$return[$row->get_id()] = $row;
			}
			return $return;
		}
		return self::Get_One('=', array(array('col','id'), array('u', $arg)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('film_feature')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Film_Feature_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Film_Feature');
	}
	public static function Get_Category_Next($category) {
		$coming_soon = Film_Feature_Showing::Get_ComingSoon(25);
		$features = array();
		foreach($coming_soon as $showing) {
			$operator = 'AND';
			$operand = 
			array(
				  array('=',array(array('col','id'),array('u',$showing->get_feature()->get_id() ))),
				  array('=',array(array('col','category'), array('u',$category->get_id())))
				  );
			$query = System::Get_Instance()->database()->Select()->table('film_feature')->where('AND',$operand)->limit(1);
			$result = $query->execute();
			if($result->num_rows > 0) {
				return $result->fetch_object('Film_Feature');
			}
		}
		throw new Film_Feature_Not_Found_Exception();
	}
	public static function Get_ComingSoon($number) {
		$coming_soon = Film_Feature_Showing::Get_ComingSoon($number);
		$features = array();
		foreach($coming_soon as $showing) {
			$operator = '=';
			$operand = array(array('col','id'), array('u', $showing->get_feature()->get_id()));
			$query = System::Get_Instance()->database()->Select()->table('film_feature')->where($operator, $operand)->limit(1);
			$result = $query->execute();
			$features[] = $result->fetch_object('Film_Feature');
		}
		$previousID = 0;
		$previousCount = 0;
		$return = array();
		foreach($features as $feature) {
			if($feature->id != $previousID) {
				$previousID = $feature->id;
				$return[] = $feature;
			}
			$previousCount++;	
		}
		return $return;
	}
	public static function Count_All(){
		$query = System::Get_Instance()->database()->Count()->table('film_feature');
		return $query->execute();
	}
}