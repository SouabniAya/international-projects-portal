<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Agreement')) {
            Schema::create('Agreement', function (Blueprint $table) {
                $table->id('agreementID');
                $table->string('agreementType', 100)->nullable();
                $table->date('signatureDate');
                $table->date('startDate');
                $table->date('endDate');
                $table->enum('status', ['active', 'expired']);
                $table->foreignId('partnerID')->constrained('Partner', 'partnerID');
                $table->enum('publicationStatus', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
                $table->dateTime('publishedAt')->nullable();
                $table->dateTime('scheduledAt')->nullable();
                $table->foreignId('publishedByUserID')->nullable()->constrained('User', 'userID');
            });
        }

        if (!Schema::hasTable('AgreementTranslation')) {
            Schema::create('AgreementTranslation', function (Blueprint $table) {
                $table->id('translationID');
                $table->foreignId('agreementID')->constrained('Agreement', 'agreementID')->cascadeOnDelete();
                $table->string('languageCode', 5);
                $table->foreign('languageCode')->references('languageCode')->on('Language');
                $table->string('title');
                $table->unique(['agreementID', 'languageCode']);
            });
        }

        if (!Schema::hasTable('AgreementDocument')) {
            Schema::create('AgreementDocument', function (Blueprint $table) {
                $table->foreignId('agreementID')->constrained('Agreement', 'agreementID')->cascadeOnDelete();
                $table->foreignId('documentID')->constrained('Document', 'documentID')->cascadeOnDelete();
                $table->primary(['agreementID', 'documentID']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('AgreementDocument');
        Schema::dropIfExists('AgreementTranslation');
        Schema::dropIfExists('Agreement');
    }
};
