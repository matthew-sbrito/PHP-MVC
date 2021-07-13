<?php

namespace App\Http\Middleware;

class Queue
{

  /**
   * Mapeamento de middlewares
   * @var array
   */
  private static $map = [];

  /**
   * Mapeamento de middlewares para todas rotas
   * @var array
   */
  private static $default = [];

  /**
   * Fila de middleware a serem executados
   * @var array
   */
  private $middlewares = [];

  /**
   * Função de execução do controller
   * @var Closure
   */
  private $controller;

  /**
   *  Argumentos da função do controller
   * @var array
   */
  private $controllerArgs = [];

  /**
   * Método para construção do middleware
   *
   * @param   array   $middlewares      
   * @param   Closure $controller     
   * @param   array   $controllerArgs  
   */
  public function __construct($middlewares, $controller, $controllerArgs)
  {
    $this->middlewares = array_merge(self::$default, $this->middlewares);
    $this->controller = $controller;
    $this->controllerArgs = $controllerArgs;
  }

  /**
   * Método responsavel por setar o mapa de middlewares
   * @param array 
   */
  public static function setMap($map)
  {
    self::$map = $map;
  }
 
  /**
   * Método responsavel por setar o mapa de middlewares
   * @param array 
   */
  public static function setDefault($default)
  {
    self::$default = $default;
  }


  /**
   * Método responsavel por executar os middlewares e controllers
   * @param   Request  
   * @return  Response
   */
  public function next($request)
  {
    //VERIFICA SE A FILA DE MIDDLEWARES ESTÁ VAZIA
    if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

    //MIDDLEWARE
    $middleware = array_shift($this->middlewares);

    if (!isset(self::$map[$middleware])) {
      throw new \Exception('Problemas ao processar o middleware', 500);
    }

    //NEXT
    $queue = $this;
    $next  = function ($request) use ($queue) {
      return $queue->next($request);
    };
    //EXECUTA O MIDDLEWARE
    return (new self::$map[$middleware])->handle($request, $next);
  }
}
