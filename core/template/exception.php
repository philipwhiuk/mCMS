<?php

class Template_Exception extends MCMS_Exception {}
class Template_Invalid_Exception extends Template_Exception {
	protected $level = MCMS::dump_warning;
}
class Template_Not_Found_Exception extends Template_Exception {
	protected $level = MCMS::dump_notice;
}
