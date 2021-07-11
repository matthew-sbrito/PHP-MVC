<?php

namespace App\Utils;

class RenderPage
{

    private static function getHeader()
    {
        if ($_SESSION['user']) {
            $contentHeader = View::render('Templates/Header/DropdownUser', [
                'name' => $_SESSION['user']->name,
            ]);
        } else {
            $contentHeader = View::render('Templates/Header/LoginBotton');
        }

        return View::render('Templates/Header/Header', [
            'contentHeader' => $contentHeader,
        ]);
    }

    private static function getFooter()
    {
        return View::render('Templates/Footer/Footer', [
            'date' => date('Y-m-d'),
        ]);
    }

    /**
     *  Método responsável por retornar o conteúdo (view).
     *  @return string
     */
    public static function getPage($title, $content, $template = true)
    {

        if ($template) {
            $header = self::getHeader();
            $footer = self::getFooter();
        } else {
            $header = '';
            $footer = '';
        }

        return View::render('Pages/Page', [
            'title' => $title,
            'header' => $header,
            'content' => $content,
            'footer' => $footer,
        ]);
    }
}
