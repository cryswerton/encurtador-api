<?php

namespace Tests\Unit;

use Tests\TestCase; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Link;
use App\Models\User;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_link_can_be_created()
    {

        $user = User::factory()->create();

        $link = new Link();
        $link->user_id = $user->id;
        $link->title = 'Link para o Google';
        $link->destination = 'http://google.com';
        $link->short_link = 'curto.tech/google';
        $link->save();

        $this->assertCount(1, Link::all());
    }
}
