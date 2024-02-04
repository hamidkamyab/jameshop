<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
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

    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }


    public function amazings(){
        return $this->belongsToMany(Amazing::class,'amazings_products');
    }

    public function styles(){
        return $this->belongsToMany(Style::class,'products_styles');
    }

    public function top_brands(){
        return $this->belongsToMany(TopBrand::class,'products_top_brands');
    }
}
