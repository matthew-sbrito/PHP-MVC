<?php
 
namespace App\Models;
use App\Models\Entity\User as EntityUser;
use App\Database\Database;

class UsersRepository {

    public $cod;
    public $nome;
    public $email;
    public $senha;
    public $sexo;
    public $nascimento;

    public static function getAllUsers($where = null,$order = null, $limit = null){
      $dbUsers = (new Database('USUARIO'))->selectCustom($where,$order,$limit);

      while($entityUser = $dbUsers->fetchObject(EntityUser::class)){
        $users[] = $entityUser;
      }
      return $users;
    }

    public static function getQuantityUsers($where = null){
      return (new Database('USUARIO'))->selectCustom($where,null,null,'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
    public static function getUserByEmail($email){
      return (new Database('USUARIO'))->selectCustom("EMAIL = '${email}'")->fetchObject(EntityUser::class);
    }
    public static function getUserById($id){
      return (new Database('USUARIO'))->selectCustom("COD = '${id}'")->fetchObject(EntityUser::class);
    }
}
