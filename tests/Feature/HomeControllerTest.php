<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function test_home_page_loads_when_project_tables_are_missing(): void
    {
        $this->assertFalse(Schema::hasTable('HomeNewsHighlight') || Schema::hasTable('Project') || Schema::hasTable('Event'));

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('newsItems', []);
        $response->assertViewHas('eventItems', []);
        $response->assertViewHas('homeCalls', []);
        $response->assertViewHas('homeProjects', []);
    }
}
