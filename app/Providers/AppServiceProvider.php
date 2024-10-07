<?php

namespace App\Providers;

use App\Models\PropertyImage;
use App\Services\AmenityService;
use App\Services\Contracts\PropertyServiceInterface;
use App\Services\LocationService;
use App\Services\OwnerService;
use App\Services\PropertyFeatureService;
use App\Services\PropertyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PropertyServiceInterface::class, PropertyService::class);
        $this->app->bind(PropertyFeatureService::class, PropertyFeatureService::class);
        $this->app->bind(PropertyImage::class, PropertyImage::class);
        $this->app->bind(OwnerService::class, OwnerService::class);
        $this->app->bind(AmenityService::class, AmenityService::class);
        $this->app->bind(LocationService::class, LocationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
