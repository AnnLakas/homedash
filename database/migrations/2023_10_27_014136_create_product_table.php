<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'brand_id')
                ->constrained(table: 'brands')
                ->cascadeOnDelete();
            $table->string(column: 'name');
            $table->string(column: 'slug')->unique();
            $table->string(column: 'sku')->unique();
            $table->string(column: 'image');
            $table->longText(column: 'description')->nullable();
            $table->unsignedBigInteger('quantity');
            $table->decimal(column: 'price', total:10, places: 2);
            $table->boolean(column: 'is_visible')->default(value:false);
            $table->boolean(column: 'is_featured')->default(value:false);
            $table->enum('type', ['deliverable', 'downloadable'])
            ->default('deliverable');
            $table->date(column: 'publised_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
