<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [ 'user_id' => \App\Models\User::factory(),
            'pharmacy_name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(31.5, 32.5),   // حسب فلسطين
            'longitude' => $this->faker->longitude(34.0, 35.5),
            'license_image' => 'uploads/licenses/' . $this->faker->image('public/uploads/licenses', 400, 400, null, false),
            'logo' => 'uploads/logos/' . $this->faker->image('public/uploads/avatars', 300, 300, null, false),
            'is_approved' => $this->faker->boolean(),
            //
        ];
    }
}
