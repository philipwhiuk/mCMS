<?php

/**
 * Locale API File
 *
 * Subversion ID: $Id$
**/

// This file controles localisation

class Locale {

  static function Load(){
    $sql = "SELECT * FROM locale WHERE id = %u";
    $result = Fusion::$_->storage->query($sql, Fusion::$_->user->locale);
    if($result && $row = $result->fetch_assoc()){
      $c = 'Locale_' . $row['type'];
      Log::Message("{$row['name']} ({$row['type']}) locale loaded.");
      return new $c($row);
    }
    Install::Locale();
  }

}

class Locale_File extends Locale {

  


}
