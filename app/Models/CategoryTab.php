<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CategoryTab extends Model
{
    use HasFactory;

    public function media():MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getChildren()
    {
        return $this->hasMany(CategoryTab::class, 'parent_id');
    }
    public function children()
    {
        return $this->getChildren()->with('children','media.file');
    }
}
