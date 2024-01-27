<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Style extends Model
{
    use HasFactory;


    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'products_styles');
    }
}
