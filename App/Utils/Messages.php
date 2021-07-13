<?php

namespace App\Utils;

class Messages {
  
  public static function setError($msg, $page = null){

      $_SESSION['mensagem'] = ['error' => $msg];
      if($page != null){
        header('Location: /'. $page);
        exit;
      }
  }

  public static function setSuccess($msg, $page = null){
  
    $_SESSION['mensagem'] = ['sucesso' => $msg];
    if($page != null){
      header('Location: /'. $page);
      exit;
    }
  }

  public static function getMensage(){

    $msg = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
    return $msg;
  }
}