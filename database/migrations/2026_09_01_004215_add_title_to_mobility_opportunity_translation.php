<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('MobilityOpportunityTranslation') && !Schema::hasColumn('MobilityOpportunityTranslation', 'title')) {
            Schema::table('MobilityOpportunityTranslation', function (Blueprint $table) {
                $table->string('title')->after('languageCode');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('MobilityOpportunityTranslation') && Schema::hasColumn('MobilityOpportunityTranslation', 'title')) {
            Schema::table('MobilityOpportunityTranslation', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }
};
