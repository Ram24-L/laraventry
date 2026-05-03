<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => $this->faker->company(),
            'contact_name' => $this->faker->name(),
            'phone'        => $this->faker->phoneNumber(),
            'email'        => $this->faker->companyEmail(),
            'address'      => $this->faker->address(),
            'is_active'    => $this->faker->boolean(85),
        ];
    }
}
