<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('EventRegistration')) {
            Schema::create('EventRegistration', function (Blueprint $table) {
                $table->id('registrationID');
                $table->foreignId('eventID')->constrained('Event', 'eventID')->cascadeOnDelete();
                $table->foreignId('userID')->constrained('User', 'userID')->cascadeOnDelete();
                $table->string('status', 50)->default('registered');
                $table->timestamps();
                $table->unique(['eventID', 'userID']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('EventRegistration');
    }
};
