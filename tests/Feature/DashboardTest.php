<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_admin_dashboard_page_loads(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Overview Dashboard');
    }
}
