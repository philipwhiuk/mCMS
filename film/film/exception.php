<?php

class Film_Exception extends MCMS_Exception {} 

class Film_Genre_Exception extends Film_Exception {}

class Film_Genre_Not_Found_Exception extends Film_Genre_Exception {}

class Film_Language_Exception extends Film_Exception {}

class Film_Language_Not_Found_Exception extends Film_Language_Exception {}

class Film_Trailer_Exception extends Film_Exception {}

class Film_Trailer_Not_Found_Exception extends Film_Trailer_Exception {}

class Film_Tagline_Exception extends Film_Exception {}

class Film_Tagline_Not_Found_Exception extends Film_Tagline_Exception {}

class Film_Not_Found_Exception extends Film_Exception {}

class Film_Page_Exception extends Film_Exception {}

class Film_Page_Unavailable_Exception extends Film_Page_Exception {}

class Film_Genre_Page_Exception extends Film_Page_Exception {}

class Film_Genre_Page_Unavailable_Exception extends Film_Page_Exception {}