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
        return $this->belongsToMany(MediaFile::class,'media_files_products')->withPivot('id','first');
    }

    public function photo(){
        return $this->belongsToMany(MediaFile::class,'media_files_products')->wherePivot('first',1);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class,'products_sizes')->withPivot('id');
    }
    public function colors(){
        return $this->belongsToMany(Color::class,'colors_products')->withPivot('id');
    }

    public function attributes_values(){
        return $this->belongsToMany(AttributeValue::class,'attributes_values_products','product_id','attribute_value_id')->withPivot('id');
    }

}
