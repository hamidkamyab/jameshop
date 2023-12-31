<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    use HasFactory;
    protected $table = 'attributes_group';
    public function attributes_value(){
        return $this->hasMany(AttributeValue::class,'attributes_group_id');
    }
    public function getTypeAttribute($value)
    {
        return $value === 0 ? 'ویژگی تکی' : 'ویژگی دسته ای';
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'attributes_group_categories');
    }


}
