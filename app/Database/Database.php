<?php

namespace App\Database;

use Exception;
use \PDO;
use \PDOException;

class Database{

  /**
   * Host de conexão com o banco de dados
   * @var string
   */
  private static $host;

  /**
   * Nome do banco de dados
   * @var string
   */
  private static $name;

  /**
   * Usuário do banco
   * @var string
   */
  private static $user;

  /**
   * Senha de acesso ao banco de dados
   * @var string
   */
  private static $pass;

  /**
   * Porta de acesso ao banco
   * @var integer
   */
  private static $port;

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $table;

  /**
   * Instancia de conexão com o banco de dados
   * @var PDO
   */
  private $connection;

  /**
   * Método responsável por configurar a classe
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   */
  public static function config($host,$name,$user,$pass,$port = 3306){
    self::$host = $host;
    self::$name = $name;
    self::$user = $user;
    self::$pass = $pass;
    self::$port = $port;
  }

  /**
   * Define a tabela e instancia e conexão
   * @param string $table
   */
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){
    try{
      $this->connection = new PDO('mysql:dbname='.self::$name.';charset=utf8;dialect=3',self::$user,self::$pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      switch($e->getCode()) {
        case 23000:
          throw new \Exception('Dados já existentes!');
        default:
          die('ERROR: '.$e->getMessage());
      }
    }
  }

   /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function executeSelect($query,$params = []){
    $params = self::getValuesOfObjects($params);    
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
    
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $result;

    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values){
    
    $values = self::getValuesOfObjects($values);
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    //MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    // return $query;
    //EXECUTA O INSERT
    $result = $this->execute($query,array_values($values));

    // RETORNA MENSAGEM  
    if($result->rowCount() > 0){
        return true;
    }

  }

  public function findRelations($where = null, $join = null,$order = null, $limit = null, $fields = '*'){
    //DADOS DA QUERY
    $where = strlen($where) ? 'WHERE '.$where : '';
    $join = strlen($join) ? 'LEFT JOIN '.$join : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    //MONTA A QUERY
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '. $join .' '.$where.' '.$order.' '.$limit;
    // return $query;

    //EXECUTA A QUERY
    $result = $this->execute($query);
    while($finalResult = $result->fetchAll(PDO::FETCH_ASSOC)){
        return $finalResult;
    }
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */

   
  public function select($where = null, $order = null, $limit = null, $fields = '*'){
    
    //DADOS DA QUERY
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    //MONTA A QUERY
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
    // return $query;
    
    //EXECUTA A QUERY
    return $this->execute($query);

  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    $values = self::getValuesOfObjects($values);
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    // return $query;

    //EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
  }
  private static function getValuesOfObjects($object){
    if(!is_object($object)) return $object;
    foreach($object as $key => $value){
      $array[$key] = $value;
    }
    return $array;
  }

}