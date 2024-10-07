<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Property;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();


            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('size', 10, 2)->nullable();

            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();

            $table->integer('property_type')->default(Property::HOUSE);
            $table->integer('status')->default(Property::AVAILABLE);
            $table->integer('condition')->default(Property::NEW_CONDITION)->nullable();

            $table->foreignId('owner_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('location_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->date('date_built')->nullable();

            $table->integer('parking_spaces')->nullable();
            $table->boolean('utilities_included')->default(true);
            $table->text('lease_terms')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
