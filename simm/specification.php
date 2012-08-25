<?php
class Simm_Specification {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_specification');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_specification')->order(array('lastname' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Specification')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_specification')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Specification_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Specification');
		
	}

	private $id;
	private $description;
	private $duration;
	private $resupply;
	private $refit;
	private $category;
	private $cruisevel;
	private $maxvel;
	private $emervel;
	private $eveltime;
	private $officers;
	private $enlisted;
	private $passengers;
	private $marines;
	private $evac;
	private $shuttlebays;
	private $length;
	private $width;
	private $height;
	private $decks;
	private $notes;
	private $image;
	private $active;
	
	public function id() {
		return $this->id;
	}
	public function description() {
		if(!$this->description instanceof Content) {
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public function duration() {
		return $this->duration;
	}
	public function resupply() {
		return $this->resupply;
	}
	public function refit() {
		return $this->refit;
	}
	public function category() {
		if(!$this->category instanceof Simm_Specification_Category) {
			$this->category = Simm_Specification_Category::Get_By_ID($this->category);
		}
		return $this->category;
	}
	public function  cruisevel() {
		return $this->cruisevel;
	}
	public function  maxvel() {
		return $this->maxvel;
	}
	public function emervel() {
		return $this->emervel;
	}
	public function  eveltime() {
		return $this->eveltime;
	}
	public function  officers() {
		return $this->officers;
	}
	public function  enlisted() {
		return $this->enlisted;
	}
	public function  passengers() {
		return $this->passengers;
	}
	public function  marines() {
		return $this->marines;
	}
	public function  evac() {
		return $this->evac;
	}
	public function docking() {
		return $this->docking;
	}
	public function shuttlebays() {
		return $this->shuttlebays;
	}
	public function  length() {
		return $this->length;
	}
	public function  width() {
		return $this->width;
	}
	public function  height() {
		return $this->height;
	}
	public function  decks() {
		return $this->decks;
	}
	public function  notes() {
		if(!$this->notes instanceof Content) {
			$this->notes = Content::Get_By_ID($this->notes);
		}
		return $this->notes;
	}
	public function  image() {
		return $this->image;
	}
	public function  active() {
		return $this->active;
	}
}