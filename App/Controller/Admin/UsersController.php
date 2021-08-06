<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\RenderPage as Page;
use App\Utils\Pagination;
use App\Models\UsersRepository;

class UsersController extends Page{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getView($request){
        $items = self::getItems($request, $pagination);
        $pagination = parent::getPagination($request, $pagination);
        
        $content = View::render('Admin/Main',[
            'items' => $items ? $items : '<tr><td colspan="5">Nenhum Resultado encontrado!</td></tr>',
            'pagination' => $pagination ? $pagination : ''
        ]);

        return RenderPage::getPanel('Users',$content,'users');
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
}