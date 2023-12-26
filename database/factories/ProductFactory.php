<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => \App\Models\Group::factory()->create()->id,
            'variant_id' => \App\Models\Variant::factory()->create()->id,
            'name' => fake()->name(),
            'price' => rand(500, 1000),
            'description' =>  fake()->text(),
        ];
    }
}
