<?php

class Permission_Exception extends CMS_Exception {}
class Permission_Unauthorised_Exception extends Permission_Exception {}

class Permission_User_Exception extends Permission_Exception {}
class Permission_User_Not_Found_Exception extends Permission_User_Exception {}

class Permission_Group_Exception extends Permission_Exception {}
class Permission_Group_Not_Found_Exception extends Permission_Group_Exception {}