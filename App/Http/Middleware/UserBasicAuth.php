<?php 

namespace App\Http\Middleware;
use App\Models\UsersRepository;
use App\Models\Entity\User;

class UserBasicAuth {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){

    $this->basicAuth($request);
    
    return $next($request);
  }

  private function basicAuth($request){
    if($user = $this->getBasicAuthUser()){
      $request->user = $user;
      return true;
    }
    throw new \Exception("Usuário ou senha inválidos!", 403);
  }

  private function getBasicAuthUser(){
    if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])){
      return false;
    }

    $user = UsersRepository::getUserByEmail($_SERVER['PHP_AUTH_USER']);
    if(!$user instanceof User){
      return false;
    }

    return password_verify($_SERVER['PHP_AUTH_PW'], $user->SENHA) ? $user : false;

  }
}