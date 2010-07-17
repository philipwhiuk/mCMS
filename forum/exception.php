<?php
class Forum_Module_Exception extends CMS_Exception {}
class Forum_Exception extends Forum_Module_Exception {}
class Forum_Not_Found_Exception extends Forum_Exception {}
class Forum_Unavailable_Exception extends Forum_Exception {}