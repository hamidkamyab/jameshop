<?php
namespace App\Repositories\BestMenu;

interface BestMenuRepositoryInterface {
    public function getByMenuId($id);
    public function destroy($id);
    public function store($data,$menuId);
}
