<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_info',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
