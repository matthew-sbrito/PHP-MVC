<?php 

namespace App\Controller\Admin;
use App\Utils\View;

class RenderPage {
    
    private static $modules = [
      'home' => [
        'label' => 'Home',
        'link' =>  URL.'/admin/home',
      ],
      'about' => [
        'label' => 'About',
        'link' =>  URL . '/admin/about',
      ],
      'users' => [
        'label' => 'Users',
        'link' =>  URL.'/admin/users',
      ],
    ];

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getPage($title,$content){ 
      return View::render('admin/page', [
          'title' => $title,
          'content' => $content,
      ]);      
    }

    public static function getMenu($currentModule){
      $links = '';
      foreach(self::$modules as $hash => $module){
        $links .= View::render('admin/menu/link', [
          'label' => $module['label'],
          'link' => $module['link'],
          'current' => $hash === $currentModule ? 'text-danger' : '',
        ]);
      }
      return View::render('admin/menu/box',[
        'links' => $links,
      ]);
    }

    public static function getPanel($title, $content, $currentModule){
      
      $contentPanel = View::render('admin/panel',[
        'menu' => self::getMenu($currentModule),
        'content' => $content,
      ]);
      
      return self::getPage($title,$contentPanel);

    }

}
