<?php

class Form_Exception extends MCMS_Exception {}
class Form_Field_Exception extends Form_Exception {}

class Form_Invalid_Field_Exception extends Form_Exception {}
class Form_Incomplete_Exception extends Form_Exception {
	protected $level = MCMS::dump_notice;
}

class Form_Field_Invalid_Exception extends Form_Field_Exception {}
class Form_Field_Not_Found_Exception extends Form_Field_Exception {}
