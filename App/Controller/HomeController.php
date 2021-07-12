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
        
        $items = self::getItems($request, $pagination);

        $content = View::render('Pages/Home/Main', [
            'items' => $items ? $items : 'Nenhum Resultado encontrado!',
            'pagination' => parent::getPagination($request, $pagination),
        ]);
        
        return parent::getPage('Home', $content, true);
     
    }

    public static function getItems($request, &$pagination){
            
        $itens = '';
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;
        unset($queryParams['page']); 
       
        $where = parent::getFilterByParams($queryParams);
        $quantity = UsersRepository::getQuantityUsers($where);
        
        $pagination = new Pagination($quantity, $currentPage, 2);
        $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

        $results = UsersRepository::getAllUsers($where, ' NOME ASC ', $limit);
        
        foreach($results as $result){
           $itens .= View::render('Pages/Home/Items',[
                'cod' => $result->COD,
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