<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Appointments\Models\Category;


/**
 * Summary of CategoryFactory
 */
class CategoryFactory extends Factory
{

    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name,
        ];
    }
}
