<?php

namespace Modules\AuthManagement\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\AuthManagement\Models\Position::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->optional(0.4)->sentence(3, true),
            'active' => fake()->boolean()
        ];
    }


    public function repeatedUsers(): static
    {
        return $this->state(function () {
            return [
                'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            ];
        });
    }
}
