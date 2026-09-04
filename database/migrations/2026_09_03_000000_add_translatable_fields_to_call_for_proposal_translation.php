<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('CallForProposalTranslation', function (Blueprint $table) {
            $table->string('financingOrganism')->nullable()->after('title');
            $table->string('actionType')->nullable()->after('financingOrganism');
            $table->string('fundingType')->nullable()->after('actionType');
        });

        // Retire les colonnes de la table non traduisible, une fois les données migrées (étape 3)
        Schema::table('CallForProposal', function (Blueprint $table) {
            $table->dropColumn(['financingOrganism', 'actionType', 'fundingType']);
        });
    }

    public function down(): void
    {
        Schema::table('CallForProposal', function (Blueprint $table) {
            $table->string('financingOrganism')->nullable();
            $table->string('actionType')->nullable();
            $table->string('fundingType')->nullable();
        });

        Schema::table('CallForProposalTranslation', function (Blueprint $table) {
            $table->dropColumn(['financingOrganism', 'actionType', 'fundingType']);
        });
    }
};