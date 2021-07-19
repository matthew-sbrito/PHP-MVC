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
      return View::render('Admin/Page', [
          'title' => $title,
          'content' => $content,
      ]);      
    }

    public static function getMenu($currentModule){
      $links = '';
      foreach(self::$modules as $hash => $module){
        $links .= View::render('Admin/Menu/Link', [
          'label' => $module['label'],
          'link' => $module['link'],
          'current' => $hash === $currentModule ? 'text-danger' : '',
        ]);
      }
      return View::render('Admin/Menu/Box',[
        'links' => $links,
      ]);
    }

    public static function getPanel($title, $content, $currentModule){
      
      $contentPanel = View::render('Admin/Panel',[
        'menu' => self::getMenu($currentModule),
        'content' => $content,
      ]);
      
      return self::getPage($title,$contentPanel);

    }

}
