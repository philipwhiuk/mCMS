<?php

/**
 * Default Theme - HTML - jQuery Inclusion
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_jQuery extends Template {

  function Display(){
  foreach($this->files as $file){
?>
<script src="<?php echo $file; ?>" type="text/javascript" language="javascript"></script>
<?php
  }
  }
  
  
}
