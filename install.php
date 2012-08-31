<?php
class Install {
	public static function Load() {
		$exceptions = array();
		MCMS::Get_Instance()->file('install/start');
		return new Install_Start();
	}
}
