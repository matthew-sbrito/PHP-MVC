<?php
 
namespace App\Models;

use App\Repositories\UserRepository;

class User {

    public    int     $id;
    public    string  $name;
    public    ?string $email;
    protected string  $password;
    public    string  $sex;
    public    string  $birthdate;
    protected int     $is_admin;

    public function __construct(string $name, ?int $age) {
      $this->name = $name;
      $this->age  = $age ?? NULL;
    }
}