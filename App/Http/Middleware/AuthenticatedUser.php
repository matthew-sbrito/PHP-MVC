<?php 

namespace App\Http\Middleware;

use App\Session\Session;
use App\Utils\Messages;

class AuthenticatedUser {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){
    $user = Session::getUser();
   
    if(empty($user)){
      Messages::setError('Você precisa está logado para acessar essa página');
      $request->getRouter()->redirect('/admin/login');
    }

    return $next($request);
  }
}