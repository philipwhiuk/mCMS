<?php
class Admin_Dashboard_Overview extends Admin_Dashboard {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->parent->resource()->get_module()->file('dashboard/overview/widget');
		$this->widgets = Admin_Dashboard_Overview_Widget::Create_All($this);
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','overview'));
		return $template;
	}
}