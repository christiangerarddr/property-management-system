<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'property_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
