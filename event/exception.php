<?php

class Event_Exception extends MCMS_Exception {}

class Event_Not_Found_Exception extends Event_Exception {}

class Event_Item_Exception extends Event_Exception{}

class Event_Item_Not_Found_Exception extends Event_Item_Exception {}

class Event_Page_Unavailable_Exception extends Event_Exception {}

class Event_Page_Block_Unavailable_Exception extends Event_Exception {}

?>