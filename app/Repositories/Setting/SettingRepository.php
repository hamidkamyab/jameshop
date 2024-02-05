<?php

namespace App\Repositories\Setting;

use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    protected $file;
    protected $product;
    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function getAll()
    {
        return $this->setting->all();
    }

    public function store($data)
    {
        foreach($data as $key=>$value)
        $this->setting::updateOrCreate(
            ['title' => $key],
            ['value' => $value]
        );
    }

}
