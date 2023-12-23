<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;
    // protected $mediaPath = "/storage/";
    // protected $mediaThumbnail = "/storage/";

    protected $table = 'media';
    protected $fillable = ['file_id'];

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function getPathAttribute($media){
    //     return $this->mediaPath . $media;
    // }

    // public function getThumbnailAttribute($media){
    //     return $this->mediaThumbnail . $media;
    // }

    public function file(){
        return $this->belongsTo(File::class);
    }

    public function mediable():MorphTo
    {
        return $this->morphTo();
    }
}
