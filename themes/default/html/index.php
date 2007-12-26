<?php	

/**
 * Default Theme - HTML - Index
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Index extends Template {

  function Display(){
    header('Content-type: text/html; charset=UTF-8');
  ?>
<html>
  <head>
<? 
      foreach($this->head as $head){
        
    ?>
      <? $head->Display(); ?>
    <?  
      }
?>
  </head>
  <body>
<? 
      $this->main->Display();
?> 
  </body>
</html>
<?
  }
}
