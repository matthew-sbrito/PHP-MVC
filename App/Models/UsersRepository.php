<?php
 
namespace App\Models;
use App\Database\Database;

class UsersRepository {
    public static function getAllUsers($where = null,$order = null, $limit = null){
      return (new Database('USUARIO'))->selectCustom($where,$order,$limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantityUsers($where = null){
      return (new Database('USUARIO'))->selectCustom($where,null,null,'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
    public static function login($username,$password){
      $user = (new Database('USUARIO'))->select("EMAIL = '${username}'");
      if($user){
        if(password_hash($user->password, $password)){
          return $user;
        }else{
          return 'Dados Incorretos';
        }
      }else{
        return 'Usuário inexistente';
      }
    }
}
