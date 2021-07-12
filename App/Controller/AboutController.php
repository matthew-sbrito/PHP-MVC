<?php
namespace App\Controller;

use App\Models\UsersRepository;
use App\Utils\View;
use App\Utils\RenderPage;

class AboutController extends RenderPage{

    private static function getUsersView(){
        $users = UsersRepository::getAllUsers();
        $content = '';
        foreach($users as $user){
           $content .= View::render('Pages/About/Users',[
                'name' => $user->NOME,
                'age' => date('d/m/Y', strtotime($user->NASCIMENTO)),
            ]);
        }
        return $content;
    }

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getAbout(){ 
              
        $users = self::getUsersView();
        
        $content = View::render('Pages/About/Main', [
            'name' => 'Matheus Brito',
            'age' => 19,
            'users' => $users
        ]);
        
        return parent::getPage('About', $content, true);
    }
}