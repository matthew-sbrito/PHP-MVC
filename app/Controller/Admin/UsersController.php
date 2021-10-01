<?php
namespace App\Controller\Admin;

use App\Utils\View;
use App\Database\Pagination;
use App\Utils\RenderPage as Page;
use App\Repositories\UserRepository;

class UsersController extends Page{

    /**
     *  Método responsável por retornar o conteúdo(view).
     *  @return string
     */
    public static function getView($request){
        $items = self::getItems($request, $pagination);
        $pagination = parent::getPagination($request, $pagination);
        
        $content = View::render('admin/main',[
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
        $quantity = (new UserRepository)->count($where);
        
        $pagination = new Pagination($quantity, $currentPage, 2);
        $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

        $users = (new UserRepository)->find($where, ' NOME ASC ', $limit);
        
        foreach($users as $user){
           $itens .= View::render('home/items',[
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