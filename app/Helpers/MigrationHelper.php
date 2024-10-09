<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint;
class MigrationHelper
{
    public static function addTimestampsWithUserColumns(Blueprint $table): void
    {
        $table->timestamps();
        $table->softDeletes();
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->unsignedBigInteger('deleted_by')->nullable();
    }
}
