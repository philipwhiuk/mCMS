<?php

class News_Exception extends MCMS_Exception {}

class News_Category_Exception extends News_Exception {}

class News_Category_Not_Found_Exception extends News_Category_Exception {}

class News_Page_Main_Exception extends News_Exception {}

class News_Page_Main_Unavailable_Exception extends News_Page_Main_Exception {}
