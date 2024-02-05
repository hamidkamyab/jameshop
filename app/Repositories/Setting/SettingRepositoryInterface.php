<?php
namespace App\Repositories\Setting;

interface SettingRepositoryInterface {
    public function getAll();
    public function store($data);
}
