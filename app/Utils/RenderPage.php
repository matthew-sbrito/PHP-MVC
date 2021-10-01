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
        return View::render('page', [
            'title' => $title,
            'header' => $template ? self::getHeader() : '',
            'content' => $content,
            'footer' => $template ? self::getFooter() : '',
        ]);
    }
    
    private static function getHeader(){
        $user = Session::getUser();

        $loginBotton = View::render('templates/header/loginButton');
        $contentHeader = self::getContentHeader($user);
        $message = Messages::getMessage();

        return View::render('templates/header/header', [
            'contentHeader' => $contentHeader ? $contentHeader : $loginBotton,
            'message' => $message
        ]);
    }
    private static function getContentHeader($user){
        if (empty($user)) return null;

        $admin = '<a class="dropdown-item" href="/admin/home">Admin</a>';
        
        return View::render('templates/header/dropdownButton', [
            'name' => $user->NOME,
            'admin' => $user->IS_ADMIN ? $admin : '',
        ]);
    }

    private static function getFooter(){
        return View::render('templates/footer/footer', [
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

    private static function getPaginationLink($page, $url, $label = null){
        $queryParams['page'] = $page['page'];
            $link = $url . http_build_query($queryParams);            
                        
            return View::render('pagination/link', [
                'page' => $label ?? $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : '',
            ]);
    }

    public static function getPagination($request, $pagination){
        $pages = $pagination->getPages();        
        
        if(count($pages) <= 1) return '';
        
        $links = '';
        
        $conditions = self::changePage($request->getQueryParams()); 
        $url = $request->getRouter()->getCurrentUrl() .'?'. $conditions . '&';
        
        $pagesFull = $pagination->getTotalPage();
        
        $currentPage = $pagination->getCurrentPage();

        $limit = getenv('PAGINATION_LIMIT');
        $middle = ceil($limit/2);
        $start = $middle > $currentPage ? 0 : $currentPage - $middle;
        $limit = $limit + $start;

        if($limit > count($pages)){
            $diff = $limit - count($pages);
            $start -= $diff;
        }
        if($start > 0){
            $links.= self::getPaginationLink(reset($pages), $url, '<<');
        }
        // PREVIOUS
        // if($currentPage > 1){
        //     $previous = $currentPage - 2;
        //     $links.= self::getPaginationLink($pages[$previous], $url, '<');
        // }
        
        foreach($pages as $page){
            if($page['page'] <= $start) continue;
            if($page['page'] > $limit){
                //NEXT
                //$links .= self::getPaginationLink($pages[$currentPage], $url,'>');
                $links .= self::getPaginationLink(end($pages), $url,'>>');
                break;
            } 
            $links .= self::getPaginationLink($page, $url);
        }
        
        return View::render('pagination/box',[
            'links' => $links,
        ]);
    }
}
