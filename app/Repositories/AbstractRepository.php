<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Database\Database;

abstract class AbstractRepository implements IRepository {

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
   * @var class
   */
  protected $model;

  public function find($where = null, $order = null, $limit = null, $fields = '*'){
    $statement = $this->database->select($where, $order, $limit, $fields);
    while($entity = $statement->fetchObject($this->model)){
      $entities[] = $entity;
    }
    return $entities;
  }
  public function count($where = null){
    $statement = $this->database->select($where, null, null, 'count(*) as QTD');
    return $statement->fetchObject()->QTD;
  }
  public function findOne($id){
    $where = "$this->id = $id";
    $statement = $this->database->select($where);
    return $statement->fetchObject($this->model);
  }
  public function create($model){
    $id = $this->database->insert($model, $this->id);
    return $this->findOne($id);
  }
  public function update($model, $id){
    $where = "$this->id = $id";
    return $this->database->update($where, $model);
  }
  public function destroy($id){
    $where = "$this->id = $id";
    return $this->database->delete($where);
  }
}