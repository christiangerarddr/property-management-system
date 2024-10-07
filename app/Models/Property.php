<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const HOUSE = 1;
    public const APARTMENT = 2;
    public const COMMERCIAL_SPACE = 3;
    public const LAND = 4;
    public const CONDO = 5;
    public const VILLA = 6;

    public const PROPERTY_TYPE = [
        self::HOUSE => 'House',
        self::APARTMENT => 'Apartment',
        self::COMMERCIAL_SPACE => 'Commercial Space',
        self::LAND => 'Land',
        self::CONDO => 'Condo',
        self::VILLA => 'Villa'
    ];

    public const AVAILABLE = 1;
    public const RENTED = 2;
    public const SOLD = 3;
    public const UNDER_MAINTENANCE = 4;
    public const RESERVED = 5;

    public const STATUS = [
        self::AVAILABLE => 'Available',
        self::RENTED => 'Rented',
        self::SOLD => 'Sold',
        self::UNDER_MAINTENANCE => 'Under Maintenance',
        self::RESERVED => 'Reserved'
    ];

    public const NEW_CONDITION = 1;
    public const GOOD_CONDITION = 2;
    public const NEEDS_REPAIR = 3;

    public const CONDITION = [
        self::NEW_CONDITION => 'New',
        self::GOOD_CONDITION => 'Good',
        self::NEEDS_REPAIR => 'Needs Repair'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'bedrooms',
        'bathrooms',
        'property_type',
        'status',
        'condition',
        'owner_id',
        'location_id',
        'date_built',
        'parking_spaces',
        'utilities_included',
        'lease_terms',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function amenities(): HasMany
    {
        return $this->hasMany(Amenity::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class);
    }
}
