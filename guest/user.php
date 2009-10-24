<?php

class Guest_User extends User {
	
	protected $ip;
	
	protected function __construct($data = array()){
		parent::__construct($data);
	}
	
	public function authenticated(){
		return false;
	}
	
	public function Get_One($ip){
		
		try {
			$gid = System::Get_Instance()->config()->get('guest_user');
		} catch(Exception $e){
			$gid = System::Get_Instance()->site()->get('guest_user');
		}
		
		$query = System::Get_Instance()->database()->Select()->table('users')->where('=', 
			array(array('col', 'id'), array('u', $gid))
		)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Guest_User_Not_Found_Exception($operator, $operand);
		}
		
		
		$row = $result->fetch_assoc();
		$row['ip'] = $ip;
		
		return new Guest_User($row);
	}
	
}