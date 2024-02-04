<?php
namespace App\Repositories\TopBrand;

interface TopBrandRepositoryInterface {
    public function getAll($page = false);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
    public function search($id);

}
