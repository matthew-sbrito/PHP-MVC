<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Messages;
use App\Session\Session;
use App\Models\UsersRepository;

class LoginController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getViewLogin($request){
      
      $message = Messages::getMessage() ?? '';
      $content = View::render('Admin/Login',[
          'message' => $message,
        ]); 
      
      return parent::getPage('Login',$content);
    }
    

    public static function authenticatedLogin($request){

      $post = $request->getPostVars();
      $user = UsersRepository::login($post['email'], $post['senha']);
      if(is_object($user)){
        Session::setUser($user);
        Messages::setSuccess('Login efetuado!');
        $request->getRouter()->redirect('/about');
      }     
    }

    public static function logout($request){
      
      Session::logout();
      $request->getRouter()->redirect('/admin/login');
      
    }
  }
    