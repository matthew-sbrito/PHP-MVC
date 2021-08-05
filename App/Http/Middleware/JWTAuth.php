<?php 

namespace App\Http\Middleware;
use App\Models\UsersRepository;
use App\Models\Entity\User;
use Firebase\JWT\JWT;

class JWTAuth {

  /**
   * Método resposável por executar o middleware
   * @param   Request  
   * @param   Closure  next
   * @return  Response 
   */
  public function handle($request, $next){

    $this->auth($request);
    
    return $next($request);
  }

  private function auth($request){
    if($user = $this->getJWTAuthUser($request)){
      $request->user = $user;
      return true;
    }
    throw new \Exception("Acesso negado!", 403);
  }

  private function getJWTAuthUser($request){
    
    $headers = $request->getHeaders();
    
    $jwt = isset($headers['Authorization']) ? str_replace('Bearer ','',$headers['Authorization']) : '';
    
    try {
      $decoded = (array)JWT::decode($jwt, getenv('JWT_KEY'),['HS256']);
    } catch (\Exception $e) {
      throw new \Exception('Invalid token, Unauthorized');
    }

    $user = UsersRepository::getUserByEmail($decoded['EMAIL']);
    
    if(!$user instanceof User) throw new \Exception("Invalid token, Unauthorized",400);
  
    if(!password_verify($decoded['PASSWORD'], $user->SENHA)) {
      throw new \Exception("Invalid token, Unauthorized!",400);
    }
    return $user;
  }
}