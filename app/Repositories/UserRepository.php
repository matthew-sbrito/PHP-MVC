<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Database\Database;

class UserRepository extends Repository implements IRepository {

  /**
   * Instância do banco de dados para realização do CRUD.
   * @var Database
   */
  protected $database;

  /**
   * Chave primária da tabela da instância atual.
   * @var string
   */
  protected $id;

  /**
   * Váriavel responsável por guardar class do model atual.
   * @var User
   */
  protected $model;

  public function __construct(){
    $this->id       = "COD";
    $this->model    = User::class;  
    $this->database = new Database("USUARIO");
  }
  public function findByEmail($email){
    $where = "EMAIL = ${email}";

    $statement = $this->database->select($where);

    return $statement->fetchObject($this->model);
  }
}