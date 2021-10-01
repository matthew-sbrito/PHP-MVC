<?php
namespace App\Controller\Pages;

use App\Utils\View;
use App\Utils\RenderPage;
use App\Models\Entity\User as EntityUser;
use App\Repositories\UserRepository;

class AboutController extends RenderPage{

    private static function getUsersView(){
        
        $users = (new UserRepository)->find();
        $content = '';
        foreach($users as $user){
           $content .= View::render('about/users',[
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
        
        $content = View::render('about/main', [
            'name' => 'Matheus Brito',
            'age' => 19,
            'users' => $users
        ]);
        
        return parent::getPage('About', $content, true);
    }
}