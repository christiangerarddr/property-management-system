<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'block_number',
        'lot_number',
        'street',
        'village',
        'city',
        'region',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
