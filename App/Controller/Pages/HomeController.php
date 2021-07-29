<?php
namespace App\Controller\Pages;

use App\Utils\View;
use App\Utils\RenderPage;
use App\Utils\Pagination;
use App\Models\UsersRepository;

class HomeController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome($request){ 
        

        $content = View::render('Home/Main',[]);
        

        $array = [5,2,4,6,1,3];
        echo'<hr>';
        sort($array);
        echo implode(' ',$array); 
        echo'<hr>';
        rsort($array);
        echo implode(' ',$array);
      


        exit;
        
        return parent::getPage('Home', $content, true);
     
    }

    public static function goHome(){
        header('Location: /home');
        exit;
    }
}