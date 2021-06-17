<?php
namespace App\Controller\Pages;

use App\Models\Home as ModelHome;

class Home extends Page{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome(){ 
              
        $arr = ModelHome::getData();
        
        return parent::getPageTemplate('Pages/Home', ['dados' => $arr]);
    }
}