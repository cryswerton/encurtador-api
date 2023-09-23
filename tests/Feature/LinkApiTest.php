<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;

class LinkApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_links_endpoint()
    {

        $links = Link::factory()->count(3)->create();

        $response = $this->getJson('/api/links');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
