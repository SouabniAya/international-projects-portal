<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('Document') && !Schema::hasColumn('Document', 'documentType')) {
            Schema::table('Document', function (Blueprint $table) {
                $table->string('documentType', 100)->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        Schema::table('Document', function (Blueprint $table) {
            $table->dropColumn('documentType');
        });
    }
};
