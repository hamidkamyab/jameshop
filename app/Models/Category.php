<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    use HasFactory;

    public function getChildren(){
        return $this->hasMany(Category::class,'parent_id');
    }
    public function children(){
        return $this->getChildren()->with('children');
    }

    public function getParent(){
        return $this->hasMany(Category::class,'id','parent_id');
    }
    public function parent(){
        return $this->getParent()->with('parent');
    }

    public function attributesGroup(){
        return $this->belongsToMany(AttributeGroup::class,'attributes_group_categories');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }
}
