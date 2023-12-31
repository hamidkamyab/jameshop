<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BestMenu extends Model
{
    protected $table = 'best_menus';
    use HasFactory;

    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }
}
