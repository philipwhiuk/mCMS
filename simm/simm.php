<?php
class Simm {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_Where($operator, $operand, $limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm')->where($operator, $operand)->order(array('id' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm');
		
	}
	
	private $id;
	private $description;
	private $manifest;
	private $registry;
	private $class;
	private $status;
	private $image;
	private $format;
	public function id() {
		return $this->id;
	}
	public function manifest() {
		if(!$this->manifest instanceof Simm_Manifest) {
			$this->manifest = Simm_Manifest::Get_By_ID($this->manifest);
		}
		return $this->manifest;
	}
	public function description() {
		if(!$this->description instanceof Content) {
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public function registry() {
		return $this->registry;
	}
	public function specification() {
		if(!$this->specification instanceof Simm_Specification) {
			$this->specification = Simm_Specification::Get_By_ID($this->specification);
		}
		return $this->specification;
	}
	public function status() {
		if(!$this->status instanceof Simm_Status) {
			$this->status = Simm_Status::Get_By_ID($this->status);
		}
		return $this->status;
	}
	public function image() {
		if(!$this->image instanceof Image) {
			$this->image = Image::Get_By_ID($this->image);
		}
		return $this->image;
	}
	public function format() {
		if(!$this->format instanceof Simm_Format) {
			$this->format = Simm_Format::Get_By_ID($this->format);
		}
		return $this->format;
	}
	public function rating() {
		if(!$this->rating instanceof Simm_Rating) {
			$this->rating = Simm_Rating::Get_By_ID($this->rating);
		}
		return $this->rating;
	}
}