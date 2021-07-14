<?php

namespace App\Utils;

class Messages {
  
  public static function setError($msg, $page = null){

      $_SESSION['message'] = ['danger' => $msg];
      if($page != null){
        header('Location: /'. $page);
        exit;
      }
  }

  public static function setSuccess($msg, $page = null){
  
    $_SESSION['message'] = ['success' => $msg];
    if($page != null){
      header('Location: /'. $page);
      exit;
    }
  }

  public static function getMessage(){

    $msg = $_SESSION['message'];
    $keyMsg = array_keys($msg);
    unset($_SESSION['message']);
    
    if(empty($msg)) return '';
    
    return View::render('Messages/Message',[
      'type' => $keyMsg[0],
      'textMessage' => $msg[$keyMsg[0]]
    ]);
  }
}