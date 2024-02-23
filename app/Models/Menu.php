<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function getPositionAttribute($value)
    {
        $originalPosition = $value;
        if ($value === 'Top') {
            $result = 'بالای سایت (هد)';
        } else if ($value === 'Bottom') {
            $result = 'پایین سایت (فوتر)';
        }
        return ['showing' => $result, 'original' => $originalPosition];
    }

    public function getChildren()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
    public function children()
    {
        return $this->getChildren()->with('children', 'bestMenu.media.file');
    }

    public function getParent()
    {
        return $this->hasMany(Menu::class, 'id', 'parent_id');
    }
    public function parent()
    {
        return $this->getParent()->with('parent');
    }


    public function bestMenu()
    {
        return $this->hasMany(BestMenu::class, 'menu_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
