<?php

class Database_MySQLi_Exception extends Database_Driver_Exception {}

class Database_MySQLi_Connect_Exception extends Database_MySQLi_Exception {
        public function message(){
                return "MySQL Failed to Connect: " . $this->data[0];
        }

        public function dump(){
		return "MySQL Failed to Connect. \r\n\t" . join("\n\t",explode("\n",$this->data[0]));
        }
}

class Database_MySQLi_Query_Exception extends Database_MySQLi_Exception {}

class Database_MySQLi_Query_Clause_Invalid_Exception extends Database_MySQLi_Exception {}

class Database_MySQLi_Select_Query_Exception extends Database_MySQLi_Query_Exception {}
class Database_MySQLi_Select_Invalid_Query_Exception extends Database_MySQLi_Select_Query_Exception {}

class Database_MySQLi_Insert_Query_Exception extends Database_MySQLi_Query_Exception {}
class Database_MySQLi_Insert_Invalid_Query_Exception extends Database_MySQLi_Insert_Query_Exception {}

class Database_MySQLi_Update_Query_Exception extends Database_MySQLi_Query_Exception {}
class Database_MySQLi_Update_Invalid_Query_Exception extends Database_MySQLi_Update_Query_Exception {}
