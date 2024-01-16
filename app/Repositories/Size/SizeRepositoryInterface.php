<?php
namespace App\Repositories\Size;

interface SizeRepositoryInterface{
    public function getAll($page=false);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
}
