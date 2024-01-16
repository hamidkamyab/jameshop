<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $fillable = ['file_id'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            $file->media()->delete();
        });
    }



    public function file(){
        return $this->belongsTo(File::class);
    }

    public function mediable():MorphTo
    {
        return $this->morphTo();
    }
}
