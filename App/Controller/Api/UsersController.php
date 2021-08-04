<?php

namespace App\Controller\Api;

use App\Models\UsersRepository;
use App\Models\Entity\User;
use App\Utils\Pagination;
use App\Http\Request;
use App\Utils\Api;

class UsersController extends Api{
  
  public static function getAllUsers(Request $request){
    $users = UsersRepository::getAllUsers();
    return [
      'users' => $users,
    ];
  }
  public static function getAllUsersWithPagination(Request $request){
    return [
      'users' => self::getUsers($request, $pagination),
      'pagination' => parent::getPagination($request, $pagination),
    ];
  }

  public static function getUsers(Request $request, ?Pagination &$pagination): array{
            
    $users = [];
    $queryParams = $request->getQueryParams();
    $currentPage = (int)$queryParams['page'] ?? 1;
   
    $where = parent::getFilterByParams($queryParams);
    $quantity = UsersRepository::getQuantityUsers($where);
    
    $pagination = new Pagination($quantity, $currentPage, 3);
    $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

    $users = UsersRepository::getAllUsers($where, ' NOME ASC ', $limit);

    return $users;
  }

  public static function getUserById(Request $request, int $id): array{
    $user = UsersRepository::getUserById($id);
    if(!$user){
      throw new \Exception("Usuário de id ${id} não encontrado!", 404);
    }
    return [
      'user' => $user,
    ];
  }
  public static function setNewUser(Request $request){
    $request->postRequired(User::$required);
    $post = $request->getPostVars(User::$columns);

    $userExists = UsersRepository::getUserByEmail($post->EMAIL);
    if($userExists instanceof User){
      throw new \Exception('Usuário já cadastrado!');
    }

    $user = new User((array)$post);
    $newUser = $user->cadastrar();

    if(!$newUser instanceof User) throw new \Exception('Error ao cadastrar usuário!');    
    return [
      'user' => $newUser
    ];
  }
 
  public static function updateUser(Request $request, int $id){
    
    $post = $request->getPostVars([
      'NOME',
      'EMAIL',
      'SEXO',
      'NASCIMENTO',
      'IS_ADMIN'
     ]);

    $user = UsersRepository::getUserById($id);
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");    
    
    $user->update($post);

    return [
      'user' => $user
    ];
  }
  public static function updatePassword(Request $request, $id){
    
    $post = $request->getPostVars([
      'SENHA'
    ]);

    $user = UsersRepository::getUserById($id);
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");    
    
    $user->updatePassword($post->SENHA);

    return [
      'success' => "Senha do usuário de id ${id} atualizado com sucesso!"
    ];
  }

  public static function deleteUser(Request $request, $id){

    $user = UsersRepository::getUserById($id);
    
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");
    
    if($user->id == $request->user->id) throw new \Exception("Não é possível excluir usuário logado!");
    
    $delete = $user->delete();
    
    if(!$delete) throw new \Exception("Erro ao deletar usuário!");
    
    return[
      'success' => true
    ];
  }
}
