<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyImage extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'image_name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
