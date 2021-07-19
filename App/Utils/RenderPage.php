<?php

namespace App\Utils;
use App\Session\Session;

class RenderPage {

    
    /**
     *  Método responsável por retornar o conteúdo (view).
     *  @return string
     */
    public static function getPage($title, $content, $template = true)
    {
        return View::render('Page', [
            'title' => $title,
            'header' => $template ? self::getHeader() : '',
            'content' => $content,
            'footer' => $template ? self::getFooter() : '',
        ]);
    }
    
    private static function getHeader(){
        $user = Session::getUser();

        $loginBotton = View::render('Templates/Header/LoginButton');
        $contentHeader = self::getContentHeader($user);
        $message = Messages::getMessage();

        return View::render('Templates/Header/Header', [
            'contentHeader' => $contentHeader ? $contentHeader : $loginBotton,
            'message' => $message
        ]);
    }
    private static function getContentHeader($user){
        if (empty($user)) return null;

        $admin = '<a class="dropdown-item" href="/admin/home">Admin</a>';
        
        return View::render('Templates/Header/DropdownButton', [
            'name' => $user->NOME,
            'admin' => $user->IS_ADMIN ? $admin : '',
        ]);
    }

    private static function getFooter(){
        return View::render('Templates/Footer/Footer', [
            'date' => date('Y-m-d'),
        ]);
    }

    public static function getFilterByParams($queryParams){
        unset($queryParams['page']); 
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

        return implode('&',$conditions);
    }

    public static function getPagination($request, $pagination){
        $pages = $pagination->getPages();        
        
        if(count($pages) <= 1) return '';
        
        $links = '';
        
        $conditions = self::changePage($request->getQueryParams()); 
        $url = $request->getRouter()->getCurrentUrl() .'?'. $conditions . '&';
        
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
            'previous' => $linkPrevious,
            'links' => $links,
            'next' => $linkNext,
        ]);
    }
}
