<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $table = 'attributes_values';
    public function attributes_group(){
        return $this->belongsTo(AttributeGroup::class);
    }
}