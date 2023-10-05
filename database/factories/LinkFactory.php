<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {   //fake()->name()
        $slug = 'link-test';
        $shortLink = env('APP_URL') . '/' . $slug;

        return [
            'title' => 'Link Test',
            'slug' => $slug,
            'user_id' => User::factory(),
            'destination' => 'http://google.com',
            'short_link' => $shortLink,
        ];
    }
}
