<?php
namespace App\Repositories\Category;

interface CategoryRepositoryInterface {
    public function getPage($page);
    public function getAll();
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
}
