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
}
