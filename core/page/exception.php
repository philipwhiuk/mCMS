<?php

class Page_Exception extends MCMS_Exception {}
class Page_Main_Exception extends Page_Exception {}
class Page_Main_Invalid_Exception extends Page_Main_Exception {}
class Page_Main_Resource_Not_Found_Exception extends Page_Main_Exception {}
class Page_Fatal_Exception extends Page_Exception {}