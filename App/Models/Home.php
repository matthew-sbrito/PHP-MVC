<?php
namespace App\Models;

class Home{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getData(){       
        $arr = [
            [
            'nome' => 'Matheus Brito',
            'idade' => 19
            ]
        ];

        return $arr;
    }
}