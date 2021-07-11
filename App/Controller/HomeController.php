<?php
namespace App\Controller;

use App\Models\HomeRepository;
use App\Utils\View;
use App\Utils\RenderPage;

class HomeController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome(){ 
              
        $arr = HomeRepository::getData();
      
        $content = View::render('Pages/Home/Main', [
            'dados' => $arr,
        ]);
        
        return parent::getPage('Home', $content, true);
     
    }
}