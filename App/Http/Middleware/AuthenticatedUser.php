<?php 

namespace App\Http\Middleware;

use App\Utils\Messages;

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
      // Messages::setError('Você precisa está logado para acessar essa página', 'login');
      throw new \Exception('Você precisa está logado para acessar essa página',401);
    }
    return $next($request);
  }
}