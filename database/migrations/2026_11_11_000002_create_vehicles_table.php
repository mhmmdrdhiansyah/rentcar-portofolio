<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_category_id')->constrained('vehicle_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('brand');
            $table->string('model');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            // Specifications (year, trim, transmission, capacity) are added only
            // after owner verification — PRD TODO-06. Deliberately not created now.
            $table->json('specifications')->nullable();
            $table->boolean('with_driver')->default(true);
            $table->boolean('self_drive')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
