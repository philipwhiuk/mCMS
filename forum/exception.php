<?php
class Forum_Exception extends MCMS_Exception {}
class Forum_Not_Found_Exception extends Forum_Exception {
protected $level = MCMS::dump_notice;
}
class Forum_Unavailable_Exception extends Forum_Exception {}
class Forum_Page_Main_Exception extends Forum_Exception {}
class Forum_Topic_Exception extends Forum_Exception {}
class Forum_Topic_Not_Found_Exception extends Forum_Exception {}
class Forum_Topic_Unavailable_Exception extends Forum_Exception {}
