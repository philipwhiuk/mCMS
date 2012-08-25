<?php
class Link {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('link');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('link')->order(array('id' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Link')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('link')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Content_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Link');
		
	}
	
	private $id;
	private $content;
	private $body;
	public function content(){
		return $this->content;
	}
	
	public function id(){
		return $this->id;
	}	
	public function Update($data){

		$query = MCMS::Get_Instance()->Storage()->Update()->From('content')
			->set(array(
					'content' => array('i', $data['content'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->content = $data['content'];
	}
}