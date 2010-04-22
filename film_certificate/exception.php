<?php

class Film_Certificate_Exception extends CMS_Exception {} 

class Film_Certificate_Not_Found_Exception extends Film_Certificate_Exception {}

class Film_Certificate_Page_Exception extends Film_Certificate_Exception {}

class Film_Certificate_Page_Unavailable_Exception extends Film_Certificate_Page_Exception {}