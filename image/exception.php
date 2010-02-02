<?php

class Image_Exception extends CMS_Exception {}

class Image_Page_Exception extends Image_Exception {}

class Image_Page_Unavailable_Exception extends Image_Page_Exception {}

class Image_Not_Found_Exception extends Image_Exception {}
