<?php
define('MCMS',true);
require_once(rtrim(str_replace('\\', '/', dirname(__FILE__)),'/') . '/mcms.php');
define('MCMS_DEBUG',true);
define('MCMS_DEBUG_LEVEL',MCMS::dump_warning);
//define('MCMS_DEBUG_TYPE',MCMS::dump_screen);
define('MCMS_TOP_LEVEL_THEME',0);
define('MCMS_NOT_PACKAGED',0);
if(file_exists(MCMS::dirname(__FILE__) . '/index.local.php')){
  require_once(MCMS::dirname(__FILE__) . '/index.local.php');
}
MCMS::Get_Instance()->run();