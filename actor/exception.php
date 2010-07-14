<?php
class Actor_Exception extends CMS_Exception {}
class Actor_Not_Found_Exception extends Actor_Exception {}
class Actor_Page_Exception extends Actor_Exception {}
class Actor_Page_Not_Found_Exception extends Actor_Page_Exception {}
class Actor_Page_Unavailable_Exception extends Actor_Page_Exception {}