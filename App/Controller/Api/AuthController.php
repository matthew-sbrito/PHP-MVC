<?php

namespace App\Controller\Api;

use App\Models\UsersRepository;
use App\Models\Entity\User;
use App\Utils\Api;
use Firebase\JWT\JWT;

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

    $user = UsersRepository::getUserByEmail($post->EMAIL);

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