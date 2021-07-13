<?php
namespace App\Controller\Pages;

use App\Utils\View;
use App\Utils\RenderPage;
use App\Utils\Pagination;
use App\Models\UsersRepository;

class HomeController extends RenderPage{

    /**
     *  Método responsável por retornar o conteúdo (view) da home.
     *  @return string
     */
    public static function getHome($request){ 
        
        $items = self::getItems($request, $pagination);

        $content = View::render('Home/Main', [
            'items' => $items ? $items : '<tr><td colspan="5">Nenhum Resultado encontrado!</td></tr>',
            'pagination' => parent::getPagination($request, $pagination),
        ]);
        
        return parent::getPage('Home', $content, true);
     
    }

    public static function getItems($request, &$pagination){
            
        $itens = '';
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;
       
        $where = parent::getFilterByParams($queryParams);
        $quantity = UsersRepository::getQuantityUsers($where);
        
        $pagination = new Pagination($quantity, $currentPage, 2);
        $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

        $users = UsersRepository::getAllUsers($where, ' NOME ASC ', $limit);
        
        foreach($users as $user){
           $itens .= View::render('Home/Items',[
                'cod' => $user->COD,
                'name' => $user->NOME,
                'email' => $user->EMAIL,
                'sex' => $user->SEXO,
                'birthday' => date('d/m/Y',strtotime($user->NASCIMENTO)),
            ]);
        }
        return $itens;
    }

    public static function goHome(){
        header('Location: /home');
        exit;
    }
}