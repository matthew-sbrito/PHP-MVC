<?php 

namespace App\Controller\Admin;
use App\Utils\View;

class RenderPage {
  /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getPage($title,$content){ 
      return View::render('Admin/Page', [
          'title' => $title,
          'content' => $content,
      ]);      
  }
}
