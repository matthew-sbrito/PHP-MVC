<?php 

namespace App\Http\Middleware;

class AuthenticatedAdmin {

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
    }elseif(!$user->IS_ADMIN){
      throw new \Exception('Você não é um administrador',200);
    }
    return $next($request);
  }
}