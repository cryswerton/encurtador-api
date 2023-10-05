<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_a_link_cannot_be_found()
    {
        $response = $this->get('/link-slug');

        $response->assertStatus(404);
    }

    public function test_a_short_link_can_go_to_its_destination()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create();

        $response = $this->get('/link-test');

        $response->assertStatus(301);
    }
}
