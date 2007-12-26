<?php

/**
 * Default Theme - HTML - CSS Inclusion
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_CSS extends Template {

  function Display(){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->file; ?>" />
<?php
  }
  
  
}
