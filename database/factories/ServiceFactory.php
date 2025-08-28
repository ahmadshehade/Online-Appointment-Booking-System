<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Appointments\Models\Category;
use Modules\Appointments\Models\Service;
use Modules\Users\Models\ServiceProvider;

/**
 * Summary of ServiceFactory
 */
class ServiceFactory extends Factory
{

    protected $model = Service::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_provider_id' => ServiceProvider::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(20),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
