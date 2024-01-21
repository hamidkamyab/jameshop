<?php
namespace App\Repositories\Slider;

interface SliderRepositoryInterface {
    public function getAll($page = false);
    public function getById($id);
    public function store($data);
    public function destroy($id);
}
