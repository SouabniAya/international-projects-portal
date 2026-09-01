<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Notification')) {
            Schema::create('Notification', function (Blueprint $table) {
                $table->id('notificationID');
                $table->string('type', 50);
                $table->text('content');
                $table->boolean('isRead')->default(false);
                $table->dateTime('createdAt')->useCurrent();
                $table->foreignId('userID')->constrained('User', 'userID')->cascadeOnDelete();
                $table->index(['userID', 'isRead']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Notification');
    }
};
