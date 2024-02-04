<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TopBrand extends Model
{
    use HasFactory;

    public function products(){
        return $this->belongsToMany(Product::class,'products_top_brands');
    }

    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
