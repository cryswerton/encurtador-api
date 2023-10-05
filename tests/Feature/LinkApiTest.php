<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Link;
use App\Models\User;

class LinkApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_links_success()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $links = Link::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('/api/links');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_get_links_with_no_content()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/links');

        $response->assertStatus(204);
    }

    public function test_get_link_success()
    {
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson("/api/links/{$link->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
        $response->assertJsonStructure(['user_id']);
        $response->assertJsonStructure(['title']);
        $response->assertJsonStructure(['destination']);
        $response->assertJsonStructure(['short_link']);
        $response->assertJsonStructure(['created_at']);
        $response->assertJsonStructure(['updated_at']);
    }

    public function test_get_link_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson("/api/links/1");

        $response->assertStatus(404);
        $response->assertJsonStructure(['error']);
    }

    public function test_post_link_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory(1)->makeOne()->toArray();

        $response = $this->post("/api/links", $link);

        $data = $response->json();

        $response->assertStatus(201);
        $this->assertEquals($link['title'], $data['title']);
        $this->assertEquals($link['destination'], $data['destination']);
        $this->assertEquals($data['user_id'], $user->id);
        $this->assertEquals($data['short_link'], env('APP_URL') . '/' . $data['slug']);
    }

    public function test_post_link_title_not_unique()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create()->toArray();

        $response = $this->post("/api/links", $link);

        $data = $response->json();

        $response->assertStatus(422);
        $this->assertNotEmpty($data['errors']['title']);
    }

    public function test_put_link_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'title' => 'title update',
            'destination' => 'destination update',
        ];

        $response = $this->put("/api/links/{$link->id}", $data);

        $dataResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($dataResponse['title'], $data['title']);
        $this->assertEquals($dataResponse['destination'], $data['destination']);
    }

    public function test_put_link_title_not_unique()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'title' => $link->title,
            'destination' => 'destination update',
        ];

        $response = $this->put("/api/links/{$link->id}", $data);

        $dataResponse = $response->json();

        $response->assertStatus(422);
        $this->assertNotEmpty($dataResponse['errors']['title']);
    }

    public function test_put_link_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'title update',
            'destination' => 'destination update',
            'short_link' => 'short link update',
        ];

        $response = $this->put("/api/links/1", $data);

        $dataResponse = $response->json();

        $response->assertStatus(404);
        $this->assertNotEmpty($dataResponse['error']);
    }

    public function test_patch_link_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'title' => 'title update',
        ];

        $response = $this->put("/api/links/{$link->id}", $data);

        $dataResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($dataResponse['title'], $data['title']);
    }

    public function test_patch_link_title_not_unique()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'title' => $link->title,
        ];

        $response = $this->put("/api/links/{$link->id}", $data);

        $dataResponse = $response->json();

        $response->assertStatus(422);
        $this->assertNotEmpty($dataResponse['errors']['title']);
    }

    public function test_patch_link_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'title update',
        ];

        $response = $this->put("/api/links/1", $data);

        $dataResponse = $response->json();

        $response->assertStatus(404);
        $this->assertNotEmpty($dataResponse['error']);
    }

    public function test_delete_link_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete("/api/links/{$link->id}");

        $response->assertStatus(204);
    }

    public function test_delete_link_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->delete("/api/links/1");

        $data = $response->json();

        $response->assertStatus(404);
        $this->assertNotEmpty($data['error']);
    }
}
