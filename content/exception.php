<?php

class Content_Exception extends CMS_Exception {} 

class Content_Not_Found_Exception extends Content_Exception {}

class Content_Page_Exception extends Content_Exception {}

class Content_Page_Unavailable_Exception extends Content_Page_Exception {}

class Content_Page_Block_Exception extends Content_Exception {}

class Content_Page_Block_Unavailable_Exception extends Content_Page_Block_Exception {}