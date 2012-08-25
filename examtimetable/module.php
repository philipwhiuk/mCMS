<?php
class ExamTimetable_Module extends Module {
	public function load() {
		Module::Get('content');
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('room','booking','round','semester','session','building','department','course',
					'location','period','exception','year'
					'booking_room','booking_room_week_day_period'
					'booking_status','round_status'
					);

		try {
			Module::Get('admin');
			Admin::Register('examtimetable','ExamTimetable_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
}