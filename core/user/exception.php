<?php

class User_Exception extends MCMS_Exception {}

class User_Key_Not_Found_Exception extends User_Exception {}

class User_Not_Found_Exception extends User_Exception {
protected $level = MCMS::dump_notice;
}
