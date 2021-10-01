<?php 

namespace App\Session;

use App\Utils\Messages;

class Session{

  public static function setUser($user){
    $_SESSION['user'] = serialize($user);
  }
  
  public static function getUser(){
    return $_SESSION['user'] ? unserialize($_SESSION['user']) : null;
  }

  public static function logout(){

    unset($_SESSION['user']);
    Messages::setSuccess('Você foi deslogado!');

  }

}