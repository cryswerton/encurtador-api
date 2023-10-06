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
        $this->withoutExceptionHandling();

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

    public function test_the_link_clicks_count_rises()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create();

        $response = $this->get('/link-test');
        $response = $this->get('/link-test');
        $response = $this->get('/link-test');

        $link->refresh();

        $response->assertStatus(301);
        $this->assertEquals($link->clicks, 3);
    }
}
