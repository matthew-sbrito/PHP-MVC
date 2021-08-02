<?php
 
namespace App\Models\Entity;

class User {

    public int $COD;
    public string $NOME;
    public string $EMAIL;
    protected string $SENHA;
    public string $SEXO;
    public string $NASCIMENTO;
    protected int $IS_ADMIN;

    public static $columns = [
     'COD',
     'NOME',
     'EMAIL',
     'SENHA',
     'SEXO',
     'NASCIMENTO',
     'IS_ADMIN'
    ];

    public function __construct(){
      // $this->fomartDate();
    }

    public function __get($value){
      return $this->$value;
    }

    public function fomartDate(){
      $this->NASCIMENTO = date('d/m/Y',strtotime($this->NASCIMENTO));
    }

}