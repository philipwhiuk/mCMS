<?php
class Admin_Dashboard_Statistics extends Admin_Dashboard {
	public function __construct($a,$b){
		parent::__construct($a,$b);
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','statistics'));
		return $template;
	}
}