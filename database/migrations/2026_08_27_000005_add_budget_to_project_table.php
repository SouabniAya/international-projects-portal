<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('Project') && !Schema::hasColumn('Project', 'budget')) {
            Schema::table('Project', function (Blueprint $table) {
                $table->decimal('budget', 12, 2)->nullable()->after('website');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('Project') && Schema::hasColumn('Project', 'budget')) {
            Schema::table('Project', function (Blueprint $table) {
                $table->dropColumn('budget');
            });
        }
    }
};
