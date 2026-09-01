<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminNewsAndEventsNavigationTest extends TestCase
{
    public function test_admin_news_and_events_pages_are_available_and_render_with_sidebar(): void
    {
        Schema::create('Event', function (Blueprint $table) {
            $table->increments('eventID');
            $table->string('eventType')->nullable();
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->string('location')->nullable();
            $table->string('publicationStatus')->default('draft');
        });

        Schema::create('EventTranslation', function (Blueprint $table) {
            $table->increments('translationID');
            $table->unsignedInteger('eventID');
            $table->string('languageCode');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('News', function (Blueprint $table) {
            $table->increments('newsID');
            $table->string('image')->nullable();
            $table->date('publicationDate')->nullable();
            $table->string('publicationStatus')->default('draft');
        });

        Schema::create('NewsTranslation', function (Blueprint $table) {
            $table->increments('translationID');
            $table->unsignedInteger('newsID');
            $table->string('languageCode');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
        });

        Schema::create('Notification', function (Blueprint $table) {
            $table->increments('notificationID');
            $table->unsignedInteger('userID')->nullable();
            $table->boolean('isRead')->default(false);
            $table->text('content')->nullable();
        });

        Schema::create('Role', function (Blueprint $table) {
            $table->increments('roleID');
            $table->string('roleName');
        });

        Schema::create('AssignedRole', function (Blueprint $table) {
            $table->unsignedInteger('userID');
            $table->unsignedInteger('roleID');
        });

        DB::table('Role')->insert(['roleName' => 'Super Admin']);
        DB::table('AssignedRole')->insert(['userID' => 1, 'roleID' => 1]);

        $user = new class extends User {
            public function __construct()
            {
                parent::__construct();
                $this->userID = 1;
                $this->firstName = 'Admin';
                $this->lastName = 'User';
            }

            public function isSuperAdmin(): bool
            {
                return true;
            }

            public function isFunctionalAdmin(): bool
            {
                return true;
            }
        };

        $this->actingAs($user, 'admin');

        $this->get(route('admin.events'))->assertOk();
        $this->get(route('admin.news'))->assertOk();
    }
}
