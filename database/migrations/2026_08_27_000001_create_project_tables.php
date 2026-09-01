<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOTE: these tables already exist in the imported dump (Dump20260826.sql)
// under lowercase names (project, projecttranslation, projectpartner,
// projectdocument) — MySQL on Windows/Herd is case-insensitive by default,
// so the PascalCase names used here resolve to the same tables and no
// data is duplicated or lost. This migration exists so the schema is
// reproducible on a fresh environment (new dev machine, CI, staging) via
// `php artisan migrate`.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Project')) {
            Schema::create('Project', function (Blueprint $table) {
                $table->id('projectID');
                $table->string('acronym', 50)->nullable();
                $table->string('logo')->nullable();
                $table->string('projectReference', 100)->nullable();
                $table->string('coordinator');
                $table->string('schoolRole', 100);
                $table->date('startDate');
                $table->date('endDate');
                $table->enum('projectStatus', ['proposed', 'ongoing', 'completed']);
                $table->string('website')->nullable();
                $table->boolean('featured')->default(false);
                $table->enum('publicationStatus', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
                $table->dateTime('publishedAt')->nullable();
                $table->dateTime('scheduledAt')->nullable();
                $table->foreignId('programID')->nullable()->constrained('FundingProgramme', 'programID');
                $table->foreignId('publishedByUserID')->nullable()->constrained('User', 'userID');
                $table->char('countryCode', 2);
                $table->foreign('countryCode')->references('countryCode')->on('Country');
                $table->index('projectStatus');
            });
        }

        if (!Schema::hasTable('ProjectTranslation')) {
            Schema::create('ProjectTranslation', function (Blueprint $table) {
                $table->id('translationID');
                $table->foreignId('projectID')->constrained('Project', 'projectID')->cascadeOnDelete();
                $table->string('languageCode', 5);
                $table->foreign('languageCode')->references('languageCode')->on('Language');
                $table->string('title');
                $table->text('abstract')->nullable();
                $table->text('objectives')->nullable();
                $table->text('targetGroups')->nullable();
                $table->text('keyResults')->nullable();
                $table->text('publicDeliverables')->nullable();
                $table->text('publications')->nullable();
                $table->unique(['projectID', 'languageCode']);
            });
        }

        if (!Schema::hasTable('ProjectPartner')) {
            Schema::create('ProjectPartner', function (Blueprint $table) {
                $table->foreignId('projectID')->constrained('Project', 'projectID')->cascadeOnDelete();
                $table->foreignId('partnerID')->constrained('Partner', 'partnerID')->cascadeOnDelete();
                $table->enum('partnerRole', ['coordinator', 'associate_partner', 'funding_partner']);
                $table->primary(['projectID', 'partnerID']);
            });
        }

        if (!Schema::hasTable('ProjectDocument')) {
            Schema::create('ProjectDocument', function (Blueprint $table) {
                $table->foreignId('projectID')->constrained('Project', 'projectID')->cascadeOnDelete();
                $table->foreignId('documentID')->constrained('Document', 'documentID')->cascadeOnDelete();
                $table->primary(['projectID', 'documentID']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ProjectDocument');
        Schema::dropIfExists('ProjectPartner');
        Schema::dropIfExists('ProjectTranslation');
        Schema::dropIfExists('Project');
    }
};
