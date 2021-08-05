<?php
 
namespace App\Models;
use App\Models\Entity\User;
use App\Database\Database;

class UsersRepository {

    public static function getAllUsers($where = null, $order = 'COD DESC ', $limit = null){
      $dbUsers = (new Database('USUARIO'))->selectCustom($where,$order,$limit);
      while($user = $dbUsers->fetchObject(User::class)){
        $users[] = $user;
      }
      return $users;
    }

    public static function getQuantityUsers($where = null){
      return (new Database('USUARIO'))->selectCustom($where,null,null,'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
    public static function getUserByEmail($email){
      return (new Database('USUARIO'))->selectCustom("EMAIL = '${email}'")->fetchObject(User::class);
    }
    public static function getUserById($id){
      return (new Database('USUARIO'))->selectCustom("COD = '${id}'")->fetchObject(User::class);
    }
    
    public static function insert(array $user){
      return (new Database('USUARIO'))->insert($user);
    }
    
    public static function update(array $user, int $id){
      return (new Database('USUARIO'))->update("COD = ${id}",$user);
    }
    
    public static function delete(int $id){
      return (new Database('USUARIO'))->delete("COD = ${id}");
    }
}
