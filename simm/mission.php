<?php
class Simm_Mission {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_mission');
		return $query->execute();

	}
}