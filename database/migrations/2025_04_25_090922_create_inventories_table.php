<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create suppliers table if it doesn't exist
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('contact_person')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('inventories')) {
            Schema::create('inventories', function (Blueprint $table) {
                $table->id();
                $table->string('product_title');
                $table->string('category')->nullable();
                $table->text('description')->nullable();
                $table->string('photo')->nullable();
                $table->integer('quantity')->default(0);
                $table->decimal('buying_price', 10, 2)->default(0.00);
                $table->decimal('selling_price', 10, 2)->default(0.00);
                $table->integer('in_stock')->default(0);
                $table->timestamp('product_added')->nullable();
                $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Use raw SQL to drop tables with CASCADE option to handle dependencies
        DB::statement('DROP TABLE IF EXISTS "inventories" CASCADE');
        DB::statement('DROP TABLE IF EXISTS "suppliers" CASCADE');
    }
};
