<?php

class Site_Exception extends MCMS_Exception {}
class Site_Configuration_Exception extends Site_Exception {}

class Site_Not_Found_Exception extends Site_Exception {}

class Site_Not_Unique_Exception extends Site_Exception {}

class Site_Key_Not_Found_Exception extends Site_Exception {}