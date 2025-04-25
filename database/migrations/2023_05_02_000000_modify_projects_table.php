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
        // Check if columns don't exist in the projects table before adding them
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'date')) {
                $table->date('date')->nullable();
            }

            if (!Schema::hasColumn('projects', 'location')) {
                $table->string('location')->nullable();
            }

            if (!Schema::hasColumn('projects', 'contractor')) {
                $table->string('contractor')->nullable();
            }

            if (!Schema::hasColumn('projects', 'size')) {
                $table->string('size')->nullable();
            }

            if (!Schema::hasColumn('projects', 'project_manager')) {
                $table->string('project_manager')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Only drop columns if they exist
            $columns = ['date', 'location', 'contractor', 'size', 'project_manager'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
