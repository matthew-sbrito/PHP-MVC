<?php
 
namespace App\Models\Entity;

abstract class AbstractModel{

  public function __construct($values = null){
    if($values){
      foreach($values as $key => $value){
        $this->$key = $value;
      }
    }
  }

  public function __get($value){
    return $this->$value;
  }

  public function __set($key, $value){
    return $this->$key = $value;
  }
}