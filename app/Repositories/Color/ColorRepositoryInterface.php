<?php
namespace App\Repositories\Color;

interface ColorRepositoryInterface{
    public function getAll($page=false);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
}
