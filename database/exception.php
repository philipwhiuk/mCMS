<?php
class Database_Exception extends MCMS_Exception {}
class Database_Configuration_Exception extends Database_Exception {}
class Database_Driver_Exception extends Database_Exception {}
class Database_Driver_Configuration_Exception extends Database_Driver_Exception {}
class Database_Driver_Not_Found_Exception extends Database_Driver_Exception {}
class Database_Driver_Invalid_Exception extends Database_Driver_Exception {}