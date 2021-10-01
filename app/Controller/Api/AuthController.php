<?php

namespace App\Controller\Api;

use App\Repositories\UserRepository;
use App\Models\Entity\User;
use Firebase\JWT\JWT;
use App\Utils\Api;

class AuthController extends Api {
  /**
   * Método responsável por gerar token JWT
   * @param Request $request
   * @return array
   */
  public static function generateToken($request) {
    $request->postRequired([
      'EMAIL', 'PASSWORD'
    ]);
    $post = $request->getPostVars();

    $user = (new UserRepository)->findByEmail($post->EMAIL);

    if(!$user instanceof User) throw new \Exception("Email ou senha são invalidos",400);
    
    if(!password_verify($post->PASSWORD, $user->SENHA)) {
      throw new \Exception("Email ou senha são invalidos",400);
    }
    $payload = [
      'EMAIL' => $post->EMAIL,
      'PASSWORD' => $post->PASSWORD,  
    ];
    return [
      'token' => JWT::encode($payload,getenv('JWT_KEY'))
    ];
  }
}