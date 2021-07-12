<?php
namespace App\Controller;

use App\Models\UsersRepository;
use App\Utils\View;
use App\Utils\RenderPage;
use App\Utils\Pagination;

class HomeController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome($request){ 
              
        $content = View::render('Pages/Home/Main', [
            'items' => self::getItems($request, $pagination),
            'pagination' => parent::getPagination($request, $pagination),
        ]);
        
        return parent::getPage('Home', $content, true);
     
    }

    public static function getItems($request, &$pagination){
            
        $itens = '';
        
        $quantity = UsersRepository::getQuantityUsers();
        
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $pagination = new Pagination($quantity, $currentPage, 2);
        $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

        $results = UsersRepository::getAllUsers(null, ' NOME ASC ', $limit);
        
        foreach($results as $result){
           $itens .= View::render('Pages/Home/Items',[
                'name' => $result->NOME,
                'email' => $result->EMAIL,
                'sex' => $result->SEXO,
                'birthday' => date('d/m/Y',strtotime($result->NASCIMENTO)),
            ]);
        }

        return $itens;

    }

    public static function goHome(){
        header('Location: /home');
        exit;
    }
}