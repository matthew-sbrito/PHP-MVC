<?php
namespace App\Controller\Pages;

use App\Models;

class About extends Page{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getAbout(){ 
              
        $arr = Models\Home::getData();
        
        return parent::getPageTemplate('Pages/About', ['dados' => $arr]);
    }
}