<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TestimonialControllerTest extends TestCase
{
    public function test_submit_testimonial_page_loads_when_country_table_is_missing(): void
    {
        $this->assertFalse(Schema::hasTable('Country') || Schema::hasTable('country'));

        $response = $this->get(route('testimonials.create'));

        $response->assertOk();
        $response->assertViewHas('countries', []);
        $response->assertViewHas('projects', []);
        $response->assertViewHas('mobilities', []);
    }
}
