<?php
 
namespace App\Models\Entity;

use App\Models\UsersRepository;

class User extends Entity{

    public int $COD;
    public string $NOME;
    public string $EMAIL;
    protected string $SENHA;
    public string $SEXO;
    public string $NASCIMENTO;
    protected int $IS_ADMIN = 0;

    public static $columns = [
     'NOME',
     'EMAIL',
     'SENHA',
     'SEXO',
     'NASCIMENTO',
     'IS_ADMIN'
    ];
    public static $required = [
     'NOME',
     'EMAIL',
     'SENHA',
    ];

    public function __construct($values = null){
      if($values){
        parent::__construct($values);
      }
    }

    public function fomartDate(){
      $this->NASCIMENTO = date('d/m/Y',strtotime($this->NASCIMENTO));
    }

    public function cadastrar(){
      UsersRepository::insert([
        'NOME' => $this->NOME,
        'EMAIL' => $this->EMAIL,
        'SENHA' => password_hash($this->SENHA, PASSWORD_DEFAULT),
        'SEXO' => $this->SEXO,
        'NASCIMENTO' => $this->NASCIMENTO,
        'IS_ADMIN' => $this->IS_ADMIN
      ]);
      $user = UsersRepository::getUserByEmail($this->EMAIL);
      return $user;
    }
    public function update($values){
      foreach($values as $key => $value){
        $this->$key = $value;
      }
      $update = UsersRepository::update([
        'NOME' => $this->NOME,
        'EMAIL' => $this->EMAIL,
        'SEXO' => $this->SEXO,
        'NASCIMENTO' => $this->NASCIMENTO,
        'IS_ADMIN' => $this->IS_ADMIN
      ], $this->COD);
      
      if(!$update) throw new \Exception("Erro ao atualizar o cadastro!");
    }
    public function updatePassword(string $password){
      $password = password_hash($password, PASSWORD_DEFAULT);
      $this->SENHA = $password;
      $update = UsersRepository::update([
        'SENHA' => $this->SENHA,
      ], $this->COD);
      
      if(!$update) throw new \Exception("Erro ao atualizar a senha!");
    }
    
    public function delete(){
      
      return UsersRepository::delete($this->COD);
      
    }
}