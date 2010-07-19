<?php
class Profile_Module_Exception extends CMS_Exception {}

class Profile_Page_Exception extends Profile_Module_Exception {}
class Profile_Page_Unavailable_Exception extends Profile_Page_Exception {}

class Profile_User_Page_Exception extends Profile_Module_Exception {}
class Profile_User_Page_Not_Found_Exception extends Profile_User_Page_Exception {}

class Profile_Exception extends Profile_Module_Exception{}
class Profile_Not_Found_Exception extends Profile_Exception{}

class Profile_Field_Exception extends Profile_Module_Exception {}
class Profile_Field_Unavailable_Exception extends Profile_Field_Exception {}

class Profile_Field_Textbox_Exception extends Profile_Module_Exception {}
class Profile_Field_Textbox_Not_Found_Exception extends Profile_Field_Textbox_Exception {}
