<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface{
    public function getAll($page=false);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($data,$id);
}
