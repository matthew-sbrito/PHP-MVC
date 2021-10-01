<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Messages;
use App\Session\Session;
use App\Models\Entity\User;
use App\Repositories\UserRepository;

class LoginController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getViewLogin($request){
      
      $message = Messages::getMessage() ?? '';
      $content = View::render('admin/login',[
          'message' => $message,
        ]); 
      
      return parent::getPage('Login',$content);
    }
    

    public static function authenticatedLogin($request){
      $post = $request->getPostVars([
        'email',
        'senha'
      ]);
    
      $user = (new UserRepository)->findByEmail($post->EMAIL);

      if($user instanceof User){
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
    