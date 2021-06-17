<?php
namespace App\Controller\Pages;

use App\Utils\View;

class Page{
    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getPageTemplate($view, $params = []){
        View::renderTemplate($view, $params);
    }
    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getPage($view, $params = []){
        View::render($view, $params);
    }
}