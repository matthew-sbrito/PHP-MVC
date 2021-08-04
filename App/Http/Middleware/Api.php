<?php 

namespace App\Http\Middleware;

class Api {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){

    $request->getRouter()->setContentType('application/json');
    
    return $next($request);
  }
}