<?php

class Image_Exception extends CMS_Exception {}

class Image_Page_Exception extends Image_Exception {}

class Image_Page_Unavailable_Exception extends Image_Page_Exception {}

class Image_Not_Found_Exception extends Image_Exception {}

class Image_No_Files_Found_Exception extends Image_Exception {}

class Image_Resize_Exception extends Image_Exception {}

class Image_Resize_Open_Exception extends Image_Resize_Exception {}

class Image_Resize_Undefined_Exception extends Image_Resize_Exception {}
