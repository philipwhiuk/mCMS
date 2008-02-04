<?php

/**
 * Default Theme - HTML - TinyMCE Inclusion
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_TinyMCE extends Template {

  function Display(){
?>
  <script type="text/javascript" src="<? echo $this->file; ?>"></script>
  <script type="text/javascript">
  tinyMCE_GZ.init({
    themes : 'advanced',
    languages : 'en',
    plugins: 'advimage,advlink,autosave,contextmenu,media,inlinepopups,searchreplace,save,table',
    disk_cache : true,
    debug : false
  });
  </script>
  <!-- Needs to be seperate script tags! -->
  <script type="text/javascript">
  tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    plugins: 'advimage,advlink,autosave,contextmenu,media,inlinepopups,searchreplace,save,table',
    theme_advanced_toolbar_location : "top",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_path : false,
    theme_advanced_buttons1: "newdocument,save,separator,cut,copy,paste,separator,undo,redo,separator,search,replace,separator,link,unlink,anchor, sepeator,image,media,separator,cleanup,code,help,separator,tablecontrols,separator,charmap,visualaid,blockquote",
    theme_advanced_buttons2: "styleselect,formatselect,fontselect,fontsizeselect,removeformat,separator,bold,italic,underline,strikethrough,separator,sub,sup,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,outdent,indent,separator,forecolor,backcolor",
    theme_advanced_buttons3: "",
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false
  });
  </script>
  <?php
  }
  
  
}
