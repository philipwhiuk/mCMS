<?php	

/**
 * Default Theme - HTML - Index
 *
 * @version $Id:$
 * @package Fusion
 * @subpackage default_html_theme
**/

/**
 * Index Template
 *
 * This class is responsible for rendering all pages.
 *
 * It simply renders the core html and the head section.
 *
 * It then passes the rest of to assigned templates.
 * @package Fusion
 * @subpackage default_html_theme
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
