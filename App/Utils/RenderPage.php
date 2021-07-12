<?php

namespace App\Utils;

class RenderPage {

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

    public static function getFilterByParams($queryParams){

        foreach($queryParams as $key => $value){
            $conditions[] = $key . ' LIKE "%'. str_replace(' ','%',$value).'%"';
        }

        return implode(' AND ', $conditions);
    }
    
    public static function changePage($queryParams){

        unset($queryParams['page']);
        foreach($queryParams as $key => $value){
            if($value){
                $conditions[] = $key . '='. $value;
            }
        }

        return implode('&', $conditions);
    }

    public static function getPagination($request, $pagination){
        $pages = $pagination->getPages();        
        
        if(count($pages) <= 1) return '';
        
        $links = '';
        
        $conditions = self::changePage($request->getQueryParams()); 

        $url = $request->getRouter()->getCurrentUrl() .'?'. str_replace(' AND ','&', $conditions) . '&';
        
        $pagesFull = $pagination->getTotalPage();
        $currentPage = $pagination->getCurrentPage();

        foreach($pages as $page){
            
            $queryParams['page'] = $page['page'];
            $link = $url . http_build_query($queryParams);            
                        
            $links .= View::render('Pagination/Link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : '',
            ]);
        }

        $pPage = $currentPage - 1;
        $nPage = $currentPage + 1;
        $previous['page'] =  $pPage <= 0 ? 1 : $pPage;
        $next['page'] = $nPage > $pagesFull ? $pagesFull : $nPage;

        $linkPrevious = $url . http_build_query($previous) ;            
        $linkNext = $url . http_build_query($next);
        
        return View::render('Pagination/Box',[
            'links' => $links,
            'previous' => $linkPrevious,
            'next' => $linkNext,
        ]);
    }
}
