<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Brand extends Model
{
    use HasFactory;

    // public function photo(){
    //     return $this->hasOne(MediaFile::class,'id','photo_id');
    // }
    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }
    public function products(){
        return $this->hasMany(Product::class);
    }

}
