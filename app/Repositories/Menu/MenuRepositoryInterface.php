<?php
namespace App\Repositories\Menu;

interface MenuRepositoryInterface {
    public function getAll($page = false);
    public function getActive();
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
}
