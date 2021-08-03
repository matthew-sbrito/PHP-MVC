<?php

namespace App\Utils;

class View
{

    /**
     * Váriaveis padrões da view
     * @var array
     */

    private static $vars;

    /**
     *  Método responsável por definir os dados iniciais da classe
     * @param array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }
    /**
     *  Método responsável por retornar o conteúdo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../Resources/Views/' . $view . '.html';
        return file_exists($file) ? $file : '';
    }


    /**
     *      Método responsável por retornar o conteúdo renderizado de uma view.
     * @param string $view
     * @param array $params 
     * @return string
     */

    public static function render($view, $params = [])
    {
        // CONTEUDO DA VIEW
        $contentView = self::getContentView($view);

        $contentView = file_get_contents($contentView);

        //Merge de váriaveis da view
        $vars   = array_merge(self::$vars, $params);
        $keys   = array_keys($vars);
        $values = array_values($vars);

        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, $values, $contentView);
    }
}
