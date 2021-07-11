<?php

namespace App\Models;

class UsersRepository {
    public static function getAllUsers(){
      
      $json = realpath(dirname(__FILE__,3). '/data/data.json');
      $result = json_decode(file_get_contents($json));

      return $result->Dados ? $result->Dados : $result->Message;
    }

    public static function getOneUser(string $email){



    }
}
