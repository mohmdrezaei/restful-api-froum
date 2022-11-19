<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name
        ];
    }
}
