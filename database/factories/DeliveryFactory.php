<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $company = Company::all()->random();

        $weight = $this->faker->randomFloat(2, 12, 6987);
        $price = $company->getPriceByFormulaForSpecificCompany($weight);

        return [
            'company_id' => $company->getAttribute('id'),
            'weight' => $weight,
            'price' => $price,
            'name' => $this->faker->randomElement(['Table', 'Car', 'Shoes', 'Weapon', 'Drugs', 'Documents']),
            'description' => $this->faker->text(10),
        ];
    }
}
