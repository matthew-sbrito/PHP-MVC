<?php

namespace App\Utils;

use App\Http\Request;

class Api {
  public static function getPagination(Request $request, Pagination $pagination): array{
    return [
      [
        'currentPage' => $pagination->getCurrentPage(),
        'totalPages' => $pagination->getTotalPage(),
        'items' => (int)$pagination->getQntResults(),
        'offset' => $pagination->getLimit(),
      ]
    ];
  }
  public static function getFilterByParams(array $queryParams): ?string{
    unset($queryParams['page']); 
    foreach($queryParams as $key => $value){
        $conditions[] = $key . ' LIKE "%'. str_replace(' ','%',$value).'%"';
    }

    return implode(' AND ', $conditions);
}
}