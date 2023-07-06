<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'app_url' => $this->faker->url(),
            'android_url' => $this->faker->url(),
            'huawei_url' => $this->faker->url(),
            'ios_url' => $this->faker->url(),
            'fallback_url' => $this->faker->url(),
            'html' => '...',
        ];
    }
}
