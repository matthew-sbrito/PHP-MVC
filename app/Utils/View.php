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

    public static function render(string $view, array $params = [])
    {
        // CONTEUDO DA VIEW
        $contentView = views($view);

        //Merge de váriaveis da view
        $vars   = array_merge(self::$vars, $params);

        $contentView = self::if($vars, $contentView);

        $forEach     = self::getForEach($vars);
        $contentView = self::forEach($forEach, $contentView);
               
        $keys    = self::getKeys($vars);

        return self::html($contentView, $keys, array_values($vars));
    }

    private static function html(string $htmlTemplate, array $keys = [], array $values = []) {         
        $values = array_map(function ($item) {
            if($item && $item != '') return $item;
            return '';
        }, $values);

        return str_replace($keys, $values, $htmlTemplate);
    }

    private static function getForEach(&$vars) { 
        return array_filter($vars, function ($item, $key) use(&$vars) {
            if(is_array($item)){
                unset($vars[$key]);
                return $item;
            } 
        }, ARRAY_FILTER_USE_BOTH);
    }
    private static function getKeys($vars) {
        $keys = array_keys($vars);

        $keys = array_filter($keys, function ($item) use($vars) {
           return '{{' . $item . '}}';  
        });

        $keys = array_map( function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return $keys;
    }

    private static function forEach($items, $contentView){
        foreach($items as $key => $item) {
            $forEach    = '@foreach($'.$key.')';
            
            $countFirst         = strpos($contentView, $forEach);
            $countFirstTemplate = $countFirst + strlen($forEach);
            $firstString        = substr($contentView, $countFirstTemplate);        
            
            $endForEach = '@endforeach';
        
            $countEndTemplate = strpos($firstString, $endForEach);    
    
            $templateItem = substr($contentView, $countFirstTemplate, $countEndTemplate);
            
            $contentItems = '';
            foreach($item as $data){
                $data = is_object($data) ? get_object_vars($data) : $data;
                
                $keys   = self::getKeys($data);                
                $values = array_values($data);
                
                $contentItem  = self::if($data, $templateItem);
                $contentItems .= self::html($contentItem, $keys, $values);
            }
            $replace     = $forEach . $templateItem . $endForEach;
            $contentView = str_replace($replace, $contentItems, $contentView);
        }

        return $contentView;
    }

    private static function if($items, $contentView) {
        foreach($items as $key => $item) {
            $if     = '@if($'.$key.')';
            $exists = strpos($contentView, $if);

            if(!$exists) continue;
            
            $countFirstTemplate = $exists + strlen($if);
            $firstString        = substr($contentView, $countFirstTemplate);        
            
            $endIf = '@endif';
        
            $countEndTemplate = strpos($firstString, $endIf);    
    
            $templateItem = substr($contentView, $countFirstTemplate, $countEndTemplate);
            
            $contentItem = $item ? $templateItem : '';
            $replace     = $if . $templateItem . $endIf;
            $contentView = str_replace($replace, $contentItem, $contentView);
        }

        return $contentView;
    }
}
