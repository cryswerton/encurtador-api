<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;

class LinkApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_links_success()
    {

        $links = Link::factory()->count(3)->create();

        $response = $this->getJson('/api/links');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_get_single_link_success()
    {

        $link = Link::factory()->create();

        $response = $this->getJson("/api/links/{$link->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
        $response->assertJsonStructure(['title']);
        $response->assertJsonStructure(['destination']);
        $response->assertJsonStructure(['short_link']);
        $response->assertJsonStructure(['created_at']);
        $response->assertJsonStructure(['updated_at']);
    }
}
