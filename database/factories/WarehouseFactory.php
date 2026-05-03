<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->city();

        return [
            'name'      => 'Gudang '.$name,
            'code'      => strtoupper($this->faker->unique()->lexify('WH-???')),
            'address'   => $this->faker->address(),
            'is_active' => true,
        ];
    }
}
