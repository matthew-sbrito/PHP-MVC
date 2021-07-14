<?php
 
namespace App\Models;
use App\Database\Database;
use App\Utils\Messages;

class UsersRepository {

    public $cod;
    public $nome;
    public $email;
    public $senha;
    public $sexo;
    public $nascimento;

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
      $user = (new Database('USUARIO'))->selectCustom("EMAIL = '${username}'")->fetchObject();
      if(is_object($user)){
        if(password_verify($password, $user->SENHA)){
          return $user;
        }else{
          Messages::setError('Dados Incorretos', 'admin/login');
        }
      }else{
        Messages::setError('Usuário inexistente', 'admin/login');
      }
    }
}
