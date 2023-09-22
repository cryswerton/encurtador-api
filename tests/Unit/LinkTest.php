<?php

namespace Tests\Unit;

use Tests\TestCase; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Link;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_link_can_be_created()
    {
        $link = new Link();
        $link->title = 'Link para o Google';
        $link->destination = 'http://google.com';
        $link->short_link = 'curto.tech/google';
        $link->save();

        $this->assertCount(1, Link::all());
    }
}
