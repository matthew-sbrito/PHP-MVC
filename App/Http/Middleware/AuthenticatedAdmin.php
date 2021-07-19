<?php 

namespace App\Http\Middleware;

use App\Utils\Messages;
use App\Session\Session;

class AuthenticatedAdmin {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){
    $user = Session::getUser();
   
    if(empty($user)){
      Messages::setError('Você precisa está logado para acessar essa página!', 'about');
    }elseif(!$user->IS_ADMIN){
      Messages::setError('Você não é um administrador!', 'about');
    }
    
    return $next($request);
  }
}