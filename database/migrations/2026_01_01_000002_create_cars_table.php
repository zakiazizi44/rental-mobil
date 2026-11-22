<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel cars untuk data mobil dengan foreign key ke categories.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('license_plate')->unique();
            $table->decimal('price_per_day', 12, 2);
            $table->unsignedInteger('capacity');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->text('facilities')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
