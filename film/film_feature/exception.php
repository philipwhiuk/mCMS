<?php

class Film_Feature_Exception extends MCMS_Exception {} 

class Film_Feature_Not_Found_Exception extends Film_Feature_Exception {}

class Film_Feature_Page_Exception extends Film_Feature_Exception {}

class Film_Feature_Page_Unavailable_Exception extends Film_Feature_Page_Exception {}

class Film_Feature_Category_Exception extends Film_Feature_Exception {}

class Film_Feature_Category_Not_Found_Exception extends Film_Feature_Exception {}

class Film_Feature_Showing_Group_Exception extends Film_Feature_Exception {}

class Film_Feature_Showing_Group_Not_Found_Exception extends Film_Feature_Showing_Group_Exception {}

class Film_Feature_Page_Block_Unavailable_Exception extends Film_Feature_Exception{}