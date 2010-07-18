<?php
class Topic_Exception extends CMS_Exception {}
class Topic_Not_Found_Exception extends Topic_Exception {}
class Topic_Unavailable_Exception extends Topic_Exception {}
class Topic_Post_Exception extends Topic_Exception {}
class Topic_Post_Not_Found_Exception extends Topic_Post_Exception {}
class Topic_Post_Unavailable_Exception extends Topic_Post_Exception {}