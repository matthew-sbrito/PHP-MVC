<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Models\UsersRepository;

class LoginController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getViewLogin($request){
        $content = View::render('Admin/Login',[

        ]); 
        return parent::getPage('Login',$content);
    }
    

    public static function authenticatedLogin($request){

      $post = $request->getPostVars();
      $user = UsersRepository::login($post['email'], $post['senha']);
      $_SESSION['user'] = $user;
      header('Location: /home');
    }
  }
    