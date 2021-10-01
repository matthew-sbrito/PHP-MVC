<?php 

namespace App\Http\Middleware;

class Maintenance {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){

    if(getenv('MAINTENANCE') == 'true'){
      throw new \Exception('Página em manutenção',200);
    }
    return $next($request);
  }
}