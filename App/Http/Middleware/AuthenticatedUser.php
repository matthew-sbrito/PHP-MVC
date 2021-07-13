<?php 

namespace App\Http\Middleware;

class AuthenticatedUser {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){
    $user = $_SESSION['user'] ?? $_SESSION['usuario'];
    if(empty($user)){
      throw new \Exception('Você precisa está logado para acessar essa página',200);
    }
    return $next($request);
  }
}