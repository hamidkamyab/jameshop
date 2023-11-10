<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    use HasFactory;
    protected $mediaPath = "/storage/";
    protected $mediaThumbnail = "/storage/";
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getPathAttribute($media){
        return $this->mediaPath . $media;
    }
    public function getThumbnailAttribute($media){
        return $this->mediaThumbnail . $media;
    }
}
