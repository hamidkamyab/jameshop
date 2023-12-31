<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $appends = ['hamid'];
    public function getPositionAttribute($value)
    {
        if($value === 'Top'){
            $result = 'بالای سایت (هد)';
        }else if ($value === 'Bottom'){
            $result = 'پایین سایت (فوتر)';
        }
        $this->orginalPosition = $value;
        return $result;
    }
    public function getChildren(){
        return $this->hasMany(Menu::class,'parent_id');
    }
    public function children(){
        return $this->getChildren()->with('children');
    }

    public function getParent(){
        return $this->hasMany(Menu::class,'id','parent_id');
    }
    public function parent(){
        return $this->getParent()->with('parent');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
