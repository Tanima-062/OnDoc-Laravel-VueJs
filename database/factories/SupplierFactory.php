<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id'    =>  Company::inRandomOrder()->first()->id,
            'name'      =>  $this->faker->company,
            'street'    =>  $this->faker->streetName(),
            'house_number'  =>  $this->faker->buildingNumber(),
            'postal_code'   =>  $this->faker->postcode(),
            'city'          =>  $this->faker->city(),
            'country_code'  =>  $this->faker->countryCode(),
            'contact_persion_name'  =>  $this->faker->name(),
            'contact_persion_email' =>  $this->faker->safeEmail
        ];
    }
}
