<?php

namespace App\Controller\Api;

use App\Models\UsersRepository;
use App\Utils\Pagination;
use App\Utils\Api;

class UsersController extends Api{
  
  public static function getAllUsers($request){
    $users = UsersRepository::getAllUsers();
    return [
      'users' => $users,
    ];
  }
  public static function getAllUsersWithPagination($request){
    return [
      'users' => self::getUsers($request, $pagination),
      'pagination' => [
        'currentPage' => $pagination->getCurrentPage(),
        'totalPages' => $pagination->getTotalPage(),
        'items' => $pagination->getLimit(),
      ],
    ];
  }

  public static function getUsers($request, &$pagination){
            
    $users = [];
    $queryParams = $request->getQueryParams();
    $currentPage = (int)$queryParams['page'] ?? 1;
   
    // $where = parent::getFilterByParams($queryParams);
    $quantity = UsersRepository::getQuantityUsers();
    
    $pagination = new Pagination($quantity, $currentPage, 4);
    $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

    $users = UsersRepository::getAllUsers(null , ' NOME ASC ', $limit);

    return $users;
  }
  public static function getUserById($request,$id){
    $user = UsersRepository::getUserById($id);
    return [
      'user' => $user,
    ];
  }
}
