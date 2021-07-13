<?php
namespace App\Controller\Admin;

use App\Utils\View;

class AdminController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getView($request){
        return parent::getPage('Login','asdasdaadsd');
    }
}