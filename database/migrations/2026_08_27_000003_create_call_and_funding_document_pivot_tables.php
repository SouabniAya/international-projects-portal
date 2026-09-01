<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('CallDocument')) {
            Schema::create('CallDocument', function (Blueprint $table) {
                $table->foreignId('proposalID')->constrained('CallForProposal', 'proposalID')->cascadeOnDelete();
                $table->foreignId('documentID')->constrained('Document', 'documentID')->cascadeOnDelete();
                $table->primary(['proposalID', 'documentID']);
            });
        }

        if (!Schema::hasTable('FundingProgrammeDocument')) {
            Schema::create('FundingProgrammeDocument', function (Blueprint $table) {
                $table->foreignId('programID')->constrained('FundingProgramme', 'programID')->cascadeOnDelete();
                $table->foreignId('documentID')->constrained('Document', 'documentID')->cascadeOnDelete();
                $table->primary(['programID', 'documentID']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('FundingProgrammeDocument');
        Schema::dropIfExists('CallDocument');
    }
};
