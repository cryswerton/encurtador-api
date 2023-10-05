<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Link;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'destination' => $this->faker->sentence,
            'short_link' => $this->faker->sentence,
            'user_id' => User::factory(),
        ];
    }
}
