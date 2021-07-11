<?php 

namespace App\Utils;
use App\Models\UsersRepository;

class Session{

  public static function validateAdmin(){
    $user = $_SESSION['user'];
    $authenticated = $user && $user->IS_ADMIN;

    if(!$authenticated){
      header('Location: /home');
    }
  }

}