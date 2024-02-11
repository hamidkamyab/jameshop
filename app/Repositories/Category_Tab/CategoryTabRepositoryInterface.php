<?php
namespace App\Repositories\Category_Tab;

interface CategoryTabRepositoryInterface {
    public function getAll($page = false);
    public function getById($id);
    public function store($data,$parent = 0);
    public function update($data,$id);
    public function destroy($id);

}
