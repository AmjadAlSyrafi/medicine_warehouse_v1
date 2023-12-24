<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\company;
use App\Models\Classification;
use Database\Factories\CompanyOfMedicineFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scientific_name' => $this->faker->word(),
            'trade_name' => $this->faker->word(),
            'classification_id' => Classification::factory(),
            'company_name_id' => company::factory(),
            'available_quantity' => $this->faker->numberBetween(1, 100),
            'expiry_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
