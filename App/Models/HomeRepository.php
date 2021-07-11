<?php
namespace App\Models;

class HomeRepository{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getData(){       
        $arr = [
            [
            'name' => 'Matheus Brito',
            'age' => 19
            ]
        ];

        return $arr;
    }
}