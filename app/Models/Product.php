<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function photos(){
        return $this->belongsToMany(MediaFile::class,'media_files_products');
    }

    public function photo(){
        return $this->belongsToMany(MediaFile::class,'media_files_products')->wherePivot('first',1);
    }
}
