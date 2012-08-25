<?php
class Film_Film_Feature_Impl_Event_Impl_Page_Main_View extends Film_Feature_Impl_Event_Impl_Page_Main_View  {
	public function __construct($film) {
	}
	public function display() {
		$this->system = MCMS::Get_Instance();
		$module = Module::Get('film');
		$language = Language::Retrieve();
		$template = $this->system->output()->start(array('film', 'film_feature','event','page','main','view'));	
	}
}