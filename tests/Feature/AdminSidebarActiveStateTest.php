<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminSidebarActiveStateTest extends TestCase
{
    public function test_admin_sidebar_marks_active_section_for_route_based_pages(): void
    {
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

        foreach ([
            'admin.dashboard' => '/admin/dashboard',
            'admin.content-management' => '/admin/cooperation',
            'admin.events' => '/admin/events',
            'admin.partner-management' => '/admin/partner-management',
            'admin.agreements' => '/admin/agreements',
            'admin.projects' => '/admin/projects',
            'admin.funding-programmes' => '/admin/funding-programmes',
            'admin.calls' => '/admin/calls',
            'admin.mobility' => '/admin/mobility',
            'admin.requests-documents' => '/admin/requests-documents',
            'admin.users.index' => '/admin/users',
            'admin.settings' => '/admin/settings',
        ] as $routeName => $path) {
            Route::middleware('web')->get($path, function () use ($path) {
                return view('components.admin-sidebar');
            })->name($routeName);

            $response = $this->get($path);
            $response->assertOk();
            $response->assertSee('href="' . $path . '" aria-current="page"', false);
        }
    }
}
