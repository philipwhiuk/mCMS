<?php

class Login_Exception extends CMS_Exception {}

class Login_Incomplete_Exception extends Login_Exception {
	protected $level = System::dump_warning;
}

class Login_Page_Exception extends Login_Exception {}

class Login_Page_Unavailable_Exception extends Login_Page_Exception {}

class Login_Not_Found_Exception extends Login_Exception {}
