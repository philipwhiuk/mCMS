<?php

class Language_Exception extends CMS_Exception {}

class Language_Unavailable_Exception extends Language_Exception {}

class Language_File_Not_Found_Exception extends Language_Exception {}

class Language_Translation_Not_Found_Exception extends Language_Exception {}