<?php
class QuizManager_Module extends Module {
	public function load() {
		Module::Get('content');
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('quiz','question','answer','student','session','building','department','course',
					'feature','location','period','exception','year'
					'room_feature',
					'booking_room','booking_room_day','booking_room_feature','booking_room_period','booking_room_week',
					'booking_status','round_status'
					);
		try {
			Module::Get('admin');
			Admin::Register('roomtimetable','RoomTimetable_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
}