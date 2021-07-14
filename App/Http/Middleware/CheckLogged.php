<?php 

namespace App\Http\Middleware;

use App\Utils\Messages;
use App\Session\Session;

class CheckLogged {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){
    $user = Session::isLogged();
    if($user){
      Messages::setError('Você já está logado', 'about');
      // throw new \Exception('Você precisa está logado para acessar essa página',401);
    }
    return $next($request);
  }
}