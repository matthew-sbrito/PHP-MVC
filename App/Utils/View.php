<?php

namespace App\Utils;

class View{

    
    /**
     *  Método responsável por retornar o conteúdo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view){
        $file = __DIR__.'/../../Resources/Views/'. $view .'.php';
        return file_exists($file) ? $file : '';
    }


    /**
     *      Método responsável por retornar o conteúdo renderizado de uma view.
     * @param string $view
     * @param array $params 
     * @return string
     */

    public static function render($view, $params = []){
        // CONTEUDO DA VIEW
        $contentView = self::getContentView($view);
        
        // Pega o array e tranforma em variaveis
        if(count($params) > 0) {
            foreach($params as $key => $value) {
                if(strlen($key) > 0) {
                    ${$key} = $value;
                }
            }
        }
        $user = $_SESSION['user'];

        //Retorna Conteúdo Renderizado
        require_once($contentView);
    }

    public static function renderTemplate($view, $params = []){
        // CONTEUDO DA VIEW
        $contentView = self::getContentView($view);
        
        // Pega o array e tranforma em variaveis
        if(count($params) > 0) {
            foreach($params as $key => $value) {
                if(strlen($key) > 0) {
                    ${$key} = $value;
                }
            }
        }
        $user = $_SESSION['user'];

        //Retorna Conteúdo Renderizado
        require_once(TEMPLATE_PATH. '/Header.php');
        require_once($contentView);
        require_once(TEMPLATE_PATH. '/Footer.php');
    }
}