<?php

namespace App\Interfaces;

interface IRepository {
  public function find($where, $order, $limit, $fields);
  public function count();
  public function findOne($id);
  public function create($model);
  public function update($model, $id);
  public function destroy($id);
}