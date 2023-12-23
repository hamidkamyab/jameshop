<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $mediaPath = "/storage/";
    protected $mediaThumbnail = "/storage/";

    public function getPathAttribute($media){
        return $this->mediaPath . $media;
    }

    public function getThumbnailAttribute($media){
        return $this->mediaThumbnail . $media;
    }

    public function media(){
        return $this->hasMany(Media::class);
    }
}
