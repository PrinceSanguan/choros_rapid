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
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'status')) {
                $table->enum('status', ['pending', 'ongoing', 'completed', 'cancelled'])->default('pending');
            }

            if (!Schema::hasColumn('projects', 'budget')) {
                $table->decimal('budget', 10, 2)->default(0.00);
            }

            if (!Schema::hasColumn('projects', 'customer_id')) {
                $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('projects', 'manager_id')) {
                $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $columns = ['status', 'budget', 'customer_id', 'manager_id'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
