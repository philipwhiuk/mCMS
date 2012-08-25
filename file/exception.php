<?php

class File_Exception extends MCMS_Exception {}

class File_Not_Found_Exception extends File_Exception {}

class File_Page_Exception extends File_Exception {}

class File_Page_Unavailable_Exception extends File_Page_Exception {}