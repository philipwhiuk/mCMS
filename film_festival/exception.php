<?php

class Film_Festival_Exception extends CMS_Exception {} 

class Film_Festival_Not_Found_Exception extends Film_Festival_Exception {}

class Film_Festival_Page_Exception extends Film_Festival_Exception {}

class Film_Festival_Page_Unavailable_Exception extends Film_Festival_Page_Exception {}