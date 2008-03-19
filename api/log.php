<?php

class Log extends API  {

  static function Message($message){
    if(isset(Fusion::$_->log)){
      Fusion::$_->log->messages[] = $message;
    }
  }

}
