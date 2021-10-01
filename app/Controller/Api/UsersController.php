<?php

namespace App\Controller\Api;

use App\Utils\Api;
use App\Http\Request;
use App\Models\Entity\User;
use App\Database\Pagination;
use App\Repositories\UserRepository;

class UsersController extends Api{
  
  public static function getAllUsers(Request $request){
    $users = (new UserRepository)->find();
    return [
      'users' => $users,
    ];
  }
  public static function getAllUsersWithPagination(Request $request){
    return [
      'users' => self::getUsers($request, $pagination),
      'pagination' => parent::getPagination($pagination),
    ];
  }

  public static function getUsers(Request $request, Pagination &$pagination): array{
            
    $users = [];
    $queryParams = $request->getQueryParams();
    $currentPage = (int)$queryParams['page'] ?? 1;
   
    $where = parent::getFilterByParams($queryParams);
    $quantity = (new UserRepository)->count($where);
    
    $pagination = new Pagination($quantity, $currentPage, 3);
    $limit = $pagination->getLimit(); // responsavel por pegar os items corretos das paginas

    $users = (new UserRepository)->find($where, ' NOME ASC ', $limit);

    return $users;
  }

  public static function getUserById(Request $request, int $id): array{
    $user = (new UserRepository)->findOne($id);
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

    $userExists = (new UserRepository)->findByEmail($post->EMAIL);
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

    $user = (new UserRepository)->findOne($id);
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");    
    
    $user->update($post);

    return [
      'user' => $user
    ];
  }
  public static function updatePassword(Request $request, $id){
    $request->postRequired('SENHA');
    $post = $request->getPostVars([
      'SENHA'
    ]);

    $user = (new UserRepository)->findOne($id);
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");    
    
    $user->updatePassword($post->SENHA);

    return [
      'success' => "Senha do usuário de id ${id} atualizado com sucesso!"
    ];
  }

  public static function deleteUser(Request $request, $id){

    $user = (new UserRepository)->findOne($id);
    
    if(!$user instanceof User) throw new \Exception("Usuário de id ${id} não encontrado!");
    
    if($user->id == $request->user->id) throw new \Exception("Não é possível excluir usuário logado!");
    
    $delete = $user->delete();
    
    if(!$delete) throw new \Exception("Erro ao deletar usuário!");
    
    return[
      'success' => true
    ];
  }

  public static function getCurrentUser($request){
    return [
      "user" => $request->user,
    ];
  }
}
