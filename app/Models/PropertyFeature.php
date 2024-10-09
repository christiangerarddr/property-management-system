<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyFeature extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'feature',
        'description',
        'property_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
