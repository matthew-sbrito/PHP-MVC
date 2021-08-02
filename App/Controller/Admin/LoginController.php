<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Messages;
use App\Session\Session;
use App\Models\UsersRepository;
use App\Models\Entity\User as EntityUser;

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
      $post = $request->getPostVars([
        'email',
        'senha'
      ]);
    
      $user = UsersRepository::getUserByEmail($post->EMAIL);

      if($user instanceof EntityUser){
        if(password_verify($post->SENHA, $user->SENHA)){
          Session::setUser($user);
          Messages::setSuccess('Login efetuado!'); 
          $request->getRouter()->redirect('/about');
        }else{
          Messages::setError('Dados Incorretos');
          $request->getRouter()->redirect('/admin/login');
        }
      }     
    }

    public static function logout($request){
      
      Session::logout();
      $request->getRouter()->redirect('/admin/login');
      
    }
  }
    