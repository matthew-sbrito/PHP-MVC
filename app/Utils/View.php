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
     *      Método responsável por retornar o conteúdo renderizado de uma view.
     * @param string $view
     * @param array $params 
     * @return string
     */

    public static function render($view, $params = [])
    {
        // CONTEUDO DA VIEW
        $contentView = views($view);

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
