<?php
namespace App\Controller\Pages;

use App\Models\User;
use App\Utils\View;
use App\Utils\RenderPage;

class HomeController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome($request){   
        $content = View::render('home/main',[
            'users' => [
                new User('Matheus', 20),
                new User('Lucas', 21)
            ],
            'current' => 1 == 2,
        ]); 
        
        return parent::getPage('Home', $content, true);
     
    }

    public static function goHome(){
        header('Location: /home');
        exit;
    }
}