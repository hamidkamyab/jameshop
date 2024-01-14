<?php
namespace App\Repositories\AttributeValue;

interface AttributeValueRepositoryInterface {
    public function getAll($page = false);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
}
