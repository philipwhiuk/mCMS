<?php	

/**
 * Default Theme - HTML - View Zone
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/edit.php');

class Template_Default_HTML_Zone_Edit_Zone extends Template_Default_HTML_Zone_Edit {

  function Display_Inner(){
    $this->form->display();
  }


}
