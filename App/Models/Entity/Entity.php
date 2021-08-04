<?php
 
namespace App\Models\Entity;

class Entity{

  public function __construct($values){
    foreach($values as $key => $value){
      $this->$key = $value;
    }
  }

  public function __get($value){
    return $this->$value;
  }
}