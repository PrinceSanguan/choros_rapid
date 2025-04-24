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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('product_title');
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->integer('in_stock')->default(0);
            $table->decimal('buying_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('product_categories');
    }
};
